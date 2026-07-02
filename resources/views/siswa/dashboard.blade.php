@extends('layouts.app')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard Belajar')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Welcome Banner -->
    <div class="glass-card rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative">
        <div class="absolute top-[-30%] right-[-10%] w-72 h-72 rounded-full bg-brand-purple/5 dark:bg-brand-purple/20 blur-[60px] pointer-events-none"></div>
        <div class="relative z-10 space-y-2">
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white">Selamat Belajar, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-slate-500 dark:text-gray-400 max-w-xl text-sm md:text-base">
                Siap meningkatkan skill Anda hari ini? Lanjutkan kursus yang sedang berjalan atau cari topik baru untuk dipelajari.
            </p>
        </div>
        <a href="{{ route('siswa.courses.explore') }}" 
           class="relative z-10 shrink-0 px-6 py-3.5 rounded-xl bg-gradient-brand text-white font-bold shadow-lg shadow-brand-purple/30 hover:shadow-brand-purple/40 hover:scale-[1.01] transition-all duration-200 text-sm">
            Eksplorasi Kursus Baru
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Stat 1 -->
        <div class="glass-card rounded-2xl p-6 flex items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Kursus Diikuti</span>
                <span class="text-3xl font-extrabold text-slate-900 dark:text-white block">{{ $coursesCount }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-brand-purple/10 dark:bg-brand-purple/20 flex items-center justify-center text-brand-purple">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>

        <!-- Stat 2 -->
        <div class="glass-card rounded-2xl p-6 flex items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Tugas Dikumpulkan</span>
                <span class="text-3xl font-extrabold text-brand-cyan block">{{ $submissionsCount }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-brand-cyan/10 dark:bg-brand-cyan/20 flex items-center justify-center text-brand-cyan">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
        </div>

        <!-- Stat 3 -->
        <div class="glass-card rounded-2xl p-6 flex items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Rata-rata Nilai</span>
                <span class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 block">{{ number_format($averageGrade, 1) }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 dark:bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Courses in Progress -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-wide">Kursus yang Sedang Berjalan</h3>
                <a href="{{ route('siswa.courses.index') }}" class="text-xs font-bold text-brand-purple hover:underline">Lihat Semua</a>
            </div>

            @if($enrollments->isEmpty())
                <div class="glass-card rounded-2xl p-8 text-center text-slate-500 dark:text-gray-400 space-y-4">
                    <svg class="w-12 h-12 text-slate-300 dark:text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <p class="text-sm">Anda belum mendaftar di kursus apa pun.</p>
                    <a href="{{ route('siswa.courses.explore') }}" class="inline-block px-5 py-2.5 rounded-xl bg-brand-purple/10 text-brand-purple border border-brand-purple/20 text-xs font-bold hover:bg-brand-purple/20 transition-all">Daftar Kursus Sekarang</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($enrollments as $enrollment)
                        <div class="glass-card rounded-2xl overflow-hidden hover:border-brand-purple/30 transition-all duration-300 flex flex-col justify-between">
                            <div class="p-5 space-y-3">
                                <span class="text-[10px] uppercase font-extrabold tracking-wider text-brand-cyan bg-brand-cyan/10 px-2.5 py-1 rounded-full">
                                    {{ $enrollment->course->category }}
                                </span>
                                <h4 class="text-base font-bold text-slate-800 dark:text-white line-clamp-1 mt-1">{{ $enrollment->course->title }}</h4>
                                <p class="text-xs text-slate-500 dark:text-gray-400 line-clamp-2">{{ $enrollment->course->description }}</p>
                                
                                <div class="flex items-center gap-2 mt-4 text-[11px] text-slate-500 dark:text-gray-400">
                                    <div class="w-5 h-5 rounded-full bg-brand-purple/20 flex items-center justify-center text-brand-purple font-bold text-[8px]">
                                        {{ substr($enrollment->course->teacher->name, 0, 1) }}
                                    </div>
                                    <span>Pengajar: <strong class="text-slate-700 dark:text-gray-300">{{ $enrollment->course->teacher->name }}</strong></span>
                                </div>
                            </div>
                            
                            <div class="px-5 py-4 bg-slate-50/50 dark:bg-white/2 border-t border-slate-100 dark:border-white/5 space-y-3">
                                <!-- Progress Bar -->
                                <div class="space-y-1.5">
                                    <div class="flex justify-between text-[11px] font-semibold text-slate-500 dark:text-gray-400">
                                        <span>Progres Belajar</span>
                                        <span class="text-slate-800 dark:text-white">{{ $enrollment->progress_percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 dark:bg-white/5 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-gradient-brand h-full rounded-full transition-all duration-300" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                    </div>
                                </div>
                                
                                <a href="{{ route('siswa.courses.show', $enrollment->course->id) }}" 
                                   class="w-full py-2.5 rounded-xl border border-slate-200 dark:border-white/10 hover:border-brand-purple/30 bg-white dark:bg-brand-purple/5 hover:bg-brand-purple/10 text-xs font-bold text-slate-700 dark:text-white transition-all text-center block">
                                    Lanjutkan Belajar
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Upcoming Classes Schedule -->
        <div class="space-y-4">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-wide">Jadwal Kelas Terdekat</h3>

            @if($schedules->isEmpty())
                <div class="glass-card rounded-2xl p-6 text-center text-slate-500 dark:text-gray-400 space-y-2">
                    <svg class="w-8 h-8 text-slate-300 dark:text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-xs">Tidak ada jadwal kelas minggu ini.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($schedules as $schedule)
                        <div class="glass-card rounded-2xl p-4 flex gap-4 items-start hover:border-brand-cyan/20 transition duration-200">
                            <div class="p-2.5 rounded-xl bg-brand-cyan/10 border border-brand-cyan/20 text-brand-cyan text-center flex flex-col justify-center min-w-[3.5rem]">
                                <span class="text-xs uppercase font-extrabold tracking-wider">{{ substr($schedule->day_of_week, 0, 3) }}</span>
                            </div>
                            <div class="flex-1 min-w-0 space-y-1">
                                <h4 class="text-sm font-bold text-slate-800 dark:text-white truncate">{{ $schedule->course->title }}</h4>
                                <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-gray-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }} WIB</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-gray-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="truncate text-slate-700 dark:text-gray-300">{{ $schedule->location }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
