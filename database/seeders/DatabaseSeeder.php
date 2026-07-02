<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Material;
use App\Models\Assignment;
use App\Models\Enrollment;
use App\Models\Submission;
use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Teacher
        $teacher = User::create([
            'name' => 'Budi Utomo, M.Kom.',
            'email' => 'teacher@astralearn.com',
            'password' => Hash::make('password'),
            'role' => 'pengajar',
        ]);

        // 2. Create Student
        $student = User::create([
            'name' => 'Andi Pratama',
            'email' => 'student@astralearn.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        // Create secondary test student
        $student2 = User::create([
            'name' => 'Rina Wijaya',
            'email' => 'rina@astralearn.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        // 3. Create Courses
        $course1 = Course::create([
            'teacher_id' => $teacher->id,
            'title' => 'Mastering Laravel 12 for Backend Developers',
            'description' => 'Pelajari framework Laravel 12 dari nol hingga mahir. Kursus ini membahas routing, controller, view dengan Blade, database migration, Eloquent ORM, relasi tabel, REST API, hingga deploy aplikasi ke server produksi secara aman dan efisien.',
            'category' => 'Web Development',
        ]);

        $course2 = Course::create([
            'teacher_id' => $teacher->id,
            'title' => 'Modern UI/UX Design with Glassmorphism',
            'description' => 'Kuasai teknik desain antarmuka modern yang futuristik menggunakan tren Glassmorphic. Pelajari kombinasi background blur, border semi-transparan, gradien warna premium, tipografi berkelas, serta mikro-animasi menggunakan Figma dan CSS.',
            'category' => 'UI/UX Design',
        ]);

        // 4. Create Materials for Course 1
        $material1 = Material::create([
            'course_id' => $course1->id,
            'title' => 'Instalasi & Pengenalan Struktur Laravel 12',
            'content' => "Selamat datang di kursus Laravel 12!\n\nPada materi pertama ini kita akan mempelajari cara instalasi Laravel 12 menggunakan Composer, memahami struktur folder Laravel seperti app, bootstrap, config, database, public, resources, routes, dan storage.\n\nLangkah-langkah Instalasi:\n1. Pastikan PHP versi >= 8.2 dan Composer sudah terinstal di komputer Anda.\n2. Jalankan perintah: composer create-project laravel/laravel nama-proyek\n3. Buka direktori proyek dan jalankan: php artisan serve\n4. Buka http://localhost:8000 di browser Anda untuk melihat halaman sambutan default Laravel.",
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'order' => 1,
        ]);

        $material2 = Material::create([
            'course_id' => $course1->id,
            'title' => 'Mengatur Routing dan Controller',
            'content' => "Routing merupakan pintu masuk utama untuk setiap request yang dikirimkan ke aplikasi Laravel.\n\nDalam materi ini, kita akan membahas cara mendefinisikan route di file routes/web.php, mengelompokkan route dengan middleware, menggunakan parameter route, serta membuat Controller menggunakan Artisan untuk memisahkan logika aplikasi dari file routing.\n\nContoh mendefinisikan route:\nRoute::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');",
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'order' => 2,
        ]);

        $material3 = Material::create([
            'course_id' => $course1->id,
            'title' => 'Eloquent ORM dan Migrasi Database',
            'content' => "Eloquent ORM adalah fitur pemetaan objek-relasional yang sangat kuat di Laravel.\n\nSetiap tabel database memiliki Model padanan yang digunakan untuk berinteraksi dengan tabel tersebut. Pada materi ini kita akan membuat tabel database baru menggunakan file Migration, mendefinisikan struktur kolom, dan mengoperasikan data (Create, Read, Update, Delete) menggunakan metode fluent dari Eloquent.\n\nContoh pengambilan data dengan Eloquent:\n\$users = User::where('role', 'siswa')->get();",
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'order' => 3,
        ]);

        // Materials for Course 2
        Material::create([
            'course_id' => $course2->id,
            'title' => 'Prinsip Dasar Desain Glassmorphism',
            'content' => "Glassmorphism adalah tren desain UI populer yang menonjolkan estetika seperti kaca transparan atau buram.\n\nPrinsip utama Glassmorphism:\n1. Transparansi (menggunakan warna latar belakang dengan opacity/alpha channel rendah, misalnya rgba(255,255,255,0.1)).\n2. Efek blur (menggunakan backdrop-filter: blur() untuk memburamkan elemen di belakang kartu kaca).\n3. Border tipis semi-transparan untuk mempertegas batas kartu kaca.\n4. Bayangan halus di sekeliling kartu untuk memisahkan kedalaman visual (depth perception).",
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'order' => 1,
        ]);

        // 5. Create Assignments for Course 1
        $assignment1 = Assignment::create([
            'course_id' => $course1->id,
            'title' => 'Tugas 1: Integrasi Template Blade & Tailwind',
            'description' => "Instruksi Tugas:\n1. Buatlah halaman tampilan responsif menggunakan Laravel Blade Layouting.\n2. Hubungkan layout tersebut dengan framework styling TailwindCSS.\n3. Buat minimal satu halaman Landing Page statis yang menampilkan kelebihan layanan Anda.\n4. Kompres folder proyek Anda menjadi format ZIP (abaikan folder vendor dan node_modules) dan kumpulkan di sini sebelum batas waktu pengerjaan berakhir.",
            'due_date' => now()->addDays(5),
            'points' => 100,
        ]);

        $assignment2 = Assignment::create([
            'course_id' => $course1->id,
            'title' => 'Tugas 2: CRUD Database dengan Relasi Eloquent',
            'description' => "Instruksi Tugas:\n1. Buatlah database migrasi untuk dua buah tabel yang saling berhubungan (One to Many), contoh: Kategori dan Produk.\n2. Tuliskan logika CRUD lengkap menggunakan Eloquent ORM di Controller masing-masing.\n3. Tampilkan data tersebut di view dalam bentuk tabel modern.\n4. Kumpulkan source code lengkap atau link repository GitHub Anda di kolom catatan pengumpulan tugas.",
            'due_date' => now()->addDays(10),
            'points' => 100,
        ]);

        // 6. Enroll Students & Initial Progress Setup
        // Student 1 (Andi) enrolls in Laravel Course
        $enrollment1 = Enrollment::create([
            'student_id' => $student->id,
            'course_id' => $course1->id,
            'progress_percentage' => 33,
            'completed_materials' => [$material1->id],
        ]);

        // Student 1 (Andi) enrolls in UI/UX Course
        Enrollment::create([
            'student_id' => $student->id,
            'course_id' => $course2->id,
            'progress_percentage' => 0,
            'completed_materials' => [],
        ]);

        // Student 2 (Rina) enrolls in Laravel Course and completes 2 materials (67%)
        Enrollment::create([
            'student_id' => $student2->id,
            'course_id' => $course1->id,
            'progress_percentage' => 67,
            'completed_materials' => [$material1->id, $material2->id],
        ]);

        // 7. Submissions Seed
        // Andi submits Tugas 1
        Submission::create([
            'assignment_id' => $assignment1->id,
            'student_id' => $student->id,
            'file_path' => 'submissions/dummy_tugas1.zip',
            'submitted_text' => 'Halo pak, ini tugas 1 integrasi Blade dan Tailwind buatan saya. Mohon koreksi dan sarannya. Terima kasih.',
            'grade' => null, // Left ungraded for Budi to review
            'submitted_at' => now()->subDay(),
        ]);

        // Rina submits Tugas 1 and already graded
        Submission::create([
            'assignment_id' => $assignment1->id,
            'student_id' => $student2->id,
            'file_path' => 'submissions/dummy_rina_tugas1.zip',
            'submitted_text' => 'Selamat sore Pak Budi, berikut tugas 1 Blade layouting punya saya.',
            'grade' => 95,
            'feedback' => 'Sangat rapi! Penataan layout dan warna gradien Tailwind v4 sangat estetik. Pertahankan kualitas tugas Anda.',
            'submitted_at' => now()->subDays(2),
        ]);

        // 8. Schedules Seed
        // Laravel Class schedules
        Schedule::create([
            'course_id' => $course1->id,
            'day_of_week' => 'Monday',
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'location' => 'Lab Komputer Rekayasa Web (Ruang 304)',
        ]);

        Schedule::create([
            'course_id' => $course1->id,
            'day_of_week' => 'Wednesday',
            'start_time' => '14:00:00',
            'end_time' => '16:00:00',
            'location' => 'https://zoom.us/j/9876543210',
        ]);

        // UI/UX Class schedules
        Schedule::create([
            'course_id' => $course2->id,
            'day_of_week' => 'Friday',
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'location' => 'https://zoom.us/j/1234567890',
        ]);
    }
}
