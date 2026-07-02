@extends('layouts.app')

@section('title', $course->title)
@section('page-title', 'Detail Kursus')

@section('content')
<div class="space-y-8 animate-fade-in" x-data="{ tab: 'materi', leaveModalOpen: false, leaveConfirmText: '' }">
    <!-- Back link -->
    <a href="{{ route('siswa.courses.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white transition duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali ke Kursus Saya</span>
    </a>

    <!-- Course Banner Details -->
    <div class="glass-card rounded-2xl p-6 md:p-8 flex flex-col md:flex-row gap-6 justify-between items-start md:items-center relative overflow-hidden">
        <div class="space-y-3 relative z-10">
            <span class="text-[10px] uppercase font-extrabold tracking-wider text-brand-cyan bg-brand-cyan/10 px-2.5 py-1 rounded-full">
                {{ $course->category }}
            </span>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white">{{ $course->title }}</h2>
            <p class="text-slate-500 dark:text-gray-400 text-sm md:text-base max-w-2xl">{{ $course->description }}</p>
            
            <div class="flex items-center gap-3 pt-2">
                <div class="w-8 h-8 rounded-full bg-brand-purple/10 dark:bg-brand-purple/20 flex items-center justify-center font-bold text-xs text-brand-purple dark:text-white">
                    {{ substr($course->teacher->name, 0, 1) }}
                </div>
                <div class="text-xs text-slate-500 dark:text-gray-400">
                    <span>Diajar oleh:</span>
                    <p class="font-bold text-slate-800 dark:text-white">{{ $course->teacher->name }}</p>
                </div>
            </div>
        </div>

        <!-- Progress Widget -->
        <div class="w-full md:w-64 glass-card p-5 rounded-xl border border-slate-100 dark:border-white/5 space-y-4 shrink-0 relative z-10 bg-slate-50/50 dark:bg-white/2">
            <!-- Learning Progress -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between text-xs text-slate-500 dark:text-gray-400 font-semibold">
                    <span>Progres Belajar</span>
                    <span class="text-slate-900 dark:text-white font-bold">{{ $enrollment->progress_percentage }}%</span>
                </div>
                <div class="w-full bg-slate-100 dark:bg-white/5 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-gradient-brand h-full rounded-full transition-all duration-300" style="width: {{ $enrollment->progress_percentage }}%"></div>
                </div>
                <p class="text-[9px] text-slate-450 dark:text-gray-500 text-center">
                    {{ count($enrollment->completed_materials ?? []) }} dari {{ $course->materials->count() }} materi selesai
                </p>
            </div>

            <div class="border-t border-slate-200/50 dark:border-white/5"></div>

            <!-- Task Progress -->
            @php
                $totalAssignments = $course->assignments->count();
                $submittedAssignmentsCount = $course->assignments->filter(function($assignment) {
                    return $assignment->user_submission !== null;
                })->count();
                $taskProgressPercentage = $totalAssignments > 0 ? round(($submittedAssignmentsCount / $totalAssignments) * 100) : 0;
            @endphp
            <div class="space-y-1.5">
                <div class="flex items-center justify-between text-xs text-slate-500 dark:text-gray-400 font-semibold">
                    <span>Progres Tugas</span>
                    <span class="text-slate-900 dark:text-white font-bold">{{ $taskProgressPercentage }}%</span>
                </div>
                <div class="w-full bg-slate-100 dark:bg-white/5 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-gradient-to-r from-brand-cyan to-brand-blue h-full rounded-full transition-all duration-300" style="width: {{ $taskProgressPercentage }}%"></div>
                </div>
                <p class="text-[9px] text-slate-450 dark:text-gray-500 text-center">
                    {{ $submittedAssignmentsCount }} dari {{ $totalAssignments }} tugas selesai
                </p>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-slate-200 dark:border-white/5 gap-4 select-none pb-2 sm:pb-0">
        <div class="flex gap-2 overflow-x-auto">
            <button class="px-6 py-3.5 font-bold text-sm tracking-wide border-b-2 transition duration-200 focus:outline-none shrink-0"
                    :class="tab === 'materi' ? 'border-brand-purple text-slate-900 dark:text-white bg-slate-50 dark:bg-white/[0.02]' : 'border-transparent text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white'"
                    @click="tab = 'materi'">
                📘 Materi Pembelajaran ({{ $course->materials->count() }})
            </button>
            <button class="px-6 py-3.5 font-bold text-sm tracking-wide border-b-2 transition duration-200 focus:outline-none shrink-0"
                    :class="tab === 'tugas' ? 'border-brand-purple text-slate-900 dark:text-white bg-slate-50 dark:bg-white/[0.02]' : 'border-transparent text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white'"
                    @click="tab = 'tugas'">
                📝 Tugas ({{ $course->assignments->count() }})
            </button>
            <button class="px-6 py-3.5 font-bold text-sm tracking-wide border-b-2 transition duration-200 focus:outline-none shrink-0"
                    :class="tab === 'jadwal' ? 'border-brand-purple text-slate-900 dark:text-white bg-slate-50 dark:bg-white/[0.02]' : 'border-transparent text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white'"
                    @click="tab = 'jadwal'">
                ⏰ Jadwal Kelas
            </button>
        </div>

        <!-- Leave Course Button -->
        <button type="button" @click="leaveConfirmText = ''; leaveModalOpen = true"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-red-500/20 bg-red-500/5 hover:bg-red-500/10 text-xs font-bold text-red-500 dark:text-red-400 transition-all cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span>Keluar Kursus</span>
        </button>
    </div>

    <!-- Tab Contents -->
    <div>
        <!-- TAB MATERI -->
        <div x-show="tab === 'materi'" class="space-y-4">
            @if($course->materials->isEmpty())
                <div class="glass-card rounded-2xl p-12 text-center text-slate-500 dark:text-gray-400">
                    <p class="text-sm">Belum ada materi pembelajaran yang ditambahkan.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($course->materials as $index => $material)
                        @php
                            $completedMaterials = $enrollment->completed_materials ?? [];
                            $isCompleted = in_array($material->id, $completedMaterials);
                        @endphp
                        <a href="{{ route('siswa.materials.show', $material->id) }}" 
                           class="glass-card rounded-xl p-5 flex items-center justify-between gap-4 hover:border-brand-purple/20 transition-all duration-200 group">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/5 flex items-center justify-center font-bold text-xs text-slate-500 dark:text-gray-400 group-hover:bg-brand-purple/10 dark:group-hover:bg-brand-purple/20 group-hover:text-brand-purple transition duration-200">
                                    {{ $index + 1 }}
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-sm font-bold text-slate-800 dark:text-white truncate">{{ $material->title }}</h4>
                                    <p class="text-[11px] text-slate-500 dark:text-gray-400 line-clamp-1 mt-0.5">{{ strip_tags($material->content) }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                @if($isCompleted)
                                    <span class="text-xs px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 font-bold uppercase tracking-wider text-[9px]">Selesai</span>
                                @else
                                    <span class="text-xs px-2.5 py-1 rounded-full bg-slate-100 dark:bg-white/5 text-slate-500 dark:text-gray-400 border border-slate-200 dark:border-white/5 font-bold uppercase tracking-wider text-[9px]">Belum Dibaca</span>
                                @endif
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-slate-800 dark:group-hover:text-white transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- TAB TUGAS -->
        <div x-show="tab === 'tugas'" class="space-y-4">
            @if($course->assignments->isEmpty())
                <div class="glass-card rounded-2xl p-12 text-center text-slate-500 dark:text-gray-400">
                    <p class="text-sm">Belum ada tugas untuk kursus ini.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($assignments as $assignment)
                        @php
                            $sub = $assignment->user_submission;
                        @endphp
                        <a href="{{ route('siswa.assignments.show', $assignment->id) }}" 
                           class="glass-card rounded-xl p-5 flex items-center justify-between gap-4 hover:border-brand-purple/20 transition-all duration-200 group">
                            <div class="min-w-0 space-y-1">
                                <h4 class="text-sm font-bold text-slate-800 dark:text-white truncate">{{ $assignment->title }}</h4>
                                <div class="flex items-center gap-3 text-[11px] text-slate-500 dark:text-gray-400">
                                    <span>Batas Pengumpulan: <strong class="text-slate-700 dark:text-gray-300">{{ $assignment->due_date->format('d M Y, H:i') }}</strong></span>
                                    <span>&bull;</span>
                                    <span>Poin Maksimal: <strong class="text-brand-purple">{{ $assignment->points }}</strong></span>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                @if($sub)
                                    @if($sub->grade !== null)
                                        <span class="text-xs px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 font-bold uppercase tracking-wider text-[9px]">
                                            Nilai: {{ $sub->grade }}/{{ $assignment->points }}
                                        </span>
                                    @else
                                        <span class="text-xs px-2.5 py-1 rounded-full bg-brand-cyan/10 text-brand-cyan border border-brand-cyan/20 font-bold uppercase tracking-wider text-[9px]">
                                            Diserahkan
                                        </span>
                                    @endif
                                @else
                                    @if($assignment->due_date->isPast())
                                        <span class="text-xs px-2.5 py-1 rounded-full bg-red-500/10 text-red-500 dark:text-red-400 border border-red-500/20 font-bold uppercase tracking-wider text-[9px]">
                                            Terlambat
                                        </span>
                                    @else
                                        <span class="text-xs px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 font-bold uppercase tracking-wider text-[9px]">
                                            Belum Selesai
                                        </span>
                                    @endif
                                @endif
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-slate-800 dark:group-hover:text-white transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- TAB JADWAL -->
        <div x-show="tab === 'jadwal'" class="space-y-4">
            @if($course->schedules->isEmpty())
                <div class="glass-card rounded-2xl p-12 text-center text-slate-500 dark:text-gray-400">
                    <p class="text-sm">Belum ada jadwal kelas terjadwal untuk kursus ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($course->schedules as $schedule)
                        <div class="glass-card rounded-2xl p-5 flex gap-4 items-start">
                            <div class="p-3 rounded-xl bg-brand-cyan/10 border border-brand-cyan/20 text-brand-cyan text-center flex flex-col justify-center min-w-[4rem]">
                                <span class="text-xs uppercase font-extrabold tracking-wider">{{ $schedule->day_of_week }}</span>
                            </div>
                            
                            <div class="space-y-1 text-sm">
                                <h4 class="font-bold text-slate-800 dark:text-white">Sesi Kelas</h4>
                                <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-gray-400">
                                    <span>{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }} WIB</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-xs text-brand-cyan font-semibold">
                                    <span class="truncate">{{ $schedule->location }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <!-- Custom Leave Course Confirmation Modal -->
    <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-show="leaveModalOpen" x-transition x-cloak style="display: none;">
        <div class="glass-card rounded-2xl p-6 max-w-md w-full space-y-4 relative border border-red-500/20 shadow-xl shadow-red-500/5" @click.away="leaveModalOpen = false">
            <div class="flex items-center gap-3 border-b border-slate-200 dark:border-white/5 pb-3">
                <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center text-red-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Keluar dari Kursus?</h3>
            </div>
            
            <div class="text-xs text-slate-550 dark:text-gray-400 space-y-2 leading-relaxed">
                <p>Tindakan ini bersifat <strong class="text-red-500 dark:text-red-400">permanen</strong>. Anda akan keluar dari kursus <strong class="text-slate-800 dark:text-white">{{ $course->title }}</strong>, dan seluruh progres belajar serta jawaban tugas Anda akan dihapus selamanya.</p>
                <p>Ketik <span class="bg-red-500/10 text-red-650 dark:text-red-400 font-mono px-1.5 py-0.5 rounded font-bold">keluarkursus/{{ Auth::user()->email }}</span> di bawah untuk mengonfirmasi.</p>
            </div>

            <form action="{{ route('siswa.courses.unenroll', $course->id) }}" method="POST" class="space-y-3">
                @csrf
                <input type="text" x-model="leaveConfirmText" placeholder="Ketik verifikasi di sini..." required autocomplete="off"
                       class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-850 dark:text-white focus:outline-none focus:border-red-500/50 focus:ring-1 focus:ring-red-500/20 transition-all placeholder-gray-450 dark:placeholder-gray-500">
                
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="leaveModalOpen = false"
                            class="flex-1 py-2 rounded-lg border border-slate-200 dark:border-white/5 text-xs font-bold text-slate-550 dark:text-gray-400 hover:bg-slate-100 dark:hover:bg-white/5 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" :disabled="leaveConfirmText !== 'keluarkursus/{{ Auth::user()->email }}'"
                            class="flex-1 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-bold shadow-lg shadow-red-500/20 transition disabled:opacity-40 disabled:cursor-not-allowed disabled:shadow-none cursor-pointer">
                        Keluar Kursus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
