@extends('layouts.app')

@section('title', 'Penilaian Tugas')
@section('page-title', 'Penilaian Tugas Siswa')

@section('content')
<div class="space-y-6 animate-fade-in" x-data="{ activeAssignmentId: null }">
    
    <!-- LIST VIEW: Active when activeAssignmentId is null -->
    <div x-show="activeAssignmentId === null" class="space-y-6">
        <div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-wide font-sans">Kelola Nilai Tugas</h2>
            <p class="text-xs text-slate-500 dark:text-gray-400">Pilih tugas dari daftar kelas Anda untuk mulai menilai hasil pekerjaan siswa.</p>
        </div>

        @if($courses->isEmpty())
            <div class="glass-card rounded-2xl p-12 text-center text-slate-500 dark:text-gray-400">
                <p class="text-sm">Anda belum memiliki kelas aktif saat ini.</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach($courses as $course)
                    <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-white/5 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-white/5 pb-3">
                            <div>
                                <span class="text-[9px] uppercase font-extrabold tracking-wider text-brand-cyan bg-brand-cyan/10 px-2.5 py-0.5 rounded-full">
                                    {{ $course->category }}
                                </span>
                                <h3 class="text-base font-bold text-slate-800 dark:text-white mt-1">{{ $course->title }}</h3>
                            </div>
                            <span class="text-xs text-slate-500 dark:text-gray-400">
                                👥 {{ $course->enrollments->count() }} Siswa Terdaftar
                            </span>
                        </div>

                        @if($course->assignments->isEmpty())
                            <p class="text-xs text-slate-500 dark:text-gray-400 italic">Belum ada tugas yang dirilis pada kelas ini.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($course->assignments as $assignment)
                                    @php
                                        $totalEnrolled = $course->enrollments->count();
                                        $submissionsCount = $assignment->submissions->count();
                                        $pendingCount = $assignment->submissions->whereNull('grade')->count();
                                        $gradedCount = $assignment->submissions->whereNotNull('grade')->count();
                                    @endphp
                                    <div class="p-4 rounded-xl border border-slate-100 dark:border-white/5 bg-slate-50/50 dark:bg-white/2 flex flex-col justify-between gap-4">
                                        <div class="space-y-2">
                                            <h4 class="text-sm font-bold text-slate-800 dark:text-white line-clamp-1">{{ $assignment->title }}</h4>
                                            <p class="text-[10px] text-slate-450 dark:text-gray-450">Batas: {{ $assignment->due_date->format('d M Y, H:i') }} WIB</p>
                                            
                                            <!-- Stats badges -->
                                            <div class="flex flex-wrap gap-1.5 pt-1">
                                                <span class="text-[9px] font-bold px-2 py-0.5 rounded bg-slate-100 dark:bg-white/5 text-slate-650 dark:text-gray-400 border border-slate-200 dark:border-white/5">
                                                    📥 {{ $submissionsCount }} / {{ $totalEnrolled }} Mengumpulkan
                                                </span>
                                                @if($submissionsCount === $totalEnrolled && $pendingCount === 0)
                                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                                                        ✅ Beres Dinilai
                                                    </span>
                                                @else
                                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20">
                                                        ⏳ Ada Yang Belum Dinilai
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <button @click="activeAssignmentId = {{ $assignment->id }}" 
                                                class="w-full text-center py-2 rounded-xl bg-brand-purple text-white font-bold text-xs hover:brightness-110 shadow-lg shadow-brand-purple/10 transition-all select-none cursor-pointer">
                                            Kelola Nilai
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- DETAIL VIEW: Active when activeAssignmentId is matched -->
    @foreach($courses as $course)
        @foreach($course->assignments as $assignment)
            @php
                $totalEnrolled = $course->enrollments->count();
                $submittedCount = $assignment->submissions->count();
                $pendingCount = $assignment->submissions->whereNull('grade')->count();
            @endphp
            <div x-show="activeAssignmentId === {{ $assignment->id }}" class="space-y-6" x-cloak style="display: none;">
                <!-- Header / Back -->
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-white/5 pb-4">
                    <div class="space-y-1">
                        <button @click="activeAssignmentId = null" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white transition select-none cursor-pointer mb-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            <span>Kembali ke Daftar Tugas</span>
                        </button>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">{{ $assignment->title }}</h2>
                        <div class="flex flex-wrap items-center gap-3 text-xs text-slate-550 dark:text-gray-400">
                            <span>Kelas: <strong class="text-slate-800 dark:text-white">{{ $course->title }}</strong></span>
                            <span>&bull;</span>
                            <span>Deadline: <strong class="text-slate-700 dark:text-gray-300">{{ $assignment->due_date->format('d M Y, H:i') }} WIB</strong></span>
                            <span>&bull;</span>
                            <span>Poin Maks: <strong class="text-brand-purple">{{ $assignment->points }}</strong></span>
                        </div>
                    </div>

                    <!-- Compact stats pill -->
                    <div class="hidden sm:flex gap-2 bg-slate-50 dark:bg-white/2 border border-slate-200 dark:border-white/5 px-4 py-3 rounded-2xl text-xs font-semibold">
                        <div class="text-center px-3 border-r border-slate-200 dark:border-white/5">
                            <span class="text-slate-450 dark:text-gray-500 text-[10px] block">Terdaftar</span>
                            <span class="text-slate-900 dark:text-white font-extrabold text-sm">{{ $totalEnrolled }}</span>
                        </div>
                        <div class="text-center px-3 border-r border-slate-200 dark:border-white/5">
                            <span class="text-slate-450 dark:text-gray-500 text-[10px] block">Mengumpulkan</span>
                            <span class="text-slate-900 dark:text-white font-extrabold text-sm">{{ $submittedCount }}</span>
                        </div>
                        <div class="text-center px-3">
                            <span class="text-slate-450 dark:text-gray-500 text-[10px] block">Perlu Dinilai</span>
                            <span class="text-amber-500 font-extrabold text-sm">{{ $pendingCount }}</span>
                        </div>
                    </div>
                </div>

                <!-- Students Submission List -->
                <div class="space-y-4">
                    @if($course->enrollments->isEmpty())
                        <div class="glass-card rounded-2xl p-8 text-center text-slate-500 dark:text-gray-400">
                            <p class="text-xs">Belum ada siswa yang bergabung di kelas ini.</p>
                        </div>
                    @else
                        @foreach($course->enrollments as $enrollment)
                            @php
                                $student = $enrollment->student;
                                $sub = $assignment->submissions->firstWhere('student_id', $student->id);
                            @endphp
                            <div class="glass-card rounded-2xl p-5 border border-slate-200/50 dark:border-white/5 space-y-4">
                                
                                <!-- Student Meta info & status -->
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full overflow-hidden bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 shrink-0">
                                            @if($student->avatar)
                                                <img src="{{ asset('storage/' . $student->avatar) }}" class="w-full h-full object-cover" alt="{{ $student->name }}">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center font-bold text-slate-550 dark:text-white text-sm bg-gradient-brand/10 text-brand-purple">
                                                    {{ substr($student->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="text-xs font-bold text-slate-800 dark:text-white">{{ $student->name }}</h4>
                                            <p class="text-[10px] text-slate-450 dark:text-gray-500">{{ $student->email }}</p>
                                        </div>
                                    </div>

                                    <!-- Status Badge -->
                                    <div>
                                        @if(!$sub)
                                            <span class="text-[9px] uppercase font-extrabold tracking-wider border border-red-500/20 bg-red-500/5 text-red-550 dark:text-red-400 px-3 py-1 rounded-full">
                                                Belum Mengumpulkan
                                            </span>
                                        @elseif($sub->grade === null)
                                            <span class="text-[9px] uppercase font-extrabold tracking-wider border border-amber-500/20 bg-amber-500/5 text-amber-600 dark:text-amber-400 px-3 py-1 rounded-full animate-pulse">
                                                Perlu Dinilai
                                            </span>
                                        @else
                                            <span class="text-[9px] uppercase font-extrabold tracking-wider border border-emerald-500/20 bg-emerald-500/5 text-emerald-600 dark:text-emerald-400 px-3 py-1 rounded-full">
                                                Selesai Dinilai: <strong class="text-slate-850 dark:text-white">{{ $sub->grade }}/{{ $assignment->points }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Submission Detail / Grading Form -->
                                @if($sub)
                                    <div class="border-t border-slate-100 dark:border-white/5 pt-4 space-y-3" x-data="{ editing: {{ $sub->grade === null ? 'true' : 'false' }} }">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                                            <!-- File & Text -->
                                            <div class="space-y-3">
                                                <div class="flex items-center justify-between p-3 rounded-xl border border-slate-200/50 dark:border-white/5 bg-slate-50/50 dark:bg-white/1">
                                                    <span class="font-medium text-slate-700 dark:text-white truncate max-w-[200px]" title="{{ basename($sub->file_path) }}">{{ basename($sub->file_path) }}</span>
                                                    <a href="{{ asset('storage/' . $sub->file_path) }}" download class="shrink-0 text-brand-cyan hover:underline font-bold flex items-center gap-1">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                        <span>Unduh Jawaban</span>
                                                    </a>
                                                </div>

                                                @if($sub->submitted_text)
                                                    <div class="space-y-1">
                                                        <span class="text-[9px] text-slate-450 dark:text-gray-550 font-bold uppercase tracking-wider block">Catatan Siswa:</span>
                                                        <p class="text-slate-650 dark:text-gray-300 bg-slate-50 dark:bg-white/2 p-3 rounded-xl border border-slate-200 dark:border-white/5 italic">"{{ $sub->submitted_text }}"</p>
                                                    </div>
                                                @endif

                                                @if($sub->feedback && $sub->grade !== null)
                                                    <div class="space-y-1" x-show="!editing">
                                                        <span class="text-[9px] text-brand-purple font-bold uppercase tracking-wider block">Feedback Nilai Anda:</span>
                                                        <p class="text-slate-650 dark:text-gray-300 bg-slate-50 dark:bg-white/2 p-3 rounded-xl border border-slate-200 dark:border-white/5 italic">"{{ $sub->feedback }}"</p>
                                                    </div>
                                                @endif

                                                @if($sub->grade !== null)
                                                    <button type="button" @click="editing = !editing" x-show="!editing"
                                                            class="px-4 py-2 rounded-xl border border-slate-200 dark:border-white/10 hover:border-brand-purple/30 bg-slate-100 dark:bg-white/5 text-[11px] font-bold text-slate-700 dark:text-gray-300 hover:text-brand-purple dark:hover:text-white transition select-none cursor-pointer">
                                                        Ubah Nilai & Feedback
                                                    </button>
                                                @endif
                                            </div>

                                            <!-- Form -->
                                            <div x-show="editing" x-transition>
                                                <form action="{{ route('pengajar.submissions.grade', $sub->id) }}" method="POST" class="space-y-3 p-4 rounded-xl border border-slate-200 dark:border-white/5 bg-slate-50/50 dark:bg-white/1">
                                                    @csrf
                                                    <div class="grid grid-cols-3 gap-3">
                                                        <div class="col-span-1 space-y-1">
                                                            <label class="text-[9px] font-bold text-slate-500 dark:text-gray-450 uppercase block">Skor (Maks {{ $assignment->points }})</label>
                                                            <input type="number" name="grade" min="0" max="{{ $assignment->points }}" required value="{{ $sub->grade }}"
                                                                   class="w-full bg-white dark:bg-[#121217] border border-slate-200 dark:border-white/10 rounded-lg px-2.5 py-1.5 text-xs text-slate-800 dark:text-white focus:outline-none">
                                                        </div>
                                                        <div class="col-span-2 space-y-1">
                                                            <label class="text-[9px] font-bold text-slate-500 dark:text-gray-450 uppercase block">Feedback Masukan</label>
                                                            <input type="text" name="feedback" value="{{ $sub->feedback }}" placeholder="Feedback pengerjaan..."
                                                                   class="w-full bg-white dark:bg-[#121217] border border-slate-200 dark:border-white/10 rounded-lg px-2.5 py-1.5 text-xs text-slate-800 dark:text-white focus:outline-none">
                                                        </div>
                                                    </div>
                                                    <div class="flex justify-end gap-2 pt-1.5">
                                                        @if($sub->grade !== null)
                                                            <button type="button" @click="editing = false" class="px-3 py-1.5 rounded-lg border border-slate-200 dark:border-white/5 text-[10px] font-bold text-slate-550 dark:text-gray-400 hover:bg-slate-100 dark:hover:bg-white/5 cursor-pointer">Batal</button>
                                                        @endif
                                                        <button type="submit" class="px-4 py-1.5 rounded-lg bg-brand-purple text-white text-[10px] font-bold hover:brightness-110 shadow shadow-brand-purple/20 cursor-pointer">Simpan Nilai</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="border-t border-slate-100 dark:border-white/5 pt-4 text-center">
                                        <p class="text-[10px] text-slate-400 dark:text-gray-500 italic">Menunggu pengumpulan tugas dari siswa.</p>
                                    </div>
                                @endif
                                
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    @endforeach

</div>
@endsection
