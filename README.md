# AstraLearn - Learning Management System

**AstraLearn** adalah platform Learning Management System (LMS) berbasis web yang memfasilitasi proses pembelajaran online antara pengajar dan siswa. Aplikasi ini menyediakan fitur lengkap untuk manajemen kursus, materi pembelajaran, penugasan, penilaian, dan penjadwalan kelas.

---

## 📖 Tentang Project

AstraLearn dirancang untuk menjadi solusi pembelajaran online yang mudah digunakan dengan sistem role-based yang membedakan akses antara pengajar dan siswa. Platform ini memungkinkan pengajar untuk membuat dan mengelola kursus, mengupload materi pembelajaran, memberikan tugas, menilai submission siswa, serta mengatur jadwal mengajar. Di sisi lain, siswa dapat mendaftar ke kursus, mempelajari materi secara terstruktur, mengumpulkan tugas, dan melacak progress pembelajaran mereka secara real-time.

---

## ✨ Fitur

### Fitur Umum
- **Authentication System** - Login dan registrasi dengan validasi email unik dan password confirmation
- **Multi-Role System** - Pemisahan akses untuk role Siswa (`siswa`) dan Pengajar (`pengajar`)
- **Role-Based Dashboard** - Dashboard otomatis berdasarkan role pengguna setelah login
- **Profile Management** - Update profil pengguna termasuk nama, email, password, dan foto profil
- **File Upload System** - Support upload gambar dan file dengan validasi ukuran dan tipe file
- **Dark/Light Mode** - Theme switcher untuk kenyamanan visual pengguna
- **Responsive Design** - Tampilan responsif dengan Tailwind CSS untuk semua ukuran layar

### Fitur Pengajar
- **Course Management (CRUD)** - Buat, edit, dan hapus kursus dengan detail lengkap (judul, deskripsi, kategori, gambar)
- **Material Management** - Upload dan kelola materi pembelajaran dengan ordering sequence, support konten teks, video URL, dan file attachment (max 10MB)
- **Assignment Management** - Buat tugas dengan deskripsi, deadline, dan poin maksimal
- **Grading System** - Review submission siswa, beri nilai (0 hingga poin maksimal tugas), dan feedback tertulis
- **Schedule Creator** - Buat jadwal mengajar mingguan dengan waktu mulai/selesai dan lokasi kelas
- **Student Management** - Lihat daftar siswa yang enrolled, dan kemampuan untuk kick siswa dari kursus
- **Real-time Analytics Dashboard** - Statistik meliputi:
  - Total kursus yang dibuat
  - Total siswa yang enrolled di semua kursus
  - Jumlah submission yang belum dinilai
  - Jadwal mengajar yang upcoming
- **Auto Progress Recalculation** - Sistem otomatis menghitung ulang progress siswa ketika materi ditambah/dihapus

### Fitur Siswa
- **Course Exploration** - Browse dan cari kursus yang tersedia untuk di-enroll
- **Course Enrollment** - Daftar ke kursus dengan sistem anti-duplikasi
- **Material Learning** - Akses materi pembelajaran secara berurutan dengan navigasi prev/next
- **Progress Tracking** - Sistem otomatis menghitung persentase penyelesaian materi (stored in JSON)
- **Material Completion** - Tandai materi sebagai selesai untuk update progress
- **Assignment Submission** - Upload file tugas (PDF, ZIP, DOC, DOCX, JPG, PNG max 10MB) dengan catatan teks opsional
- **Grade Viewing** - Lihat nilai dan feedback dari pengajar untuk setiap submission
- **Schedule Aggregation** - Lihat jadwal mingguan dari semua kursus yang diikuti
- **Unenroll Function** - Keluar dari kursus dengan automatic cleanup untuk submissions
- **Dashboard Statistics** - Menampilkan:
  - Total kursus yang diikuti
  - Total submission yang dikumpulkan
  - Rata-rata nilai dari semua tugas yang dinilai
  - Daftar kursus enrolled dengan progress percentage

### Fitur Teknis
- **Authorization Middleware** - Custom role middleware untuk proteksi route berdasarkan role
- **Eloquent Relationships** - Relasi lengkap antar model (hasMany, belongsTo, belongsToMany)
- **Cascade Delete** - Automatic cleanup data terkait saat delete (kursus, enrollment, submission)
- **File Storage Management** - Laravel Storage dengan public disk untuk file management
- **Session Management** - Laravel session-based authentication dengan remember token
- **Form Validation** - Server-side validation untuk semua form input
- **JSON Data Storage** - Menyimpan completed materials sebagai JSON array di database

---

## 🛠️ Teknologi

### Backend
- **PHP** `^8.2` - Programming language
- **Laravel Framework** `^12.0` - PHP web application framework
- **Laravel Tinker** `^2.10.1` - REPL untuk Laravel
- **MySQL/SQLite** - Database (SQLite sebagai default)

