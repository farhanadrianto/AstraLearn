@extends('layouts.app')

@section('title', 'Kelola Kursus')
@section('page-title', 'Kelola Kursus Saya')

@section('content')
<div class="space-y-6 animate-fade-in">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-wide">Daftar Kursus Anda</h2>
            <p class="text-xs text-slate-500 dark:text-gray-400">Buat dan kelola seluruh konten kursus dan materi belajar Anda.</p>
        </div>
        <a href="{{ route('pengajar.courses.create') }}" 
           class="px-5 py-2.5 rounded-xl bg-gradient-brand text-white text-xs font-bold shadow-lg shadow-brand-purple/20 hover:shadow-brand-purple/30 transition-all hover:scale-[1.01]">
            + Buat Kursus Baru
        </a>
    </div>

    @if($courses->isEmpty())
        <div class="glass-card rounded-2xl p-12 text-center text-slate-500 dark:text-gray-400 space-y-4">
            <svg class="w-16 h-16 text-slate-300 dark:text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <h3 class="text-base font-bold text-slate-800 dark:text-white">Belum Ada Kursus</h3>
            <p class="text-xs max-w-sm mx-auto">Anda belum mempublikasikan kursus pembelajaran. Mulai dengan membuat kelas pembelajaran pertama Anda.</p>
            <a href="{{ route('pengajar.courses.create') }}" class="inline-block px-6 py-3 rounded-xl bg-gradient-brand text-white text-xs font-bold shadow-lg shadow-brand-purple/20 hover:shadow-brand-purple/30 transition-all">
                Mulai Buat Kelas
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($courses as $course)
                <div class="glass-card rounded-2xl overflow-hidden hover:border-brand-purple/30 transition-all duration-300 flex flex-col justify-between">
                    
                    <!-- Course Image Thumbnail -->
                    <div class="h-32 bg-slate-100 dark:bg-white/2 relative flex items-center justify-center border-b border-slate-100 dark:border-white/5">
                        @if($course->image_path)
                            <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 bg-gradient-to-tr from-brand-purple/10 to-brand-cyan/10 dark:from-brand-purple/20 dark:to-brand-cyan/20 opacity-30"></div>
                            <svg class="w-10 h-10 text-brand-purple opacity-65 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <span class="text-[9px] uppercase font-extrabold tracking-wider text-brand-cyan bg-brand-cyan/10 px-2.5 py-0.5 rounded-full">
                                {{ $course->category }}
                            </span>
                            <h3 class="text-base font-bold text-slate-800 dark:text-white line-clamp-1 mt-1">{{ $course->title }}</h3>
                            <p class="text-xs text-slate-500 dark:text-gray-400 line-clamp-2">{{ $course->description }}</p>
                        </div>

                        <!-- Stats indicators -->
                        <div class="grid grid-cols-3 gap-2 text-center text-[10px] text-slate-500 dark:text-gray-450 border-t border-slate-100 dark:border-white/5 pt-3">
                            <div>
                                <strong class="text-slate-800 dark:text-white block text-sm">{{ $course->students_count }}</strong>
                                Siswa Terdaftar
                            </div>
                            <div>
                                <strong class="text-slate-800 dark:text-white block text-sm">{{ $course->materials_count }}</strong>
                                Materi
                            </div>
                            <div>
                                <strong class="text-slate-800 dark:text-white block text-sm">{{ $course->assignments_count }}</strong>
                                Tugas Kelas
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="p-5 border-t border-slate-100 dark:border-white/5 bg-slate-50/50 dark:bg-white/1 flex gap-2">
                        <a href="{{ route('pengajar.courses.show', $course->id) }}" 
                           class="flex-1 py-2.5 rounded-xl bg-gradient-brand text-white text-xs font-bold text-center block shadow-lg hover:shadow-brand-purple/20 transition-all duration-200">
                            Kelola Kelas
                        </a>
                        <a href="{{ route('pengajar.courses.edit', $course->id) }}" 
                           class="px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-white/10 hover:border-brand-cyan/30 bg-slate-100 dark:bg-white/5 hover:bg-brand-cyan/10 text-slate-700 dark:text-white transition-all flex items-center justify-center">
                            <svg class="w-4 h-4 text-slate-400 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
