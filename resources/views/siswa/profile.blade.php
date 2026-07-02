@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Pengaturan Profil')

@section('content')
<div class="max-w-3xl mx-auto space-y-8 animate-fade-in">
    <div class="glass-card rounded-2xl p-6 md:p-8">
        
        <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Profile Photo section -->
            <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-slate-100 dark:border-white/5">
                <div class="relative group">
                    <div class="w-24 h-24 rounded-full overflow-hidden border border-brand-purple bg-brand-purple/10 dark:bg-brand-purple/20 flex items-center justify-center text-brand-purple dark:text-white text-3xl font-bold">
                        @if(Auth::user()->profile_photo)
                            <img id="avatar-preview" src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            <span id="avatar-letter">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            <img id="avatar-preview" class="w-full h-full object-cover hidden">
                        @endif
                    </div>
                </div>
                
                <div class="space-y-1.5 text-center sm:text-left">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">Foto Profil</h3>
                    <p class="text-xs text-slate-500 dark:text-gray-400">Unggah file gambar PNG, JPG atau JPEG. Maksimal 2MB.</p>
                    <label class="inline-block mt-2 px-4 py-2 rounded-xl border border-slate-200 dark:border-white/10 hover:border-brand-purple/30 bg-slate-100 dark:bg-white/5 hover:bg-brand-purple/10 text-xs font-bold text-slate-700 dark:text-white cursor-pointer transition">
                        <span>Pilih Foto</span>
                        <input type="file" name="profile_photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                    </label>
                </div>
            </div>

            <!-- Form fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-1.5">
                    <label for="name" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Nama Lengkap</label>
                    <input type="text" name="name" id="name" 
                           class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-4 focus:ring-brand-purple/10 glow-border transition-all duration-200"
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="text-xs text-red-500 dark:text-red-400 font-medium block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-1.5">
                    <label for="email" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Alamat Email</label>
                    <input type="email" name="email" id="email" 
                           class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-4 focus:ring-brand-purple/10 glow-border transition-all duration-200"
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="text-xs text-red-500 dark:text-red-400 font-medium block mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Password Change Block -->
            <div class="pt-6 border-t border-slate-100 dark:border-white/5 space-y-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white">Ubah Kata Sandi</h3>
                    <p class="text-xs text-slate-500 dark:text-gray-400">Kosongkan kolom di bawah jika tidak ingin mengubah kata sandi Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div class="space-y-1.5">
                        <label for="password" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Kata Sandi Baru</label>
                        <input type="password" name="password" id="password" 
                               class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-4 focus:ring-brand-purple/10 glow-border transition-all duration-200"
                               placeholder="••••••••">
                        @error('password')
                            <span class="text-xs text-red-500 dark:text-red-400 font-medium block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-4 focus:ring-brand-purple/10 glow-border transition-all duration-200"
                               placeholder="••••••••">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex justify-end">
                <button type="submit" 
                        class="px-8 py-3 rounded-xl bg-gradient-brand text-white font-bold shadow-lg shadow-brand-purple/30 hover:shadow-brand-purple/40 hover:scale-[1.01] transition-all duration-200 text-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('avatar-preview');
                var letter = document.getElementById('avatar-letter');
                
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (letter) {
                    letter.classList.add('hidden');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
