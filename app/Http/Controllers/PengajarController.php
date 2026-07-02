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

class PengajarController extends Controller
{
    public function dashboard()
    {
        $teacherId = Auth::id();

        // Stats
        $coursesCount = Course::where('teacher_id', $teacherId)->count();
        
        $myCourseIds = Course::where('teacher_id', $teacherId)->pluck('id');
        
        $totalStudents = Enrollment::whereIn('course_id', $myCourseIds)
            ->distinct('student_id')
            ->count('student_id');

        $pendingGrading = Submission::whereIn('assignment_id', function ($query) use ($myCourseIds) {
            $query->select('id')->from('assignments')->whereIn('course_id', $myCourseIds);
        })->whereNull('grade')->count();

        $schedulesCount = Schedule::whereIn('course_id', $myCourseIds)->count();

        // Upcoming schedule
        $schedules = Schedule::whereIn('course_id', $myCourseIds)
            ->with('course')
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        // Enrolled courses list
        $courses = Course::where('teacher_id', $teacherId)
            ->withCount(['students', 'materials', 'assignments'])
            ->get();

        return view('pengajar.dashboard', compact('coursesCount', 'totalStudents', 'pendingGrading', 'schedulesCount', 'schedules', 'courses'));
    }

    public function coursesIndex()
    {
        $courses = Course::where('teacher_id', Auth::id())
            ->withCount(['students', 'materials', 'assignments'])
            ->get();

        return view('pengajar.courses.index', compact('courses'));
    }

    public function coursesCreate()
    {
        return view('pengajar.courses.create');
    }

    public function coursesStore(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('course_images', 'public');
        }

