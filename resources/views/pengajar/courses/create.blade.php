@extends('layouts.app')

@section('title', 'Buat Kursus Baru')
@section('page-title', 'Buat Kursus Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 animate-fade-in">
    <!-- Back to Course Index -->
    <a href="{{ route('pengajar.courses.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white transition duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali ke Kelola Kursus</span>
    </a>

    <!-- Create form card -->
    <div class="glass-card rounded-2xl p-6 md:p-8">
        
        <form action="{{ route('pengajar.courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="space-y-1.5">
                    <label for="title" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Judul Kursus</label>
                    <input type="text" name="title" id="title" 
                           class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-4 focus:ring-brand-purple/10 glow-border transition-all duration-200"
                           placeholder="Contoh: Belajar Laravel Dasar" value="{{ old('title') }}" required>
                    @error('title')
                        <span class="text-xs text-red-500 dark:text-red-400 font-medium block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Category -->
                <div class="space-y-1.5">
                    <label for="category" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Kategori Kursus</label>
                    <input type="text" name="category" id="category" 
                           class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-4 focus:ring-brand-purple/10 glow-border transition-all duration-200"
                           placeholder="Contoh: Web Development" value="{{ old('category') }}" required>
                    @error('category')
                        <span class="text-xs text-red-500 dark:text-red-400 font-medium block mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-1.5">
                <label for="description" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Deskripsi Singkat / Rangkuman Kursus</label>
                <textarea name="description" id="description" rows="5" 
                          class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-4 focus:ring-brand-purple/10 glow-border transition-all duration-200"
                          placeholder="Jelaskan secara garis besar apa yang akan dipelajari di kursus ini..." required>{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-xs text-red-500 dark:text-red-400 font-medium block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Course Thumbnail Upload -->
            <div class="space-y-1.5">
                <label for="image" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Gambar Sampul Kursus (Thumbnail)</label>
                <div class="w-full border border-slate-200 dark:border-white/10 rounded-xl p-4 bg-slate-50 dark:bg-white/2 flex flex-col sm:flex-row items-center gap-4">
                    <div class="w-24 h-16 rounded-lg bg-slate-100 dark:bg-black/40 border border-slate-200 dark:border-white/5 overflow-hidden flex items-center justify-center shrink-0">
                        <img id="image-preview" class="w-full h-full object-cover hidden">
                        <svg id="image-placeholder" class="w-6 h-6 text-slate-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    
                    <div class="space-y-1 text-center sm:text-left flex-1 min-w-0">
                        <span class="text-xs font-bold text-slate-700 dark:text-white block truncate" id="file-label">Pilih file gambar</span>
                        <p class="text-[10px] text-slate-400 dark:text-gray-500">File PNG, JPG atau JPEG. Maksimal 2MB.</p>
                    </div>

                    <label class="shrink-0 inline-block px-4 py-2 rounded-xl border border-slate-200 dark:border-white/10 hover:border-brand-cyan/30 bg-slate-100 dark:bg-white/5 hover:bg-brand-cyan/10 text-xs font-bold text-slate-700 dark:text-white cursor-pointer transition">
                        <span>Pilih File</span>
                        <input type="file" name="image" id="image" class="hidden" accept="image/*" onchange="previewThumbnail(this)">
                    </label>
                </div>
                @error('image')
                    <span class="text-xs text-red-500 dark:text-red-400 font-medium block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex justify-end">
                <button type="submit" 
                        class="px-8 py-3.5 rounded-xl bg-gradient-brand text-white font-bold shadow-lg shadow-brand-purple/30 hover:shadow-brand-purple/40 hover:scale-[1.01] transition-all duration-200 text-sm">
                    Buat Kursus
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewThumbnail(input) {
        var label = document.getElementById('file-label');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('image-preview');
                var placeholder = document.getElementById('image-placeholder');
                
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                
                label.innerText = input.files[0].name;
                label.classList.add('text-brand-cyan');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
