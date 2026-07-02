<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstraLearn - Modern Education SaaS Platform</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
</head>
<body class="bg-slate-50 dark:bg-[#0f172a] text-slate-800 dark:text-gray-200 font-sans min-h-screen relative overflow-x-hidden transition-colors duration-300 selection:bg-brand-purple/30 selection:text-white">

    <!-- Ambient glowing backgrounds -->
    <div class="absolute top-[-10%] right-[-5%] w-[45rem] h-[45rem] rounded-full bg-brand-purple/5 dark:bg-brand-purple/10 blur-[130px] pointer-events-none animate-pulse-slow"></div>
    <div class="absolute bottom-[-10%] left-[-5%] w-[45rem] h-[45rem] rounded-full bg-brand-cyan/2 dark:bg-brand-cyan/5 blur-[130px] pointer-events-none"></div>

    <!-- Navigation Header -->
    <header class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between relative z-10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-brand flex items-center justify-center shadow-lg shadow-brand-purple/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <span class="text-xl font-extrabold text-slate-800 dark:text-white tracking-wider">Astra<span class="text-brand-purple">Learn</span></span>
        </div>

        <div class="flex items-center gap-4">
            <!-- Theme Toggle -->
            <button onclick="toggleTheme()" class="p-2.5 rounded-xl border border-slate-200 dark:border-white/10 hover:bg-slate-100 dark:hover:bg-white/5 text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white transition duration-200 focus:outline-none" title="Ubah Tema">
                <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
                <svg class="w-4 h-4 hidden dark:block text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707-.707m12.728 0l-.707.707M6.343 6.343l-.707-.707M14.25 12a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                </svg>
            </button>

            @auth
                <a href="{{ Auth::user()->isSiswa() ? route('siswa.dashboard') : route('pengajar.dashboard') }}" 
                   class="px-5 py-2.5 rounded-xl bg-brand-purple/20 text-brand-purple dark:text-white border border-brand-purple/30 text-sm font-semibold hover:bg-brand-purple/30 transition-all duration-200">
                    Buka Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white transition duration-200">Masuk</a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-gradient-brand text-white text-sm font-bold shadow-lg shadow-brand-purple/20 hover:shadow-brand-purple/30 transition-all duration-200">Daftar</a>
            @endauth
        </div>
    </header>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 pt-16 pb-24 relative z-10 text-center flex flex-col items-center">
        <span class="px-4 py-1.5 rounded-full border border-brand-purple/30 bg-brand-purple/10 text-brand-purple text-xs font-bold uppercase tracking-widest mb-6 animate-fade-in block">
            🚀 Platform LMS Masa Depan 2026
        </span>
        
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight max-w-4xl animate-slide-up">
            Kuasai Skill Masa Depan dengan <span class="text-gradient">AstraLearn</span>
        </h1>
        
        <p class="text-slate-500 dark:text-gray-400 text-base md:text-xl mt-6 max-w-2xl animate-fade-in">
            Belajar interaktif dengan kurikulum terarah, materi video premium, pelacakan progres real-time, dan feedback langsung dari pengajar ahli.
        </p>

        <div class="flex flex-col sm:flex-row items-center gap-4 mt-10 animate-fade-in">
            <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-brand text-white font-extrabold shadow-lg shadow-brand-purple/30 hover:shadow-brand-purple/40 hover:scale-[1.02] transition-all duration-200 text-center">
                Mulai Belajar Sekarang
            </a>
            <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl border border-slate-200 dark:border-white/10 hover:border-slate-300 dark:hover:border-white/20 bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 font-bold text-slate-800 dark:text-white transition-all duration-200 text-center">
                Portal Pengajar
            </a>
        </div>

        <!-- Quick Platform Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl w-full mt-24 animate-slide-up">
            <div class="glass-card rounded-2xl p-6 text-center">
                <span class="text-3xl font-extrabold text-slate-900 dark:text-white block">15+</span>
                <span class="text-xs text-slate-500 dark:text-gray-400 mt-1 block uppercase tracking-wider">Kursus Premium</span>
            </div>
            <div class="glass-card rounded-2xl p-6 text-center">
                <span class="text-3xl font-extrabold text-brand-purple block">1.2K+</span>
                <span class="text-xs text-slate-500 dark:text-gray-400 mt-1 block uppercase tracking-wider">Siswa Aktif</span>
            </div>
            <div class="glass-card rounded-2xl p-6 text-center">
                <span class="text-3xl font-extrabold text-brand-cyan block">98%</span>
                <span class="text-xs text-slate-500 dark:text-gray-400 mt-1 block uppercase tracking-wider">Tingkat Kepuasan</span>
            </div>
            <div class="glass-card rounded-2xl p-6 text-center">
                <span class="text-3xl font-extrabold text-slate-900 dark:text-white block">24/7</span>
                <span class="text-xs text-slate-500 dark:text-gray-400 mt-1 block uppercase tracking-wider">Bimbingan Pengajar</span>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="max-w-7xl mx-auto px-6 py-12 relative z-10 border-t border-slate-200 dark:border-white/5">
        <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white text-center mb-12">Mengapa Memilih AstraLearn?</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="glass-card rounded-2xl p-8 hover:border-brand-purple/30 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-brand-purple/20 flex items-center justify-center text-brand-purple mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Kurikulum Terstruktur</h3>
                <p class="text-slate-500 dark:text-gray-400 text-sm leading-relaxed">
                    Materi diatur secara kronologis dan logis, memudahkan pemahaman konsep dasar hingga lanjutan.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="glass-card rounded-2xl p-8 hover:border-brand-cyan/30 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-brand-cyan/20 flex items-center justify-center text-brand-cyan mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Materi Video Premium</h3>
                <p class="text-slate-500 dark:text-gray-400 text-sm leading-relaxed">
                    Tonton video penjelasan interaktif berkualitas tinggi yang bisa diakses kapan saja dan di mana saja.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="glass-card rounded-2xl p-8 hover:border-brand-purple/30 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-brand-purple/20 flex items-center justify-center text-brand-purple mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Penilaian & Umpan Balik</h3>
                <p class="text-slate-500 dark:text-gray-400 text-sm leading-relaxed">
                    Kumpulkan tugas langsung di sistem dan dapatkan feedback terperinci serta nilai dari pengajar Anda.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 border-t border-slate-200 dark:border-white/5 text-center text-xs text-slate-500 dark:text-gray-500 relative z-10">
        <p>&copy; 2026 AstraLearn. Platform LMS Premium Masa Kini.</p>
    </footer>

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
