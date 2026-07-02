@extends('layouts.app')

@section('title', 'Tugas - ' . $assignment->title)
@section('page-title', 'Detail Tugas')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in">
    <!-- Back to Course Link -->
    <a href="{{ route('siswa.courses.show', $course->id) }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white transition duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali ke Detail Kursus</span>
    </a>

    <!-- Assignment Description Card -->
    <div class="glass-card rounded-2xl p-6 md:p-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 dark:border-white/5 pb-4">
            <div class="space-y-1">
                <h2 class="text-xl md:text-2xl font-extrabold text-slate-900 dark:text-white">{{ $assignment->title }}</h2>
                <span class="text-xs text-slate-500 dark:text-gray-400">Kursus: <strong class="text-slate-700 dark:text-gray-300">{{ $course->title }}</strong></span>
            </div>
            
            <div class="text-right shrink-0">
                <span class="text-xs text-slate-500 dark:text-gray-400 block font-semibold uppercase tracking-wider">Poin Maksimal</span>
                <span class="text-2xl font-extrabold text-brand-purple block">{{ $assignment->points }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
            <div class="p-4 rounded-xl border border-slate-200 dark:border-white/5 bg-slate-50/50 dark:bg-white/1 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-brand-cyan/10 flex items-center justify-center text-brand-cyan">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-slate-500 dark:text-gray-400 block font-semibold">BATAS PENGUMPULAN</span>
                    <strong class="text-slate-800 dark:text-white">{{ $assignment->due_date->format('d F Y, H:i') }} WIB</strong>
                </div>
            </div>
            
            <div class="p-4 rounded-xl border border-slate-200 dark:border-white/5 bg-slate-50/50 dark:bg-white/1 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-brand-purple/10 flex items-center justify-center text-brand-purple">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-slate-500 dark:text-gray-400 block font-semibold">STATUS WAKTU</span>
                    @if($assignment->due_date->isPast())
                        <strong class="text-red-500 dark:text-red-400">Sudah Melewati Batas</strong>
                    @else
                        <strong class="text-brand-cyan">Aktif (Sisa {{ $assignment->due_date->diffForHumans(null, true) }})</strong>
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-3">
            <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Instruksi Tugas</h3>
            <div class="text-sm text-slate-600 dark:text-gray-300 leading-relaxed bg-slate-50/50 dark:bg-white/2 border border-slate-100 dark:border-white/5 p-5 rounded-xl">
                {!! nl2br(e($assignment->description)) !!}
            </div>
        </div>
    </div>

    <!-- Submission panel -->
    <div class="glass-card rounded-2xl p-6 md:p-8 space-y-6">
        <h3 class="text-base font-bold text-slate-800 dark:text-white border-b border-slate-100 dark:border-white/5 pb-3">Pengumpulan Tugas Anda</h3>

        @if($submission)
            <!-- ALREADY SUBMITTED STATE -->
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Status Card -->
                    <div class="p-5 rounded-xl border border-slate-100 dark:border-white/5 bg-slate-50/50 dark:bg-white/1 space-y-2">
                        <span class="text-[10px] text-slate-500 dark:text-gray-400 uppercase tracking-widest font-semibold block">Status</span>
                        @if($submission->grade !== null)
                            <span class="inline-block px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 text-xs font-bold uppercase tracking-wider">Sudah Dinilai</span>
                        @else
                            <span class="inline-block px-3 py-1 rounded-full bg-brand-cyan/10 text-brand-cyan border border-brand-cyan/20 text-xs font-bold uppercase tracking-wider">Menunggu Penilaian</span>
                        @endif
                    </div>
                    
                    <!-- Grade Card -->
                    <div class="p-5 rounded-xl border border-slate-100 dark:border-white/5 bg-slate-50/50 dark:bg-white/1 space-y-2">
                        <span class="text-[10px] text-slate-500 dark:text-gray-400 uppercase tracking-widest font-semibold block">Nilai</span>
                        @if($submission->grade !== null)
                            <strong class="text-3xl font-extrabold text-slate-800 dark:text-white block">{{ $submission->grade }}<span class="text-xs text-slate-500 dark:text-gray-400 font-medium"> / {{ $assignment->points }}</span></strong>
                        @else
                            <span class="text-sm text-slate-400 dark:text-gray-500 block font-medium">Belum Dinilai</span>
                        @endif
                    </div>

                    <!-- Submitted Time -->
                    <div class="p-5 rounded-xl border border-slate-100 dark:border-white/5 bg-slate-100/30 dark:bg-[#121217]/30 space-y-2">
                        <span class="text-[10px] text-slate-500 dark:text-gray-400 uppercase tracking-widest font-semibold block">Tanggal Pengumpulan</span>
                        <strong class="text-sm text-slate-800 dark:text-white block">{{ $submission->submitted_at->format('d M Y, H:i') }} WIB</strong>
                    </div>

                </div>

                <!-- Submission Details -->
                <div class="space-y-4 bg-slate-50/50 dark:bg-white/2 border border-slate-100 dark:border-white/5 p-5 rounded-xl">
                    <div class="space-y-2">
                        <span class="text-xs text-slate-500 dark:text-gray-400 block font-semibold uppercase tracking-wider">File yang Dikirim</span>
                        <div class="flex items-center justify-between gap-4 bg-slate-100 dark:bg-black/20 p-3 rounded-lg border border-slate-200 dark:border-white/5">
                            <span class="text-xs font-medium text-slate-700 dark:text-white truncate">{{ basename($submission->file_path) }}</span>
                            <a href="{{ asset('storage/' . $submission->file_path) }}" download class="shrink-0 text-xs text-brand-cyan hover:underline font-bold flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                <span>Unduh File</span>
                            </a>
                        </div>
                    </div>

                    @if($submission->submitted_text)
                        <div class="space-y-1.5 pt-2">
                            <span class="text-xs text-slate-500 dark:text-gray-400 block font-semibold uppercase tracking-wider">Catatan Jawaban</span>
                            <p class="text-xs text-slate-600 dark:text-gray-300 italic leading-relaxed bg-slate-100/50 dark:bg-black/10 p-3 rounded-lg border border-slate-200 dark:border-white/5">{!! nl2br(e($submission->submitted_text)) !!}</p>
                        </div>
                    @endif
                </div>

                <!-- Teacher Feedback -->
                @if($submission->feedback)
                    <div class="p-5 rounded-xl border border-brand-purple/20 bg-brand-purple/5 space-y-2.5 animate-slide-up">
                        <span class="text-xs text-brand-purple block font-extrabold uppercase tracking-wider">Catatan Pengajar</span>
                        <p class="text-sm text-slate-700 dark:text-gray-300 leading-relaxed font-medium italic">"{{ $submission->feedback }}"</p>
                    </div>
                @endif

                <!-- Resubmit option if not graded and due date not past -->
                @if($submission->grade === null && !$assignment->due_date->isPast())
                    <div x-data="{ showForm: false }" class="space-y-4 pt-4 border-t border-slate-100 dark:border-white/5">
                        <div class="flex justify-end">
                            <button @click="showForm = !showForm" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-white/10 hover:border-brand-purple/30 bg-slate-100 dark:bg-white/5 text-xs font-bold text-slate-700 dark:text-white transition">
                                <span x-text="showForm ? 'Batal Mengubah' : 'Kirim Ulang Jawaban'">Kirim Ulang Jawaban</span>
                            </button>
                        </div>

                        <div x-show="showForm" class="bg-slate-50/50 dark:bg-black/30 border border-slate-200 dark:border-white/5 rounded-xl p-5" x-transition>
                            <form action="{{ route('siswa.assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Unggah File Baru</label>
                                    <input type="file" name="file" class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none" required>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Catatan Tambahan (Opsional)</label>
                                    <textarea name="submitted_text" rows="3" class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none" placeholder="Tuliskan catatan Anda di sini...">{{ old('submitted_text', $submission->submitted_text) }}</textarea>
                                </div>
                                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-purple text-white text-xs font-bold hover:bg-brand-purple/90 transition shadow-md shadow-brand-purple/20">
                                    Simpan Pengiriman Baru
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

        @else
            <!-- UNSUBMITTED STATE -->
            @if($assignment->due_date->isPast())
                <div class="p-6 rounded-xl border border-red-500/20 bg-red-500/10 text-red-600 dark:text-red-400 text-sm font-semibold text-center">
                    Batas waktu pengumpulan tugas ini telah berakhir. Anda tidak dapat mengumpulkan tugas lagi.
                </div>
            @else
                <form action="{{ route('siswa.assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    
                    <div class="space-y-2">
                        <label for="file" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">File Tugas (PDF, ZIP, DOC, JPG, PNG)</label>
                        <div class="w-full border-2 border-dashed border-slate-200 dark:border-white/10 rounded-2xl p-6 bg-slate-50 dark:bg-white/2 hover:bg-slate-100 dark:hover:bg-white/3 hover:border-brand-purple/30 transition flex flex-col items-center justify-center text-center space-y-2 relative">
                            <input type="file" name="file" id="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required onchange="updateFileName(this)">
                            
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <span class="text-xs font-bold text-slate-700 dark:text-white block" id="file-label">Pilih file atau seret ke sini</span>
                            <span class="text-[10px] text-slate-400 dark:text-gray-500 block">Ukuran file maksimal 10MB</span>
                        </div>
                        @error('file')
                            <span class="text-xs text-red-500 dark:text-red-400 font-medium block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="submitted_text" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Catatan / Jawaban Teks (Opsional)</label>
                        <textarea name="submitted_text" id="submitted_text" rows="4" 
                                  class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-4 focus:ring-brand-purple/10 glow-border transition-all duration-200"
                                  placeholder="Tambahkan pesan tambahan untuk pengajar..."></textarea>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" 
                                class="px-8 py-3.5 rounded-xl bg-gradient-brand text-white font-bold shadow-lg shadow-brand-purple/30 hover:shadow-brand-purple/40 transition duration-200 text-sm">
                            Kumpulkan Tugas
                        </button>
                    </div>
                </form>
            @endif
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateFileName(input) {
        var label = document.getElementById('file-label');
        if (input.files && input.files.length > 0) {
            label.innerText = input.files[0].name;
            label.classList.add('text-brand-cyan');
        } else {
            label.innerText = "Pilih file atau seret ke sini";
            label.classList.remove('text-brand-cyan');
        }
    }
</script>
@endsection
