<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - AstraLearn</title>
    
    <!-- Google Fonts -->
    <link class="preconnect" href="https://fonts.googleapis.com">
    <link class="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Theme Switcher Initialization -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 dark:bg-[#0f172a] text-slate-800 dark:text-gray-200 font-sans min-h-screen flex items-center justify-center p-6 relative overflow-x-hidden transition-colors duration-300" x-data="{ selectedRole: 'siswa' }">

    <!-- Ambient glowing backgrounds -->
    <div class="absolute top-1/4 left-1/4 w-[35rem] h-[35rem] rounded-full bg-brand-purple/5 dark:bg-brand-purple/10 blur-[130px] pointer-events-none animate-pulse-slow"></div>
    <div class="absolute bottom-1/4 right-1/4 w-[35rem] h-[35rem] rounded-full bg-brand-cyan/2 dark:bg-brand-cyan/5 blur-[130px] pointer-events-none"></div>

    <!-- Theme Toggle Floating Button -->
    <div class="absolute top-6 right-6 z-20">
        <button onclick="toggleTheme()" class="p-2.5 rounded-xl border border-slate-200 dark:border-white/10 bg-white/80 dark:bg-white/5 hover:bg-slate-100 dark:hover:bg-white/10 text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white transition duration-200 focus:outline-none" title="Ubah Tema">
            <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
            <svg class="w-4 h-4 hidden dark:block text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707-.707m12.728 0l-.707.707M6.343 6.343l-.707-.707M14.25 12a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
            </svg>
        </button>
    </div>

    <!-- Register card -->
    <div class="w-full max-w-lg glass-card rounded-2xl p-8 relative z-10 animate-slide-up">
        
        <!-- Logo -->
        <div class="flex flex-col items-center mb-6">
            <div class="w-12 h-12 rounded-2xl bg-gradient-brand flex items-center justify-center shadow-lg shadow-brand-purple/40 mb-3">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-wide">Astra<span class="text-brand-purple">Learn</span></h2>
            <p class="text-sm text-slate-500 dark:text-gray-400 mt-1">Buat akun untuk memulai perjalanan Anda</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            
            <!-- Dual Column on Name & Email -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Name -->
                <div class="space-y-1.5">
                    <label for="name" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Nama Lengkap</label>
                    <input type="text" name="name" id="name" 
                           class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-4 focus:ring-brand-purple/10 glow-border transition-all duration-200"
                           placeholder="Nama Anda" value="{{ old('name') }}" required autofocus autocomplete="name">
                    @error('name')
                        <span class="text-xs text-red-500 dark:text-red-400 font-medium block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-1.5">
                    <label for="email" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Alamat Email</label>
                    <input type="email" name="email" id="email" 
                           class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-4 focus:ring-brand-purple/10 glow-border transition-all duration-200"
                           placeholder="nama@email.com" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="text-xs text-red-500 dark:text-red-400 font-medium block mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Role Selector with nice UI -->
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Pilih Peran Anda</label>
                <input type="hidden" name="role" :value="selectedRole">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Siswa Option -->
                    <div class="border rounded-xl p-4 cursor-pointer transition-all duration-200 flex flex-col items-center justify-center text-center select-none"
                         :class="selectedRole === 'siswa' ? 'border-brand-purple bg-brand-purple/10 text-brand-purple dark:text-white shadow-lg shadow-brand-purple/5 dark:shadow-brand-purple/10' : 'border-slate-200 dark:border-white/10 bg-white dark:bg-[#121217]/50 text-slate-500 dark:text-gray-400 hover:border-slate-300 dark:hover:border-white/20'"
                         @click="selectedRole = 'siswa'">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                        </svg>
                        <span class="font-bold text-sm block">Siswa</span>
                        <span class="text-[10px] text-slate-500 dark:text-gray-400 mt-0.5">Saya ingin belajar & mengikuti kursus</span>
                    </div>

                    <!-- Pengajar Option -->
                    <div class="border rounded-xl p-4 cursor-pointer transition-all duration-200 flex flex-col items-center justify-center text-center select-none"
                         :class="selectedRole === 'pengajar' ? 'border-brand-purple bg-brand-purple/10 text-brand-purple dark:text-white shadow-lg shadow-brand-purple/5 dark:shadow-brand-purple/10' : 'border-slate-200 dark:border-white/10 bg-white dark:bg-[#121217]/50 text-slate-500 dark:text-gray-400 hover:border-slate-300 dark:hover:border-white/20'"
                         @click="selectedRole = 'pengajar'">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 012 2v8a2 2 0 01-2 2h-3m-6 0a1 1 0 001-1V7a1 1 0 00-1-1h-3a1 1 0 00-1 1v12a1 1 0 001 1h3z"></path>
                        </svg>
                        <span class="font-bold text-sm block">Pengajar</span>
                        <span class="text-[10px] text-slate-500 dark:text-gray-400 mt-0.5">Saya ingin mengajar & mengelola materi</span>
                    </div>
                </div>
                @error('role')
                    <span class="text-xs text-red-500 dark:text-red-400 font-medium block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Password -->
                <div class="space-y-1.5">
                    <label for="password" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Kata Sandi</label>
                    <input type="password" name="password" id="password" 
                           class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-4 focus:ring-brand-purple/10 glow-border transition-all duration-200"
                           placeholder="••••••••" required autocomplete="new-password">
                    @error('password')
                        <span class="text-xs text-red-500 dark:text-red-400 font-medium block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="space-y-1.5">
                    <label for="password_confirmation" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-4 focus:ring-brand-purple/10 glow-border transition-all duration-200"
                           placeholder="••••••••" required autocomplete="new-password">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-gradient-brand text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-brand-purple/30 hover:shadow-brand-purple/40 hover:brightness-110 active:brightness-95 transition-all duration-200 transform hover:scale-[1.01] block text-center mt-6">
                Daftar Akun
            </button>
        </form>

        <!-- Login Link -->
        <p class="text-center text-sm text-slate-500 dark:text-gray-400 mt-6">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-brand-purple dark:text-brand-cyan hover:underline font-semibold ml-1">Masuk di sini</a>
        </p>
    </div>

    <script>
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
    </script>
</body>
</html>
