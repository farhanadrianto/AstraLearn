@extends('layouts.app')

@section('title', 'Cari Kursus')
@section('page-title', 'Eksplorasi Kursus')

@section('content')
<div class="space-y-6 animate-fade-in" x-data="{ enrollModalOpen: false, enrollCourseTitle: '', enrollActionUrl: '' }">
    <div>
        <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-wide">Katalog Kursus</h2>
        <p class="text-xs text-slate-500 dark:text-gray-400">Temukan kursus baru untuk memperkaya pengetahuan dan keterampilan Anda.</p>
    </div>

    @if($courses->isEmpty())
        <div class="glass-card rounded-2xl p-12 text-center text-slate-500 dark:text-gray-400 space-y-4">
            <svg class="w-16 h-16 text-slate-300 dark:text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
            </svg>
            <h3 class="text-base font-bold text-slate-800 dark:text-white">Tidak Ada Kursus Tersedia</h3>
            <p class="text-xs max-w-sm mx-auto">Saat ini semua kursus telah Anda ikuti atau belum ada kursus baru yang dipublikasikan oleh pengajar.</p>
            <a href="{{ route('siswa.courses.index') }}" class="inline-block px-6 py-3 rounded-xl bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-700 dark:text-white text-xs font-bold hover:bg-slate-200 dark:hover:bg-white/10 transition-all">
                Kembali ke Kelas Saya
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($courses as $course)
                <div class="glass-card rounded-2xl overflow-hidden hover:border-brand-purple/30 transition-all duration-300 flex flex-col justify-between">
                    
                    <!-- Thumbnail -->
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
                            <p class="text-xs text-slate-500 dark:text-gray-400 line-clamp-3">{{ $course->description }}</p>
                        </div>

                        <div class="space-y-3 pt-2">
                            <!-- Stats details -->
                            <div class="flex items-center gap-4 text-[10px] text-slate-500 dark:text-gray-400 border-t border-slate-100 dark:border-white/5 pt-3">
                                <div>📘 {{ $course->materials_count }} Materi</div>
                                <div class="flex items-center gap-1">
                                    <div class="w-4 h-4 rounded-full bg-brand-purple/10 dark:bg-brand-purple/20 flex items-center justify-center text-[7px] text-brand-purple dark:text-white font-bold">
                                        {{ substr($course->teacher->name, 0, 1) }}
                                    </div>
                                    <span class="text-slate-600 dark:text-gray-300 font-semibold">{{ $course->teacher->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enrollment Button -->
                    <div class="p-5 border-t border-slate-100 dark:border-white/5 bg-slate-50/50 dark:bg-white/1">
                        <button type="button" 
                                @click="enrollCourseTitle = {{ json_encode($course->title) }}; enrollActionUrl = '{{ route('siswa.courses.enroll', $course->id) }}'; enrollModalOpen = true"
                                class="w-full py-2.5 rounded-xl bg-gradient-brand text-white text-xs font-bold text-center shadow-lg hover:shadow-brand-purple/20 transition-all duration-200 hover:scale-[1.01] cursor-pointer">
                            Daftar Kelas
                        </button>
                    </div>

                </div>
            @endforeach
        </div>
    @endif
    <!-- Custom Enroll Confirmation Modal -->
    <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-show="enrollModalOpen" x-transition x-cloak style="display: none;">
        <div class="glass-card rounded-2xl p-6 max-w-md w-full space-y-4 relative border border-brand-purple/20 shadow-xl shadow-brand-purple/5" @click.away="enrollModalOpen = false">
            <div class="flex items-center gap-3 border-b border-slate-200 dark:border-white/5 pb-3">
                <div class="w-8 h-8 rounded-lg bg-brand-purple/10 flex items-center justify-center text-brand-purple shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider font-sans">Ikuti Kelas Baru?</h3>
            </div>
            
            <div class="text-xs text-slate-550 dark:text-gray-400 space-y-2 leading-relaxed">
                <p>Apakah Anda yakin ingin mendaftar dan mengikuti kelas <strong class="text-slate-850 dark:text-white" x-text="enrollCourseTitle"></strong>?</p>
                <p>Setelah mendaftar, kelas ini akan masuk ke tab **Kursus Saya** dan Anda bisa langsung memulai aktivitas belajar.</p>
            </div>

            <form :action="enrollActionUrl" method="POST">
                @csrf
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="enrollModalOpen = false"
                            class="flex-1 py-2 rounded-lg border border-slate-200 dark:border-white/5 text-xs font-bold text-slate-550 dark:text-gray-400 hover:bg-slate-100 dark:hover:bg-white/5 transition cursor-pointer">
                        Tidak
                    </button>
                    <button type="submit"
                            class="flex-1 py-2 rounded-lg bg-gradient-brand text-white text-xs font-bold shadow-lg shadow-brand-purple/20 transition hover:brightness-110 cursor-pointer">
                        Ya, Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
