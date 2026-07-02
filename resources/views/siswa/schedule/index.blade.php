@extends('layouts.app')

@section('title', 'Jadwal Kelas')
@section('page-title', 'Jadwal Kelas Saya')

@section('content')
<div class="space-y-6 animate-fade-in">
    <div>
        <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-wide">Agenda Mingguan</h2>
        <p class="text-xs text-slate-500 dark:text-gray-400">Jadwal pembelajaran dari seluruh kursus yang Anda ikuti saat ini.</p>
    </div>

    @if($schedules->isEmpty())
        <div class="glass-card rounded-2xl p-12 text-center text-slate-500 dark:text-gray-400 space-y-4">
            <svg class="w-16 h-16 text-slate-300 dark:text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-base font-bold text-slate-800 dark:text-white">Tidak Ada Jadwal Kelas</h3>
            <p class="text-xs max-w-sm mx-auto">Anda belum memiliki jadwal kelas aktif karena belum terdaftar pada kelas atau kelas tersebut belum diatur jadwalnya oleh pengajar.</p>
            <a href="{{ route('siswa.courses.index') }}" class="inline-block px-5 py-2.5 rounded-xl bg-brand-purple/10 text-brand-purple border border-brand-purple/20 text-xs font-bold hover:bg-brand-purple/20 transition-all">
                Buka Kelas Saya
            </a>
        </div>
    @else
        <!-- Group Schedules by Day -->
        @php
            $daysOrder = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'];
            $groupedSchedules = $schedules->groupBy('day_of_week');
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($daysOrder as $englishDay => $indonesianDay)
                @if(isset($groupedSchedules[$englishDay]))
                    <div class="glass-card rounded-2xl p-6 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-white/5 pb-3">
                            <span class="text-base font-bold text-slate-800 dark:text-white tracking-wide">{{ $indonesianDay }}</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-brand-purple/10 text-brand-purple font-semibold">
                                {{ count($groupedSchedules[$englishDay]) }} Sesi
                            </span>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach($groupedSchedules[$englishDay] as $schedule)
                                <div class="p-4 rounded-xl border border-slate-100 dark:border-white/5 bg-slate-50/50 dark:bg-white/2 space-y-3 hover:border-brand-cyan/20 transition duration-200">
                                    <div class="space-y-1">
                                        <h4 class="text-sm font-bold text-slate-800 dark:text-white line-clamp-1">{{ $schedule->course->title }}</h4>
                                        <span class="text-[10px] text-slate-450 dark:text-gray-400 font-semibold uppercase tracking-wider">{{ $schedule->course->category }}</span>
                                    </div>
                                    
                                    <div class="space-y-1.5 text-xs text-slate-550 dark:text-gray-400 border-t border-slate-100 dark:border-white/5 pt-3">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-brand-cyan shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }} WIB</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-4 h-4 rounded-full bg-brand-purple/10 dark:bg-brand-purple/20 flex items-center justify-center text-[8px] text-brand-purple dark:text-white font-bold shrink-0">
                                                {{ substr($schedule->course->teacher->name, 0, 1) }}
                                            </div>
                                            <span class="truncate">Guru: <strong class="text-slate-700 dark:text-gray-300 font-semibold">{{ $schedule->course->teacher->name }}</strong></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-brand-cyan shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            @if(str_contains(strtolower($schedule->location), 'http://') || str_contains(strtolower($schedule->location), 'https://'))
                                                <a href="{{ $schedule->location }}" target="_blank" class="text-brand-cyan hover:underline truncate">{{ $schedule->location }}</a>
                                            @else
                                                <span class="truncate text-slate-700 dark:text-gray-300">{{ $schedule->location }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection
