<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Material;
use App\Models\Enrollment;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $studentId = Auth::id();

        // Enrolled courses count
        $coursesCount = Enrollment::where('student_id', $studentId)->count();

        // Submissions count
        $submissionsCount = Submission::where('student_id', $studentId)->count();

        // Average Grade
        $averageGrade = Submission::where('student_id', $studentId)
            ->whereNotNull('grade')
            ->avg('grade') ?? 0;

        // Upcoming schedules from enrolled courses
        $enrolledCourseIds = Enrollment::where('student_id', $studentId)->pluck('course_id');
        $schedules = Schedule::whereIn('course_id', $enrolledCourseIds)
            ->with('course')
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        // Enrolled courses list for dashboard
        $enrollments = Enrollment::where('student_id', $studentId)
            ->with(['course.teacher', 'course.materials'])
            ->get();

        return view('siswa.dashboard', compact('coursesCount', 'submissionsCount', 'averageGrade', 'schedules', 'enrollments'));
    }

    public function profile()
    {
        return view('siswa.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // Max 2MB image
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    public function courses()
    {
        $studentId = Auth::id();
        $enrollments = Enrollment::where('student_id', $studentId)
            ->with([
                'course.teacher',
                'course.materials',
                'course.assignments.submissions' => function($q) use ($studentId) {
                    $q->where('student_id', $studentId);
                }
            ])
            ->get();

        return view('siswa.courses.index', compact('enrollments'));
    }

    public function explore()
    {
        $studentId = Auth::id();
        $enrolledCourseIds = Enrollment::where('student_id', $studentId)->pluck('course_id');
        
        // Find courses student is not enrolled in yet
        $courses = Course::whereNotIn('id', $enrolledCourseIds)
            ->with('teacher')
            ->withCount('materials')
            ->get();

        return view('siswa.courses.explore', compact('courses'));
    }

    public function enroll(Course $course)
    {
        $studentId = Auth::id();

        // Prevent duplicate enrollments
        $exists = Enrollment::where('student_id', $studentId)
            ->where('course_id', $course->id)
            ->exists();

        if (!$exists) {
            Enrollment::create([
                'student_id' => $studentId,
                'course_id' => $course->id,
                'progress_percentage' => 0,
                'completed_materials' => [],
            ]);
        }

        return redirect()->route('siswa.courses.show', $course->id)
            ->with('success', 'Berhasil mendaftar di kursus ' . $course->title);
     }
 
     public function unenroll(Course $course)
     {
         $studentId = Auth::id();
 
         // Delete enrollment
         Enrollment::where('student_id', $studentId)
             ->where('course_id', $course->id)
             ->delete();
 
         // Also delete student's submissions for assignments in this course
         $assignmentIds = $course->assignments()->pluck('id');
         Submission::where('student_id', $studentId)
             ->whereIn('assignment_id', $assignmentIds)
             ->delete();
 
         return redirect()->route('siswa.courses.index')
             ->with('success', 'Anda telah berhasil keluar dari kursus ' . $course->title);
     }

    public function courseShow(Course $course)
    {
        $studentId = Auth::id();
        $enrollment = Enrollment::where('student_id', $studentId)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('siswa.courses.explore')
                ->with('error', 'Anda harus mendaftar di kursus ini terlebih dahulu.');
        }

        $course->load(['teacher', 'materials', 'assignments', 'schedules']);

        // Check if there are assignments and get user's submission state for each
        $assignments = $course->assignments;
        foreach ($assignments as $assignment) {
            $assignment->user_submission = Submission::where('student_id', $studentId)
                ->where('assignment_id', $assignment->id)
                ->first();
        }

        return view('siswa.courses.show', compact('course', 'enrollment', 'assignments'));
    }

    public function materialShow(Material $material)
    {
        $studentId = Auth::id();
        $course = $material->course;

        $enrollment = Enrollment::where('student_id', $studentId)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('siswa.courses.explore')
                ->with('error', 'Anda tidak terdaftar di kursus ini.');
        }

        $allMaterials = $course->materials()->get();

        // Find index of current material for next/prev buttons
        $currentIndex = $allMaterials->pluck('id')->search($material->id);
        $prevMaterial = $currentIndex > 0 ? $allMaterials[$currentIndex - 1] : null;
        $nextMaterial = $currentIndex < count($allMaterials) - 1 ? $allMaterials[$currentIndex + 1] : null;

        // Is completed
        $completedMaterials = $enrollment->completed_materials ?? [];
        $isCompleted = in_array($material->id, $completedMaterials);

        return view('siswa.courses.material', compact('material', 'course', 'allMaterials', 'enrollment', 'prevMaterial', 'nextMaterial', 'isCompleted'));
    }

    public function materialComplete(Material $material)
    {
        $studentId = Auth::id();
        $course = $material->course;

        $enrollment = Enrollment::where('student_id', $studentId)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('siswa.courses.explore')
                ->with('error', 'Anda tidak terdaftar di kursus ini.');
        }

        $completedMaterials = $enrollment->completed_materials ?? [];

        if (!in_array($material->id, $completedMaterials)) {
            $completedMaterials[] = $material->id;
            $enrollment->completed_materials = $completedMaterials;

            // Recalculate progress percentage
            $totalMaterials = $course->materials()->count();
            if ($totalMaterials > 0) {
                $progress = round((count($completedMaterials) / $totalMaterials) * 100);
                $enrollment->progress_percentage = min($progress, 100);
            } else {
                $enrollment->progress_percentage = 100;
            }

            if ($enrollment->progress_percentage >= 100 && !$enrollment->completed_at) {
                $enrollment->completed_at = now();
            }

            $enrollment->save();
        }

        // Get next material
        $allMaterials = $course->materials()->get();
        $currentIndex = $allMaterials->pluck('id')->search($material->id);
        $nextMaterial = $currentIndex < count($allMaterials) - 1 ? $allMaterials[$currentIndex + 1] : null;

        if ($nextMaterial) {
            return redirect()->route('siswa.materials.show', $nextMaterial->id)
                ->with('success', 'Materi diselesaikan! Melanjutkan ke materi berikutnya.');
        }

        return redirect()->route('siswa.courses.show', $course->id)
            ->with('success', 'Selamat! Anda telah menyelesaikan semua materi di kursus ini.');
    }

    public function assignmentShow(Assignment $assignment)
    {
        $studentId = Auth::id();
        $course = $assignment->course;

        $enrollment = Enrollment::where('student_id', $studentId)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('siswa.courses.explore')
                ->with('error', 'Anda tidak terdaftar di kursus ini.');
        }

        $submission = Submission::where('student_id', $studentId)
            ->where('assignment_id', $assignment->id)
            ->first();

        return view('siswa.assignments.show', compact('assignment', 'course', 'submission'));
    }

    public function assignmentSubmit(Assignment $assignment, Request $request)
    {
        $studentId = Auth::id();
        $course = $assignment->course;

        $enrollment = Enrollment::where('student_id', $studentId)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('siswa.courses.explore')
                ->with('error', 'Anda tidak terdaftar di kursus ini.');
        }

        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,zip,doc,docx,jpg,png', 'max:10240'], // Max 10MB
            'submitted_text' => ['nullable', 'string'],
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('submissions', $fileName, 'public');

        Submission::updateOrCreate(
            [
                'assignment_id' => $assignment->id,
                'student_id' => $studentId,
            ],
            [
                'file_path' => $filePath,
                'submitted_text' => $request->submitted_text,
                'submitted_at' => now(),
            ]
        );

        return redirect()->route('siswa.assignments.show', $assignment->id)
            ->with('success', 'Tugas Anda berhasil dikumpulkan!');
    }

    public function schedule()
    {
        $studentId = Auth::id();
        $enrolledCourseIds = Enrollment::where('student_id', $studentId)->pluck('course_id');
        
        $schedules = Schedule::whereIn('course_id', $enrolledCourseIds)
            ->with(['course.teacher'])
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        return view('siswa.schedule.index', compact('schedules'));
    }
}
