<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    darkMode: localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches),
    mobileMenuOpen: false,
    init() {
        if (this.darkMode) document.documentElement.classList.add('dark');
    },
    toggleDarkMode() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
        this.darkMode ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark');
    }
}" :class="{ 'dark': darkMode }"
    class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#10b981">
    <title>@yield('title', 'HafalQuran')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-arabic {
            font-family: 'Amiri', serif;
        }
    </style>
    @stack('styles')
</head>

<body
    class="min-h-screen bg-gray-50 text-gray-900 antialiased transition-colors duration-300 dark:bg-gray-950 dark:text-gray-100">
    <div class="flex min-h-screen flex-col">
        <!-- Navigation -->
        <nav
            class="sticky top-0 z-50 border-b border-gray-200/50 bg-white/80 shadow-sm backdrop-blur-xl transition-colors duration-300 dark:border-gray-800/50 dark:bg-gray-900/80">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex flex-1 items-center justify-between md:justify-start">
                        <a href="{{ route('dashboard') }}" class="group flex flex-shrink-0 items-center space-x-3">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <span class="text-lg font-bold text-gray-900 dark:text-white">HafalQuran</span>
                        </a>
                        <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="rounded-xl p-2 text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 md:hidden">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <div class="hidden md:ml-10 md:flex md:space-x-2">
                            @php
                                $menuItems = [
                                    ['route' => 'dashboard', 'label' => 'Dashboard'],
                                    ['route' => 'quran.index', 'label' => "Al-Qur'an"],
                                    ['route' => 'juz.index', 'label' => 'Juz'],
                                    ['route' => 'hafalan.index', 'label' => 'Hafalan'],
                                    ['route' => 'murajaah.index', 'label' => 'Murajaah'],
                                    ['route' => 'tes.index', 'label' => 'Tes'],
                                    ['route' => 'statistik.index', 'label' => 'Statistik'],
                                    ['route' => 'ai.index', 'label' => 'AI'],
                                ];
                            @endphp
                            @foreach ($menuItems as $item)
                                <a href="{{ route($item['route']) }}"
                                    class="{{ request()->routeIs($item['route']) ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-200' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }} rounded-lg px-3 py-2 text-sm font-medium transition-all">
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button @click="toggleDarkMode()"
                            class="rounded-xl bg-gray-100 p-2.5 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                            <svg x-show="!darkMode" class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            <svg x-show="darkMode" x-cloak class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>
                        <div x-data="{ dropdownOpen: false }" class="relative" @click.away="dropdownOpen = false">
                            <button @click="dropdownOpen = !dropdownOpen"
                                class="flex items-center space-x-2 rounded-xl p-1.5 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <div
                                    class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 font-semibold text-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span
                                    class="hidden text-sm font-medium text-gray-700 dark:text-gray-300 lg:block">{{ Auth::user()->name }}</span>
                            </button>
                            <div x-show="dropdownOpen" x-cloak
                                class="absolute right-0 z-50 mt-2 w-56 origin-top-right rounded-xl border border-gray-200 bg-white py-1 shadow-xl dark:border-gray-700 dark:bg-gray-800">
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700/50">Profil</a>
                                <a href="{{ route('settings.index') }}"
                                    class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700/50">Pengaturan</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex w-full items-center px-4 py-2.5 text-left text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20">Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div x-show="mobileMenuOpen" x-cloak
                    class="border-t border-gray-200 py-4 dark:border-gray-700 md:hidden">
                    <div class="flex flex-col space-y-1">
                        @foreach ($menuItems as $item)
                            <a href="{{ route($item['route']) }}"
                                class="rounded-lg px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800">{{ $item['label'] }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            @hasSection('header')
                <header
                    class="border-b border-gray-200 bg-white/50 backdrop-blur-sm dark:border-gray-800 dark:bg-gray-900/50">
                    <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </header>
            @endif
            <div class="py-6 sm:py-8 lg:py-10">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </div>
        </main>

        <footer class="mt-auto border-t border-gray-200 bg-white py-8 dark:border-gray-800 dark:bg-gray-900">
            <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
                <p class="text-sm text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} HafalQuran</p>
            </div>
        </footer>
    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
            class="fixed bottom-6 right-6 z-50 flex items-center space-x-3 rounded-xl bg-emerald-600 px-5 py-3 text-white shadow-2xl">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @stack('scripts')
</body>

</html>