        Course::create([
            'teacher_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('pengajar.courses.index')
            ->with('success', 'Kursus berhasil dibuat!');
    }

    public function coursesShow(Course $course)
    {
        $this->authorizeTeacher($course);

        $course->load(['materials', 'assignments', 'schedules', 'students']);

        return view('pengajar.courses.show', compact('course'));
    }

    public function coursesEdit(Course $course)
    {
        $this->authorizeTeacher($course);
        return view('pengajar.courses.edit', compact('course'));
    }

    public function coursesUpdate(Course $course, Request $request)
    {
        $this->authorizeTeacher($course);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $course->title = $request->title;
        $course->description = $request->description;
        $course->category = $request->category;

        if ($request->hasFile('image')) {
            if ($course->image_path) {
                Storage::disk('public')->delete($course->image_path);
            }
            $course->image_path = $request->file('image')->store('course_images', 'public');
        }

        $course->save();

        return redirect()->route('pengajar.courses.show', $course->id)
            ->with('success', 'Kursus berhasil diperbarui!');
    }

    public function coursesDestroy(Course $course)
    {
        $this->authorizeTeacher($course);

        if ($course->image_path) {
            Storage::disk('public')->delete($course->image_path);
        }

        $course->delete();

        return redirect()->route('pengajar.courses.index')
            ->with('success', 'Kursus berhasil dihapus!');
    }

    public function kickStudent(Course $course, User $student)
    {
        $this->authorizeTeacher($course);

        // Delete student's enrollment in this course
        Enrollment::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->delete();

        // Delete student's submissions for assignments in this course
        $assignmentIds = $course->assignments()->pluck('id');
        Submission::where('student_id', $student->id)
            ->whereIn('assignment_id', $assignmentIds)
            ->delete();

        return redirect()->route('pengajar.courses.show', $course->id)
            ->with('success', 'Siswa ' . $student->name . ' berhasil dikeluarkan dari kelas.');
    }

    // Materials Management
    public function storeMaterial(Course $course, Request $request)
    {
        $this->authorizeTeacher($course);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'video_url' => ['nullable', 'url'],
            'file' => ['nullable', 'file', 'max:10240'], // 10MB
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('materials', 'public');
        }

        // Get max order value
        $maxOrder = Material::where('course_id', $course->id)->max('order') ?? 0;

        Material::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'content' => $request->content,
            'video_url' => $request->video_url,
            'file_path' => $filePath,
            'order' => $maxOrder + 1,
        ]);

        // Trigger updates to students' progress percentages since total materials count has changed
        $this->recalculateCourseProgress($course);

        return redirect()->route('pengajar.courses.show', $course->id)
            ->with('success', 'Materi berhasil ditambahkan!');
    }

    public function updateMaterial(Material $material, Request $request)
    {
        $course = $material->course;
        $this->authorizeTeacher($course);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'video_url' => ['nullable', 'url'],
            'file' => ['nullable', 'file', 'max:10240'],
        ]);

        $material->title = $request->title;
        $material->content = $request->content;
        $material->video_url = $request->video_url;

        if ($request->hasFile('file')) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $material->file_path = $request->file('file')->store('materials', 'public');
        }

        $material->save();

        return redirect()->route('pengajar.courses.show', $course->id)
            ->with('success', 'Materi berhasil diperbarui!');
    }

    public function destroyMaterial(Material $material)
    {
        $course = $material->course;
        $this->authorizeTeacher($course);

        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        // Recalculate progress for all students
        $this->recalculateCourseProgress($course);

        return redirect()->route('pengajar.courses.show', $course->id)
            ->with('success', 'Materi berhasil dihapus!');
    }

    // Assignments Management
    public function storeAssignment(Course $course, Request $request)
    {
        $this->authorizeTeacher($course);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'due_date' => ['required', 'date'],
            'points' => ['required', 'integer', 'min:1', 'max:1000'],
        ]);

        Assignment::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'points' => $request->points,
        ]);

        return redirect()->route('pengajar.courses.show', $course->id)
            ->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function updateAssignment(Assignment $assignment, Request $request)
    {
        $course = $assignment->course;
        $this->authorizeTeacher($course);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'due_date' => ['required', 'date'],
            'points' => ['required', 'integer', 'min:1', 'max:1000'],
        ]);

        $assignment->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'points' => $request->points,
        ]);

        return redirect()->route('pengajar.courses.show', $course->id)
            ->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroyAssignment(Assignment $assignment)
    {
        $course = $assignment->course;
        $this->authorizeTeacher($course);

        $assignment->delete();

        return redirect()->route('pengajar.courses.show', $course->id)
            ->with('success', 'Tugas berhasil dihapus!');
    }

    public function submissionsIndex()
    {
        $teacherId = Auth::id();
        
        $courses = Course::where('teacher_id', $teacherId)
            ->with([
                'assignments' => function ($query) {
                    $query->orderBy('due_date', 'asc');
                },
                'enrollments.student',
                'assignments.submissions.student'
            ])
            ->get();

        return view('pengajar.submissions.index', compact('courses'));
    }

    public function gradeSubmission(Submission $submission, Request $request)
    {
        $course = $submission->assignment->course;
        $this->authorizeTeacher($course);

        $request->validate([
            'grade' => ['required', 'integer', 'min:0', 'max:' . $submission->assignment->points],
            'feedback' => ['nullable', 'string'],
        ]);

        $submission->update([
            'grade' => $request->grade,
            'feedback' => $request->feedback,
        ]);

        return redirect()->back()
            ->with('success', 'Penilaian tugas berhasil disimpan!');
    }

    // Schedule Creator
    public function scheduleIndex()
    {
        $teacherId = Auth::id();
        $courses = Course::where('teacher_id', $teacherId)->get();
        $courseIds = $courses->pluck('id');

        $schedules = Schedule::whereIn('course_id', $courseIds)
            ->with('course')
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        return view('pengajar.schedule.index', compact('schedules', 'courses'));
    }

    public function storeSchedule(Course $course, Request $request)
    {
        $this->authorizeTeacher($course);

        $request->validate([
            'day_of_week' => ['required', 'string', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'location' => ['required', 'string', 'max:255'],
        ]);

        Schedule::create([
            'course_id' => $course->id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
        ]);

        return redirect()->route('pengajar.schedule.index')
            ->with('success', 'Jadwal mengajar berhasil ditambahkan!');
    }

    public function destroySchedule(Schedule $schedule)
    {
        $this->authorizeTeacher($schedule->course);

        $schedule->delete();

        return redirect()->route('pengajar.schedule.index')
            ->with('success', 'Jadwal mengajar berhasil dihapus!');
    }

    public function updateSchedule(Schedule $schedule, Request $request)
    {
        $this->authorizeTeacher($schedule->course);

        $request->validate([
            'day_of_week' => ['required', 'string', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'start_time' => ['required'],
            'end_time' => ['required', 'after:start_time'],
            'location' => ['required', 'string', 'max:255'],
        ]);

        $schedule->update([
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
        ]);

        return redirect()->route('pengajar.schedule.index')
            ->with('success', 'Jadwal mengajar berhasil diperbarui!');
    }

    // Helper Authorization
    protected function authorizeTeacher(Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan untuk mengelola kursus ini.');
        }
    }

    // Helper function to recalculate enrollment progress after materials change
    protected function recalculateCourseProgress(Course $course)
    {
        $totalMaterials = $course->materials()->count();
        $enrollments = Enrollment::where('course_id', $course->id)->get();

        foreach ($enrollments as $enrollment) {
            $completedMaterials = $enrollment->completed_materials ?? [];
            
            // Clean up any material IDs that no longer exist
            $existingMaterialIds = $course->materials()->pluck('id')->toArray();
            $completedMaterials = array_values(array_intersect($completedMaterials, $existingMaterialIds));
            
            $enrollment->completed_materials = $completedMaterials;

            if ($totalMaterials > 0) {
                $progress = round((count($completedMaterials) / $totalMaterials) * 100);
                $enrollment->progress_percentage = min($progress, 100);
            } else {
                $enrollment->progress_percentage = 0;
            }

            if ($enrollment->progress_percentage >= 100 && !$enrollment->completed_at) {
                $enrollment->completed_at = now();
            } elseif ($enrollment->progress_percentage < 100) {
                $enrollment->completed_at = null;
            }

            $enrollment->save();
        }
    }

    public function profile()
    {
        return view('pengajar.profile', ['user' => Auth::user()]);
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
}