### Frontend
- **Blade Template Engine** - Laravel templating engine
- **Tailwind CSS** `^4.0.0` - Utility-first CSS framework
- **Vite** `^7.0.7` - Frontend build tool dan dev server
- **Alpine.js** `^3.x.x` (via CDN) - JavaScript framework untuk reactive UI
- **Axios** `^1.11.0` - HTTP client untuk request API

### Development Tools
- **Laravel Vite Plugin** `^2.0.0` - Integrasi Vite dengan Laravel
- **@tailwindcss/vite** `^4.0.0` - Tailwind CSS plugin untuk Vite
- **Concurrently** `^9.0.1` - Menjalankan multiple commands secara bersamaan
- **Laravel Pail** `^1.2.2` - Log viewer untuk development
- **Laravel Pint** `^1.24` - Code style fixer
- **Laravel Sail** `^1.41` - Docker development environment

### Testing
- **PHPUnit** `^11.5.50` - Testing framework
- **Mockery** `^1.6` - Mocking library untuk testing
- **Faker** `^1.23` - Generate fake data untuk testing

---

## 📁 Struktur Project

```
AstraLearn/
├── app/                          # Application logic
│   ├── Http/
│   │   ├── Controllers/          # Request handlers
│   │   │   ├── AuthController.php
│   │   │   ├── PengajarController.php
│   │   │   └── SiswaController.php
│   │   └── Middleware/           # Custom middleware
│   │       └── RoleMiddleware.php
│   ├── Models/                   # Eloquent models
│   │   ├── User.php
│   │   ├── Course.php
│   │   ├── Material.php
│   │   ├── Assignment.php
│   │   ├── Enrollment.php
│   │   ├── Submission.php
│   │   └── Schedule.php
│   └── Providers/                # Service providers
│
├── bootstrap/                    # Framework bootstrap files
│   ├── app.php                   # Application bootstrap
│   └── cache/                    # Framework generated cache
│
├── config/                       # Configuration files
│   ├── app.php                   # App configuration
│   ├── database.php              # Database configuration
│   ├── filesystems.php           # Storage configuration
│   └── ...                       # Other config files
│
├── database/                     # Database files
│   ├── migrations/               # Database migrations
│   ├── factories/                # Model factories
│   ├── seeders/                  # Database seeders
│   └── database.sqlite           # SQLite database file
│
├── public/                       # Public assets (web root)
│   ├── index.php                 # Application entry point
│   ├── build/                    # Vite compiled assets
│   └── storage/                  # Symlink to storage/app/public
│
├── resources/                    # Frontend resources
│   ├── css/
│   │   └── app.css               # Main CSS file
│   ├── js/
│   │   ├── app.js                # Main JavaScript file
│   │   └── bootstrap.js          # Bootstrap JavaScript libraries
│   └── views/                    # Blade templates
│       ├── auth/                 # Authentication views
│       ├── pengajar/             # Teacher views
│       ├── siswa/                # Student views
│       └── layouts/              # Layout templates
│
├── routes/                       # Route definitions
│   ├── web.php                   # Web routes
│   └── console.php               # Console routes
│
├── storage/                      # Application storage
│   ├── app/                      # Application generated files
│   ├── framework/                # Framework files (cache, sessions)
│   └── logs/                     # Application logs
│
├── tests/                        # Automated tests
│
├── artisan                       # Artisan CLI
├── composer.json                 # PHP dependencies
├── package.json                  # Node dependencies
└── vite.config.js                # Vite configuration
```

### Penjelasan Folder Penting:

- **`app/`** - Berisi seluruh logic aplikasi termasuk Models, Controllers, dan Middleware
- **`bootstrap/`** - File untuk bootstrap framework Laravel dan cache aplikasi
- **`config/`** - File konfigurasi untuk database, filesystem, mail, session, dll
- **`database/`** - Migration schema, factory, seeder, dan database SQLite
- **`public/`** - Web root yang accessible secara publik, entry point aplikasi
- **`resources/`** - Asset frontend (CSS, JS, Blade views) sebelum di-compile
- **`routes/`** - Definisi routing untuk web dan console
- **`storage/`** - File yang di-generate aplikasi (upload, cache, log, session)
- **`tests/`** - Unit test dan feature test untuk aplikasi
- **`artisan`** - Command-line interface untuk Laravel
- **`composer.json`** - Dependencies PHP yang dikelola oleh Composer
- **`package.json`** - Dependencies Node.js yang dikelola oleh npm
- **`vite.config.js`** - Konfigurasi Vite untuk build frontend assets

---

