<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - AstraLearn</title>
    
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

    <!-- Tailwind & Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- AlpineJS for quick UI state management -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @yield('styles')
</head>
<body class="bg-slate-50 dark:bg-[#0f172a] text-slate-800 dark:text-gray-200 font-sans min-h-screen relative overflow-x-hidden transition-colors duration-300 selection:bg-brand-purple/30 selection:text-white" x-data="{ sidebarOpen: false }">

    <!-- Decorative glowing background blobs -->
    <div class="absolute top-[-10%] right-[-5%] w-[40rem] h-[40rem] rounded-full bg-brand-purple/5 dark:bg-brand-purple/10 blur-[120px] pointer-events-none animate-pulse-slow"></div>
    <div class="absolute bottom-[-10%] left-[-5%] w-[40rem] h-[40rem] rounded-full bg-brand-cyan/2 dark:bg-brand-cyan/5 blur-[120px] pointer-events-none"></div>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 glass-panel fixed inset-y-0 left-0 z-40 transform lg:translate-x-0 transition-all duration-300 ease-in-out flex flex-col justify-between"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
            
            <div class="p-6">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-brand flex items-center justify-center shadow-lg shadow-brand-purple/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-extrabold text-slate-800 dark:text-white tracking-wider">Astra<span class="text-brand-purple">Learn</span></span>
                        <p class="text-[10px] text-slate-500 dark:text-gray-400 font-medium uppercase tracking-widest mt-[-2px]">Education SaaS</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="mt-8 space-y-2">
                    @auth
                        @if(Auth::user()->isSiswa())
                            <!-- SISWA NAVIGATION -->
                            @php $isActive = Route::is('siswa.dashboard'); @endphp
                            <a href="{{ $isActive ? 'javascript:void(0)' : route('siswa.dashboard') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $isActive ? 'bg-brand-purple/10 text-brand-purple border border-brand-purple/20 font-medium dark:bg-brand-purple/20 dark:text-white dark:border-brand-purple/30 pointer-events-none cursor-default' : 'text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/5' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
                                </svg>
                                <span>Dashboard</span>
                            </a>
                            
                            @php $isActive = Route::is('siswa.courses.index') || Route::is('siswa.courses.show') || Route::is('siswa.materials.show') || Route::is('siswa.assignments.show'); @endphp
                            <a href="{{ $isActive ? 'javascript:void(0)' : route('siswa.courses.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $isActive ? 'bg-brand-purple/10 text-brand-purple border border-brand-purple/20 font-medium dark:bg-brand-purple/20 dark:text-white dark:border-brand-purple/30 pointer-events-none cursor-default' : 'text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/5' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span>Kursus Saya</span>
                            </a>
                            
                            @php $isActive = Route::is('siswa.courses.explore'); @endphp
                            <a href="{{ $isActive ? 'javascript:void(0)' : route('siswa.courses.explore') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $isActive ? 'bg-brand-purple/10 text-brand-purple border border-brand-purple/20 font-medium dark:bg-brand-purple/20 dark:text-white dark:border-brand-purple/30 pointer-events-none cursor-default' : 'text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/5' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span>Cari Kursus</span>
                            </a>
                            
                            @php $isActive = Route::is('siswa.schedule.index'); @endphp
                            <a href="{{ $isActive ? 'javascript:void(0)' : route('siswa.schedule.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $isActive ? 'bg-brand-purple/10 text-brand-purple border border-brand-purple/20 font-medium dark:bg-brand-purple/20 dark:text-white dark:border-brand-purple/30 pointer-events-none cursor-default' : 'text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/5' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Jadwal Kelas</span>
                            </a>
                            
                            @php $isActive = Route::is('siswa.profile'); @endphp
                            <a href="{{ $isActive ? 'javascript:void(0)' : route('siswa.profile') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $isActive ? 'bg-brand-purple/10 text-brand-purple border border-brand-purple/20 font-medium dark:bg-brand-purple/20 dark:text-white dark:border-brand-purple/30 pointer-events-none cursor-default' : 'text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/5' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Profil Saya</span>
                            </a>
                        @elseif(Auth::user()->isPengajar())
                            <!-- PENGAJAR NAVIGATION -->
                            @php $isActive = Route::is('pengajar.dashboard'); @endphp
                            <a href="{{ $isActive ? 'javascript:void(0)' : route('pengajar.dashboard') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $isActive ? 'bg-brand-purple/10 text-brand-purple border border-brand-purple/20 font-medium dark:bg-brand-purple/20 dark:text-white dark:border-brand-purple/30 pointer-events-none cursor-default' : 'text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/5' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
                                </svg>
                                <span>Dashboard</span>
                            </a>
                            
                            @php $isActive = Route::is('pengajar.courses.index') || Route::is('pengajar.courses.show') || Route::is('pengajar.courses.create') || Route::is('pengajar.courses.edit'); @endphp
                            <a href="{{ $isActive ? 'javascript:void(0)' : route('pengajar.courses.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $isActive ? 'bg-brand-purple/10 text-brand-purple border border-brand-purple/20 font-medium dark:bg-brand-purple/20 dark:text-white dark:border-brand-purple/30 pointer-events-none cursor-default' : 'text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/5' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span>Kelola Kursus</span>
                            </a>
                            
                            @php $isActive = Route::is('pengajar.submissions.index'); @endphp
                            <a href="{{ $isActive ? 'javascript:void(0)' : route('pengajar.submissions.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $isActive ? 'bg-brand-purple/10 text-brand-purple border border-brand-purple/20 font-medium dark:bg-brand-purple/20 dark:text-white dark:border-brand-purple/30 pointer-events-none cursor-default' : 'text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/5' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                <span>Nilai Tugas</span>
                            </a>
                            
                            @php $isActive = Route::is('pengajar.schedule.index'); @endphp
                            <a href="{{ $isActive ? 'javascript:void(0)' : route('pengajar.schedule.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $isActive ? 'bg-brand-purple/10 text-brand-purple border border-brand-purple/20 font-medium dark:bg-brand-purple/20 dark:text-white dark:border-brand-purple/30 pointer-events-none cursor-default' : 'text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/5' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Jadwal Mengajar</span>
                            </a>
                            
                            @php $isActive = Route::is('pengajar.profile'); @endphp
                            <a href="{{ $isActive ? 'javascript:void(0)' : route('pengajar.profile') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $isActive ? 'bg-brand-purple/10 text-brand-purple border border-brand-purple/20 font-medium dark:bg-brand-purple/20 dark:text-white dark:border-brand-purple/30 pointer-events-none cursor-default' : 'text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/5' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Profil Saya</span>
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>

            <!-- User profile footer / Logout -->
            @auth
                <div class="p-6 border-t border-slate-200/50 dark:border-white/5">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-brand-purple/20 border border-brand-purple flex items-center justify-center text-brand-purple font-bold">
                            @if(Auth::user()->profile_photo)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                {{ substr(Auth::user()->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <p class="text-sm font-semibold text-slate-800 dark:text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500 dark:text-gray-400 capitalize">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-white/10 hover:border-red-500/30 hover:bg-red-500/10 text-slate-500 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-400 text-sm font-medium transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            @endauth
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col lg:pl-64 min-h-screen">
            <!-- Header -->
            <header class="h-20 glass-header sticky top-0 z-30 px-6 flex items-center justify-between">
                <!-- Left: Title & Mobile menu button -->
                <div class="flex items-center gap-4">
                    <button class="lg:hidden text-slate-500 hover:text-slate-800 dark:text-gray-400 dark:hover:text-white focus:outline-none" @click="sidebarOpen = !sidebarOpen">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h1 class="text-xl font-bold text-slate-800 dark:text-white tracking-wide">@yield('page-title', 'Dashboard')</h1>
                </div>

                <!-- Right: Theme Toggle & Notification / Quick Access -->
                <div class="flex items-center gap-4">
                    <!-- Toggle Theme Button -->
                    <button onclick="toggleTheme()" class="p-2.5 rounded-xl border border-slate-200 dark:border-white/10 hover:bg-slate-100 dark:hover:bg-white/5 text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white transition duration-200 focus:outline-none" title="Ubah Tema">
                        <!-- Moon icon for light mode (shows when root DOES NOT have .dark class) -->
                        <svg class="w-4.5 h-4.5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                        <!-- Sun icon for dark mode (shows when root HAS .dark class) -->
                        <svg class="w-4.5 h-4.5 hidden dark:block text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707-.707m12.728 0l-.707.707M6.343 6.343l-.707-.707M14.25 12a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                        </svg>
                    </button>

                    <span class="text-xs px-3 py-1.5 rounded-full border border-brand-purple/20 bg-brand-purple/10 text-brand-purple font-semibold tracking-wide uppercase">
                        {{ Auth::check() ? Auth::user()->role : 'Guest' }} Portal
                    </span>
                </div>
            </header>

            <!-- Main Page Content -->
            <main class="flex-1 p-6 md:p-8 overflow-y-auto animate-fade-in">
                <!-- Notification Alerts -->
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-sm font-medium flex items-center justify-between animate-slide-up" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button class="text-emerald-500 dark:text-emerald-400 hover:opacity-75 font-bold focus:outline-none" @click="show = false">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-xl border border-red-500/20 bg-red-500/10 text-red-600 dark:text-red-400 text-sm font-medium flex items-center justify-between animate-slide-up" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button class="text-red-500 dark:text-red-400 hover:opacity-75 font-bold focus:outline-none" @click="show = false">&times;</button>
                    </div>
                @endif

                @yield('content')

                <!-- Footer -->

            </main>
        </div>
    </div>

    <!-- Mobile Drawer Overlay -->
    <div class="fixed inset-0 bg-black/40 dark:bg-black/60 z-30 lg:hidden transition-opacity duration-300"
         :class="sidebarOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'"
         @click="sidebarOpen = false"></div>

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
    @yield('scripts')
</body>
</html>
