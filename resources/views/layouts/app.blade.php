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
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#10b981">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="HafalQuran">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    <link rel="manifest" href="/manifest.json">

    <!-- Icon untuk berbagai device -->
    <link rel="icon" type="image/png" sizes="32x32" href="/icons/icon-192x192.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icons/icon-192x192.png">
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Config untuk Tailwind (PERBAIKAN DI SINI) -->
    <script>
        tailwind.config = {
            darkMode: 'class', // <--- INI KUNCINYA PAK! Agar tombol dark mode berfungsi
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#8b5cf6',
                    }
                }
            }
        }
    </script>

    {{-- Apply User Settings --}}
    @if (isset($userSettings))
        <style>
            .quran-text {
                font-size: {{ $userSettings->ukuran_font_arabic ?? 18 }}px !important;
            }

            .latin-text {
                font-size: {{ $userSettings->ukuran_font_latin ?? 16 }}px !important;
                display: {{ $userSettings->aktifkan_latin ? 'block' : 'none' }} !important;
            }

            .translation-text {
                font-size: {{ $userSettings->ukuran_font_terjemahan ?? 16 }}px !important;
                display: {{ $userSettings->aktifkan_terjemahan ? 'block' : 'none' }} !important;
            }

            @if (!$userSettings->tajwid_berwarna)
                .quran-word {
                    color: inherit !important;
                    text-shadow: none !important;
                }
            @endif
            @if ($userSettings->tema_aplikasi === 'gelap')
                html {
                    filter: invert(1) hue-rotate(180deg);
                }

                img,
                video,
                canvas {
                    filter: invert(1) hue-rotate(180deg);
                }
            @elseif($userSettings->tema_aplikasi === 'terang')
                html.dark {
                    filter: none !important;
                }
            @endif
        </style>
    @endif

    <!-- Alpine.js (Pindahkan ke head agar x-data di <html> terbaca dengan baik) -->
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
                            <img src="{{ asset('Logo/LogoNew.png') }}" alt="HafalQuran Logo"
                                class="h-10 w-auto rounded-xl">
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
                                    ['route' => 'jadwal-sholat.index', 'label' => 'Jadwal Sholat'],
                                    ['route' => 'alarm.index', 'label' => 'Alarm'],
                                    ['route' => 'doa.index', 'label' => 'Doa'],
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
                        <!-- Tombol Dark Mode -->
                        <button @click="toggleDarkMode()"
                            class="rounded-xl bg-gray-100 p-2.5 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors">
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

                        <!-- Dropdown User -->
                        <div x-data="{ dropdownOpen: false }" class="relative" @click.away="dropdownOpen = false">
                            <button @click="dropdownOpen = !dropdownOpen"
                                class="flex items-center space-x-2 rounded-xl p-1.5 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                <div
                                    class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 font-semibold text-white">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                </div>
                                <span
                                    class="hidden text-sm font-medium text-gray-700 dark:text-gray-300 lg:block">{{ Auth::user()->name ?? 'User' }}</span>
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

                <!-- Mobile Menu -->
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

        <!-- Footer -->
        <footer class="mt-auto border-t border-gray-200 bg-white py-8 dark:border-gray-800 dark:bg-gray-900">
            <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
                <p class="text-sm text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} HafalQuran</p>
            </div>
        </footer>
    </div>

    <!-- Toast Notification -->
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
            class="fixed bottom-6 right-6 z-50 flex items-center space-x-3 rounded-xl bg-emerald-600 px-5 py-3 text-white shadow-2xl">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    <!-- Script Firebase untuk Notifikasi -->
    <script type="module">
        // 1. Import fungsi yang dibutuhkan langsung dari CDN Firebase
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import {
            getMessaging,
            getToken,
            onMessage
        } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-messaging.js";

        // 2. Konfigurasi Firebase (Sesuai punya Bapak)
        const firebaseConfig = {
            apiKey: "AIzaSyAs0Ma5FvLJKWi-fcW2JV2_XcneBc7DVtQ",
            authDomain: "hafalan-alquran.firebaseapp.com",
            projectId: "hafalan-alquran",
            storageBucket: "hafalan-alquran.firebasestorage.app",
            messagingSenderId: "508902061866",
            appId: "1:508902061866:web:80932deab28134d73c9053",
            measurementId: "G-F6VZ2YRSH0"
        };

        // 3. Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const messaging = getMessaging(app);

        // 4. Fungsi untuk meminta izin notifikasi & mengambil Token
        async function requestNotificationPermission() {
            const permission = await Notification.requestPermission();
            if (permission === 'granted') {
                console.log('Izin notifikasi diberikan!');

                // PENTING: Ganti string di bawah ini dengan VAPID Key dari Firebase Console
                const vapidKey =
                    "BEHv79407C1fr2NjZC7Q3Hzpxssum8bPZyn0ec2RCw4CZ7QSIETvz3pahYSRyYENTMuvf6zJmWQjdGHdbtpVchI";

                const token = await getToken(messaging, {
                    vapidKey: vapidKey
                });
                console.log('FCM Token User:', token);

                // Kirim token ini ke Laravel untuk disimpan di database
                await fetch('/save-fcm-token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        token: token
                    })
                });

                alert("Notifikasi berhasil diaktifkan!");
            } else {
                console.log('Izin notifikasi ditolak user.');
            }
        }

        // 5. Tangani pesan saat website sedang dibuka (foreground)
        onMessage(messaging, (payload) => {
            console.log('Pesan diterima: ', payload);
            // Nanti bisa diganti dengan tampilan Toast Alpine.js yang lebih cantik
            alert(payload.notification.title + ': ' + payload.notification.body);
        });

        // Membuat fungsi tersedia secara global agar bisa dipanggil dari tombol HTML
        window.requestNotificationPermission = requestNotificationPermission;
    </script>
    @stack('scripts')
</body>

</html