## 🚀 Cara Menjalankan Project

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js >= 18 dan npm
- SQLite extension enabled (default) atau MySQL

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/farhanadrianto/AstraLearn.git
   cd AstraLearn
   ```

2. **Install Dependencies PHP**
   ```bash
   composer install
   ```

3. **Install Dependencies Node.js**
   ```bash
   npm install
   ```

4. **Setup Environment File**
   ```bash
   copy .env.example .env
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Konfigurasi Database**
   
   Jika menggunakan SQLite (default):
   - File `database/database.sqlite` sudah tersedia
   
   Jika menggunakan MySQL, edit file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=astralearn
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. **Jalankan Migration Database**
   ```bash
   php artisan migrate
   ```

8. **Create Storage Symlink**
   ```bash
   php artisan storage:link
   ```

9. **Build Frontend Assets**
   
   Untuk development:
   ```bash
   npm run dev
   ```
   
   Untuk production:
   ```bash
   npm run build
   ```

10. **Jalankan Development Server**
    
    Terminal baru (jika npm run dev berjalan di terminal lain):
    ```bash
    php artisan serve
    ```
    
    Atau gunakan composer script untuk menjalankan semua service sekaligus:
    ```bash
    composer dev
    ```

11. **Akses Aplikasi**
    
    Buka browser dan akses:
    ```
    http://localhost:8000
    ```

### Default Login

Setelah instalasi, buat akun baru melalui halaman registrasi:
- Akses: `http://localhost:8000/register`
- Pilih role: **Siswa** atau **Pengajar**
- Isi form registrasi dan login

---

## 🗄️ Struktur Database

Aplikasi ini menggunakan 7 tabel utama:

### 1. **users**
Menyimpan data pengguna (siswa dan pengajar)
- `id`, `name`, `email`, `password`
- `role` - enum('siswa', 'pengajar')
- `profile_photo` - path foto profil

### 2. **courses**
Menyimpan data kursus yang dibuat oleh pengajar
- `id`, `teacher_id` (FK ke users), `title`, `description`
- `category` - kategori kursus
- `image_path` - path gambar kursus

### 3. **materials**
Menyimpan materi pembelajaran untuk setiap kursus
- `id`, `course_id` (FK ke courses), `title`, `content`
- `video_url` - URL video pembelajaran (nullable)
- `file_path` - path file attachment (nullable)
- `order` - urutan materi

### 4. **assignments**
Menyimpan tugas yang diberikan dalam kursus
- `id`, `course_id` (FK ke courses), `title`, `description`
- `due_date` - deadline pengumpulan
- `points` - poin maksimal tugas

### 5. **enrollments**
Menyimpan data pendaftaran siswa ke kursus
- `id`, `student_id` (FK ke users), `course_id` (FK ke courses)
- `progress_percentage` - persentase penyelesaian (0-100)
- `completed_materials` - JSON array ID materi yang selesai
- `completed_at` - timestamp ketika progress mencapai 100%
- Unique constraint: `(student_id, course_id)`

### 6. **submissions**
Menyimpan submission tugas dari siswa
- `id`, `assignment_id` (FK ke assignments), `student_id` (FK ke users)
- `file_path` - path file submission
- `submitted_text` - catatan teks (nullable)
- `grade` - nilai dari pengajar (nullable)
- `feedback` - feedback dari pengajar (nullable)
- `submitted_at` - timestamp submission
- Unique constraint: `(assignment_id, student_id)`

### 7. **schedules**
Menyimpan jadwal mengajar mingguan
- `id`, `course_id` (FK ke courses)
- `day_of_week` - enum(Monday-Sunday)
- `start_time`, `end_time` - waktu kelas
- `location` - lokasi kelas

**Cascade Deleting:**
- Delete course → otomatis hapus materials, assignments, enrollments, schedules
- Delete user → otomatis hapus courses (jika pengajar), enrollments, submissions (jika siswa)
- Delete assignment → otomatis hapus submissions

---

## 🏗️ Arsitektur Aplikasi

Aplikasi ini mengikuti pola **MVC (Model-View-Controller)** dengan Laravel:

### Flow Aplikasi

```
Request → Route → Middleware → Controller → Model → Database
                                    ↓
Response ← View (Blade) ← Controller
```

### Komponen Utama

1. **Route (`routes/web.php`)**
   - Mendefinisikan endpoint URL dan mapping ke controller
   - Menggunakan route grouping untuk guest dan authenticated users
   - Middleware `role:siswa` dan `role:pengajar` untuk proteksi akses

2. **Middleware (`app/Http/Middleware/RoleMiddleware.php`)**
   - Custom middleware untuk role-based access control
   - Validasi role user sebelum akses ke route tertentu
   - Redirect otomatis ke dashboard sesuai role jika akses unauthorized

3. **Controller (`app/Http/Controllers/`)**
   - `AuthController` - Handle login, register, logout
   - `PengajarController` - Handle semua operasi pengajar (CRUD course, materials, assignments, grading, scheduling)
   - `SiswaController` - Handle semua operasi siswa (enrollment, learning, submission, progress tracking)

