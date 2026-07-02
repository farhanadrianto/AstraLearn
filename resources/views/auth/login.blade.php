<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - AstraLearn</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 dark:bg-[#0f172a] text-slate-800 dark:text-gray-200 font-sans min-h-screen flex items-center justify-center p-6 relative overflow-x-hidden transition-colors duration-300">

    <div class="absolute top-1/4 left-1/4 w-[35rem] h-[35rem] rounded-full bg-brand-purple/5 dark:bg-brand-purple/10 blur-[130px] pointer-events-none animate-pulse-slow"></div>
    <div class="absolute bottom-1/4 right-1/4 w-[35rem] h-[35rem] rounded-full bg-brand-cyan/2 dark:bg-brand-cyan/5 blur-[130px] pointer-events-none"></div>

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

    <div class="w-full max-w-md glass-card rounded-2xl p-8 relative z-10 animate-slide-up">
        
        <div class="flex flex-col items-center mb-8">
            <div class="w-12 h-12 rounded-2xl bg-gradient-brand flex items-center justify-center shadow-lg shadow-brand-purple/40 mb-3">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-wide">Astra<span class="text-brand-purple">Learn</span></h2>
            <p class="text-sm text-slate-500 dark:text-gray-400 mt-1">Masuk ke akun belajar Anda</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl border border-red-500/20 bg-red-500/10 text-red-600 dark:text-red-400 text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            
            <div class="space-y-1.5">
                <label for="email" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Alamat Email</label>
                <div class="relative">
                    <input type="email" name="email" id="email" 
                           class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-4 focus:ring-brand-purple/10 glow-border transition-all duration-200"
                           placeholder="nama@email.com" value="{{ old('email') }}" required autofocus autocomplete="email">
                </div>
                @error('email')
                    <span class="text-xs text-red-500 dark:text-red-400 font-medium block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="password" class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider block">Kata Sandi</label>
                </div>
                <div class="relative">
                    <input type="password" name="password" id="password" 
                           class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-4 focus:ring-brand-purple/10 glow-border transition-all duration-200"
                           placeholder="••••••••" required autocomplete="current-password">
                </div>
                @error('password')
                    <span class="text-xs text-red-500 dark:text-red-400 font-medium block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="p-3.5 rounded-xl border border-slate-200 dark:border-white/5 bg-slate-100/50 dark:bg-white/[0.02] space-y-2.5 text-xs">
                <div class="font-semibold text-slate-400 dark:text-gray-500 uppercase tracking-wider flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Contoh Akun Login
                </div>
                <div class="grid grid-cols-2 gap-3 text-slate-600 dark:text-gray-400">
                    <div class="p-2 rounded-lg bg-white dark:bg-[#121217]/30 border border-slate-100 dark:border-white/5">
                        <span class="font-bold text-brand-purple dark:text-brand-cyan block mb-0.5">Pengajar:</span>
                        <p class="select-all font-mono text-[11px] opacity-90">teacher@astralearn.com</p>
                        <p class="font-mono text-[11px] opacity-60">Pass: password</p>
                    </div>
                    <div class="p-2 rounded-lg bg-white dark:bg-[#121217]/30 border border-slate-100 dark:border-white/5">
                        <span class="font-bold text-brand-purple dark:text-brand-cyan block mb-0.5">Siswa:</span>
                        <p class="select-all font-mono text-[11px] opacity-90">student@astralearn.com</p>
                        <p class="font-mono text-[11px] opacity-60">Pass: password</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center">
                <input id="remember" type="checkbox" name="remember" 
                       class="w-4 h-4 rounded-md border-slate-200 dark:border-white/10 bg-white dark:bg-[#121217]/50 text-brand-purple focus:ring-brand-purple/20 focus:ring-offset-0 transition duration-200">
                <label for="remember" class="ml-2.5 text-sm text-slate-500 dark:text-gray-400 select-none">Ingat saya di perangkat ini</label>
            </div>

            <button type="submit" 
                    class="w-full bg-gradient-brand text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-brand-purple/30 hover:shadow-brand-purple/40 hover:brightness-110 active:brightness-95 transition-all duration-200 transform hover:scale-[1.01] block text-center">
                Masuk
            </button>
        </form>

        <p class="text-center text-sm text-slate-500 dark:text-gray-400 mt-6 select-none">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-brand-purple dark:text-brand-cyan hover:underline font-semibold ml-1">Daftar sekarang</a>
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