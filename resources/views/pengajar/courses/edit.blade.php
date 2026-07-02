@extends('layouts.app')

@section('title', 'Edit Kursus')
@section('page-title', 'Edit Kursus: ' . $course->title)

@section('content')
<div class="max-w-3xl mx-auto space-y-6 animate-fade-in" x-data="{ deleteModalOpen: false, deleteConfirmText: '' }">
    <!-- Back link -->
    <a href="{{ route('pengajar.courses.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white transition duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Batal & Kembali</span>
    </a>

    <!-- Edit form card -->
    <div class="glass-card rounded-2xl p-6 md:p-8">
        
        <form action="{{ route('pengajar.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="space-y-1.5">
                    <label for="title" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Judul Kursus</label>
                    <input type="text" name="title" id="title" 
                           class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-4 focus:ring-brand-purple/10 glow-border transition-all duration-200"
                           value="{{ old('title', $course->title) }}" required>
                    @error('title')
                        <span class="text-xs text-red-500 dark:text-red-400 font-medium block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Category -->
                <div class="space-y-1.5">
                    <label for="category" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Kategori Kursus</label>
                    <input type="text" name="category" id="category" 
                           class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-4 focus:ring-brand-purple/10 glow-border transition-all duration-200"
                           value="{{ old('category', $course->category) }}" required>
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
                          required>{{ old('description', $course->description) }}</textarea>
                @error('description')
                    <span class="text-xs text-red-500 dark:text-red-400 font-medium block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Course Thumbnail Upload -->
            <div class="space-y-1.5">
                <label for="image" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Gambar Sampul Kursus (Thumbnail)</label>
                <div class="w-full border border-slate-200 dark:border-white/10 rounded-xl p-4 bg-slate-50 dark:bg-white/2 flex flex-col sm:flex-row items-center gap-4">
                    <div class="w-24 h-16 rounded-lg bg-slate-100 dark:bg-black/40 border border-slate-200 dark:border-white/5 overflow-hidden flex items-center justify-center shrink-0">
                        @if($course->image_path)
                            <img id="image-preview" src="{{ asset('storage/' . $course->image_path) }}" class="w-full h-full object-cover">
                            <svg id="image-placeholder" class="w-6 h-6 text-slate-400 dark:text-gray-650 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        @else
                            <img id="image-preview" class="w-full h-full object-cover hidden">
                            <svg id="image-placeholder" class="w-6 h-6 text-slate-400 dark:text-gray-650" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        @endif
                    </div>
                    
                    <div class="space-y-1 text-center sm:text-left flex-1 min-w-0">
                        <span class="text-xs font-bold text-slate-700 dark:text-white block truncate" id="file-label">
                            {{ $course->image_path ? basename($course->image_path) : 'Pilih file gambar' }}
                        </span>
                        <p class="text-[10px] text-slate-400 dark:text-gray-500">File PNG, JPG atau JPEG. Maksimal 2MB. Kosongkan jika tidak ingin diubah.</p>
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

            <!-- Submit Button & Danger Zone delete option -->
            <div class="pt-4 border-t border-slate-100 dark:border-white/5 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <!-- Safe Course Deletion -->
                    <button type="button" @click="deleteConfirmText = ''; deleteModalOpen = true" class="px-5 py-2.5 rounded-xl border border-red-500/20 bg-red-500/5 hover:bg-red-500/10 text-xs font-bold text-red-500 dark:text-red-400 transition cursor-pointer">
                        Hapus Kursus
                    </button>
                </div>
                
                <div class="flex items-center gap-3">
                    <button type="submit" 
                            class="px-8 py-3.5 rounded-xl bg-gradient-brand text-white font-bold shadow-lg shadow-brand-purple/30 hover:shadow-brand-purple/40 hover:scale-[1.01] transition-all duration-200 text-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>



    </div>

    <!-- Custom Delete Course Confirmation Modal -->
    <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-show="deleteModalOpen" x-transition x-cloak style="display: none;">
        <div class="glass-card rounded-2xl p-6 max-w-md w-full space-y-4 relative border border-red-500/20 shadow-xl shadow-red-500/5" @click.away="deleteModalOpen = false">
            <div class="flex items-center gap-3 border-b border-slate-200 dark:border-white/5 pb-3">
                <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center text-red-550 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Hapus Kursus Permanen?</h3>
            </div>
            
            <div class="text-xs text-slate-550 dark:text-gray-400 space-y-2 leading-relaxed">
                <p>Tindakan ini bersifat <strong class="text-red-500 dark:text-red-400">permanen dan tidak bisa dibatalkan</strong>. Seluruh materi pembelajaran, tugas-tugas, file yang diunggah, dan nilai seluruh siswa yang terdaftar di kelas ini akan dihapus selamanya.</p>
                <p>Ketik <span class="bg-red-500/10 text-red-650 dark:text-red-400 font-mono px-1.5 py-0.5 rounded font-bold">hapuskursus</span> di bawah untuk mengonfirmasi.</p>
            </div>

            <form action="{{ route('pengajar.courses.destroy', $course->id) }}" method="POST" class="space-y-3">
                @csrf
                @method('DELETE')
                <input type="text" x-model="deleteConfirmText" placeholder="Ketik verifikasi di sini..." required autocomplete="off"
                       class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-850 dark:text-white focus:outline-none focus:border-red-500/50 focus:ring-1 focus:ring-red-500/20 transition-all placeholder-gray-450 dark:placeholder-gray-500">
                
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="deleteModalOpen = false"
                            class="flex-1 py-2 rounded-lg border border-slate-200 dark:border-white/5 text-xs font-bold text-slate-550 dark:text-gray-400 hover:bg-slate-100 dark:hover:bg-white/5 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" :disabled="deleteConfirmText !== 'hapuskursus'"
                            class="flex-1 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-bold shadow-lg shadow-red-500/20 transition disabled:opacity-40 disabled:cursor-not-allowed disabled:shadow-none cursor-pointer">
                        Hapus Kursus
                    </button>
                </div>
            </form>
        </div>
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
                if(placeholder) {
                    placeholder.classList.add('hidden');
                }
                
                label.innerText = input.files[0].name;
                label.classList.add('text-brand-cyan');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