4. **Model (`app/Models/`)**
   - Eloquent ORM untuk interact dengan database
   - Definisi relationships: hasMany, belongsTo, belongsToMany
   - Casting tipe data (datetime, array/JSON)
   - Helper methods untuk authorization check

5. **View (Blade - `resources/views/`)**
   - Template Blade untuk rendering HTML
   - Layout component-based dengan `layouts/app.blade.php`
   - Separated views untuk auth, pengajar, dan siswa
   - Menggunakan Tailwind CSS utility classes untuk styling
   - Alpine.js untuk interactive UI (modal, tabs, reactive forms)

6. **Database (SQLite/MySQL)**
   - Migration untuk version control database schema
   - Eloquent ORM untuk query builder
   - Foreign keys dengan cascade delete untuk referential integrity

---

## 🎯 Tujuan Project

Project **AstraLearn** dibuat dengan tujuan:

1. **Solusi E-Learning yang Lengkap** - Menyediakan platform pembelajaran online dengan fitur komprehensif mulai dari course management hingga grading system

2. **Implementasi Role-Based System** - Mendemonstrasikan pemisahan access control yang jelas antara pengajar dan siswa menggunakan middleware Laravel

3. **Real-time Progress Tracking** - Menerapkan sistem tracking progress pembelajaran yang dinamis dengan perhitungan otomatis berdasarkan material completion

4. **File Management System** - Implementasi upload, storage, dan validation file untuk berbagai kebutuhan (profile photo, course image, materials, submissions)

5. **Modern UI/UX** - Menerapkan desain modern dengan Tailwind CSS, dark mode support, dan responsive design untuk berbagai device

6. **Database Relationship Mastery** - Praktik implementation relasi database yang kompleks (one-to-many, many-to-many) dengan Eloquent ORM

---

## 📚 Hal yang Dipelajari

Selama pengembangan project **AstraLearn**, berikut adalah konsep dan teknologi yang diterapkan:

### Laravel Framework
- **Routing & Middleware** - Route grouping, middleware alias, role-based access control
- **Eloquent ORM** - Model relationships (hasMany, belongsTo, belongsToMany), eager loading, query optimization
- **Authentication** - Session-based auth, password hashing dengan bcrypt, remember token
- **Authorization** - Custom middleware untuk role authorization, manual gate checks
- **File Storage** - Laravel Storage dengan public disk, file upload validation, automatic cleanup on delete
- **Blade Templating** - Component-based layout, slots, directives, conditional rendering
- **Validation** - Server-side form validation dengan custom rules dan messages
- **Migration** - Database schema versioning, foreign key constraints, cascade deleting

### Database Design
- **Relational Database** - ERD design dengan 7 tabel berelasi
- **Foreign Keys** - Relationship integrity dengan onDelete cascade
- **JSON Storage** - Menyimpan array data (completed_materials) sebagai JSON column
- **Unique Constraints** - Prevent duplicate enrollments dan submissions
- **Enum Types** - Definisi enum untuk role dan day_of_week

### Frontend Development
- **Tailwind CSS** - Utility-first CSS, responsive design, dark mode implementation
- **Alpine.js** - Reactive UI state management untuk modal, tabs, dan dynamic forms
- **Vite** - Modern build tool dengan HMR (Hot Module Replacement) untuk development
- **Blade Components** - Reusable UI components, layout inheritance
- **Accessibility** - Semantic HTML, ARIA labels, keyboard navigation support

### Software Engineering Practices
- **MVC Pattern** - Separation of concerns dengan Model-View-Controller
- **DRY Principle** - Helper methods untuk code reusability
- **Security** - CSRF protection, SQL injection prevention dengan Eloquent, XSS protection
- **Version Control** - Git dengan proper `.gitignore` untuk Laravel projects
- **Dependency Management** - Composer untuk PHP packages, npm untuk Node packages

### Advanced Features
- **Automatic Calculation** - Real-time progress percentage calculation
- **Cascading Operations** - Automatic cleanup saat delete (unenroll, kick student)
- **File Type Validation** - MIME type checking untuk upload security
- **Responsive Dashboard** - Statistics aggregation dengan Eloquent queries
- **Session Flash Messages** - User feedback untuk setiap action (success/error messages)

---

## 📄 Lisensi

Project ini dibuat untuk keperluan **pembelajaran** dan **portfolio**. Anda bebas untuk menggunakan, memodifikasi, dan mendistribusikan project ini untuk tujuan non-komersial dengan tetap menyertakan credit kepada author.

Untuk penggunaan komersial, silakan hubungi author terlebih dahulu.

---

**Developed with ❤️ using Laravel & Tailwind CSS**
