@extends('layouts.app')

@section('title', 'Kursus Saya')
@section('page-title', 'Kursus Saya')

@section('content')
<div class="space-y-6 animate-fade-in">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-wide">Kursus yang Anda Ikuti</h2>
            <p class="text-xs text-slate-500 dark:text-gray-400">Kelola dan teruskan pembelajaran Anda di sini.</p>
        </div>
        <a href="{{ route('siswa.courses.explore') }}" 
           class="px-5 py-2.5 rounded-xl bg-brand-purple/10 dark:bg-brand-purple/20 text-brand-purple border border-brand-purple/20 dark:border-brand-purple/30 text-xs font-bold hover:bg-brand-purple/20 transition-all">
            Cari Kursus Baru
        </a>
    </div>

    @if($enrollments->isEmpty())
        <div class="glass-card rounded-2xl p-12 text-center text-slate-500 dark:text-gray-400 space-y-4">
            <svg class="w-16 h-16 text-slate-300 dark:text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <h3 class="text-base font-bold text-slate-800 dark:text-white">Belum Ada Kursus</h3>
            <p class="text-xs max-w-sm mx-auto">Anda belum terdaftar pada kelas mana pun saat ini. Cari topik menarik di katalog kami.</p>
            <a href="{{ route('siswa.courses.explore') }}" class="inline-block px-6 py-3 rounded-xl bg-gradient-brand text-white text-xs font-bold shadow-lg shadow-brand-purple/20 hover:shadow-brand-purple/30 transition-all">
                Temukan Kursus
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($enrollments as $enrollment)
                <div class="glass-card rounded-2xl overflow-hidden hover:border-brand-purple/30 transition-all duration-300 flex flex-col justify-between">
                    
                    <!-- Course Image or Category placeholder -->
                    <div class="h-32 bg-slate-100 dark:bg-white/2 relative flex items-center justify-center border-b border-slate-100 dark:border-white/5">
                        @if($enrollment->course->image_path)
                            <img src="{{ asset('storage/' . $enrollment->course->image_path) }}" alt="{{ $enrollment->course->title }}" class="w-full h-full object-cover">
                        @else
                            <!-- Colored mesh pattern -->
                            <div class="absolute inset-0 bg-gradient-to-tr from-brand-purple/10 to-brand-cyan/10 dark:from-brand-purple/20 dark:to-brand-cyan/20 opacity-30"></div>
                            <svg class="w-10 h-10 text-brand-purple opacity-65 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        @endif
                        
                        @if($enrollment->progress_percentage >= 100)
                            <span class="absolute top-3 right-3 text-[10px] font-extrabold tracking-wider bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 px-2.5 py-1 rounded-full uppercase animate-pulse">
                                Selesai
                            </span>
                        @endif
                    </div>

                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <span class="text-[9px] uppercase font-extrabold tracking-wider text-brand-cyan bg-brand-cyan/10 px-2.5 py-0.5 rounded-full">
                                {{ $enrollment->course->category }}
                            </span>
                            <h3 class="text-base font-bold text-slate-800 dark:text-white line-clamp-1 mt-1">{{ $enrollment->course->title }}</h3>
                            <p class="text-xs text-slate-500 dark:text-gray-400 line-clamp-2">{{ $enrollment->course->description }}</p>
                        </div>

                        <div class="space-y-3 pt-2">
                            <!-- Stats counters -->
                            <div class="grid grid-cols-2 gap-2 text-[10px] text-slate-500 dark:text-gray-400 border-t border-slate-100 dark:border-white/5 pt-3">
                                <div>📘 {{ $enrollment->course->materials->count() }} Materi</div>
                                <div>📝 {{ $enrollment->course->assignments->count() }} Tugas</div>
                            </div>

                            <!-- Progress tracker -->
                            <div class="space-y-3 pt-1">
                                <!-- Learning Progress -->
                                <div class="space-y-1">
                                    <div class="flex justify-between text-[10px] font-semibold text-slate-500 dark:text-gray-400">
                                        <span>Progres Belajar</span>
                                        <span class="text-slate-800 dark:text-white">{{ $enrollment->progress_percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 dark:bg-white/5 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-gradient-brand h-full rounded-full transition-all duration-300" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                    </div>
                                </div>

                                <!-- Task Progress -->
                                @php
                                    $course = $enrollment->course;
                                    $totalAssignments = $course->assignments->count();
                                    $submittedCount = $course->assignments->filter(function($assignment) {
                                        return $assignment->submissions->isNotEmpty();
                                    })->count();
                                    $taskProgressPercentage = $totalAssignments > 0 ? round(($submittedCount / $totalAssignments) * 100) : 0;
                                @endphp
                                <div class="space-y-1">
                                    <div class="flex justify-between text-[10px] font-semibold text-slate-500 dark:text-gray-400">
                                        <span>Progres Tugas</span>
                                        <span class="text-slate-800 dark:text-white">{{ $taskProgressPercentage }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 dark:bg-white/5 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-gradient-to-r from-brand-cyan to-brand-blue h-full rounded-full transition-all duration-300" style="width: {{ $taskProgressPercentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 border-t border-slate-100 dark:border-white/5 bg-slate-50/50 dark:bg-white/1">
                        <a href="{{ route('siswa.courses.show', $enrollment->course->id) }}" 
                           class="w-full py-2.5 rounded-xl bg-gradient-brand text-white text-xs font-bold text-center block shadow-lg hover:shadow-brand-purple/20 transition-all duration-200 hover:scale-[1.01]">
                            @if($enrollment->progress_percentage >= 100)
                                Buka Materi Kursus
                            @else
                                Lanjutkan Belajar
                            @endif
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
