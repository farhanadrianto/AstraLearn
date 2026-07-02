@extends('layouts.app')

@section('title', $material->title)
@section('page-title', 'Pembelajaran')

@section('content')
<div class="space-y-6 animate-fade-in">
    <!-- Back to Course Link -->
    <a href="{{ route('siswa.courses.show', $course->id) }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white transition duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali ke Detail Kursus</span>
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
        
        <!-- Left Side: Curriculum Navigation -->
        <div class="lg:col-span-1 glass-card rounded-2xl p-5 space-y-4 lg:sticky lg:top-24">
            <h3 class="font-bold text-slate-800 dark:text-white text-sm uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-white/5">Daftar Materi</h3>
            <div class="space-y-2 max-h-[60vh] overflow-y-auto pr-1">
                @foreach($allMaterials as $index => $item)
                    @php
                        $itemCompleted = in_array($item->id, $enrollment->completed_materials ?? []);
                        $isActive = $item->id === $material->id;
                    @endphp
                    <a href="{{ route('siswa.materials.show', $item->id) }}" 
                       class="flex items-center gap-3 p-3 rounded-xl transition duration-150 border {{ $isActive ? 'bg-brand-purple/10 dark:bg-brand-purple/20 border-brand-purple/20 dark:border-brand-purple/30 text-brand-purple dark:text-white font-semibold' : 'bg-transparent border-transparent text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/5' }}">
                        <div class="w-6 h-6 rounded-lg flex items-center justify-center text-xs shrink-0
                                    {{ $isActive ? 'bg-brand-purple text-white' : ($itemCompleted ? 'bg-emerald-500/20 text-emerald-600 dark:text-emerald-400' : 'bg-slate-100 dark:bg-white/5 text-slate-500 dark:text-gray-400') }}">
                            @if($itemCompleted)
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </div>
                        <span class="text-xs truncate">{{ $item->title }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Right Side: Content Viewer -->
        <div class="lg:col-span-3 space-y-6">
            <!-- Video Player (If url exists) -->
            @if($material->video_url)
                <div class="glass-card rounded-2xl overflow-hidden border border-slate-200 dark:border-white/5 bg-black/5 dark:bg-black/40">
                    <div class="aspect-video w-full relative">
                        @if(str_contains($material->video_url, 'youtube.com') || str_contains($material->video_url, 'youtu.be'))
                            @php
                                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $material->video_url, $match);
                                $youtubeId = $match[1] ?? null;
                            @endphp
                            @if($youtubeId)
                                <iframe class="w-full h-full absolute inset-0" src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center p-6 text-center space-y-3">
                                    <p class="text-sm text-slate-500 dark:text-gray-400">Putar video pembelajaran melalui link eksternal:</p>
                                    <a href="{{ $material->video_url }}" target="_blank" class="px-5 py-2.5 rounded-xl bg-brand-purple text-white font-bold text-xs inline-flex items-center gap-2">
                                        <span>Tonton di YouTube</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center p-6 text-center space-y-3">
                                <p class="text-sm text-slate-500 dark:text-gray-400">Video pembelajaran tersedia di link eksternal:</p>
                                <a href="{{ $material->video_url }}" target="_blank" class="px-5 py-2.5 rounded-xl bg-brand-purple text-white font-bold text-xs inline-flex items-center gap-2">
                                    <span>Buka Video Pembelajaran</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Material Details Card -->
            <div class="glass-card rounded-2xl p-6 md:p-8 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 dark:border-white/5 pb-4">
                    <div class="space-y-1">
                        <h2 class="text-xl md:text-2xl font-extrabold text-slate-900 dark:text-white">{{ $material->title }}</h2>
                        <span class="text-xs text-slate-500 dark:text-gray-400">Bagian dari kursus <strong class="text-slate-700 dark:text-gray-300">{{ $course->title }}</strong></span>
                    </div>
                    
                    @if($material->file_path)
                        <a href="{{ asset('storage/' . $material->file_path) }}" download class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200 dark:border-white/10 hover:border-brand-cyan/30 bg-slate-100 dark:bg-white/5 hover:bg-brand-cyan/10 text-xs font-bold text-slate-700 dark:text-white transition">
                            <svg class="w-4 h-4 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            <span>Unduh Materi PDF</span>
                        </a>
                    @endif
                </div>

                <!-- Text Content -->
                <div class="prose dark:prose-invert max-w-none text-slate-700 dark:text-gray-300 text-sm md:text-base leading-relaxed space-y-4">
                    {!! nl2br(e($material->content)) !!}
                </div>
            </div>

            <!-- Complete and Navigation Footer -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-100 dark:border-white/5 pt-6">
                <!-- Navigation buttons -->
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    @if($prevMaterial)
                        <a href="{{ route('siswa.materials.show', $prevMaterial->id) }}" 
                           class="flex-1 sm:flex-initial px-4 py-2.5 rounded-xl border border-slate-200 dark:border-white/10 hover:border-slate-300 dark:hover:border-white/20 bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 text-xs font-bold text-slate-700 dark:text-white text-center transition">
                            &larr; Sebelumnya
                        </a>
                    @else
                        <button class="flex-1 sm:flex-initial px-4 py-2.5 rounded-xl border border-slate-100 dark:border-white/5 bg-transparent text-slate-300 dark:text-gray-600 text-xs font-bold text-center cursor-not-allowed" disabled>
                            &larr; Sebelumnya
                        </button>
                    @endif

                    @if($nextMaterial)
                        <a href="{{ route('siswa.materials.show', $nextMaterial->id) }}" 
                           class="flex-1 sm:flex-initial px-4 py-2.5 rounded-xl border border-slate-200 dark:border-white/10 hover:border-slate-300 dark:hover:border-white/20 bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 text-xs font-bold text-slate-700 dark:text-white text-center transition">
                            Berikutnya &rarr;
                        </a>
                    @else
                        <button class="flex-1 sm:flex-initial px-4 py-2.5 rounded-xl border border-slate-100 dark:border-white/5 bg-transparent text-slate-300 dark:text-gray-600 text-xs font-bold text-center cursor-not-allowed" disabled>
                            Berikutnya &rarr;
                        </button>
                    @endif
                </div>

                <!-- Completion checkbox button -->
                <div class="w-full sm:w-auto">
                    @if($isCompleted)
                        <div class="py-2.5 px-5 rounded-xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-xs font-bold text-center flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Materi Telah Diselesaikan</span>
                        </div>
                    @else
                        <form action="{{ route('siswa.materials.complete', $material->id) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full px-6 py-3 rounded-xl bg-gradient-brand text-white font-extrabold text-sm text-center shadow-lg shadow-brand-purple/20 hover:shadow-brand-purple/30 transition duration-200">
                                Tandai Selesai & Lanjutkan
                            </button>
                        </form>
                    @endif
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
