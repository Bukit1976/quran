<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-100 sm:text-2xl">
                {{ __('Dashboard Hafalan') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 sm:mt-0">
                {{ now()->translatedFormat('l, d F Y') }}
            </p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Welcome Banner -->
        <div
            class="rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 p-6 text-white shadow-xl sm:p-8">
            <div class="mb-3 flex items-center space-x-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold sm:text-3xl">Assalamu'alaikum, {{ Auth::user()->name }}! </h3>
                    <p class="text-sm text-emerald-100 sm:text-base">Semangat melanjutkan perjalanan menghafal Al-Qur'an
                    </p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4">
            <!-- Target Hari Ini -->
            <div
                class="rounded-xl border border-gray-100 bg-white p-5 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                <div class="mb-4 flex items-center justify-between">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span
                        class="rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">Hari
                        Ini</span>
                </div>
                <h4 class="mb-1 text-sm text-gray-600 dark:text-gray-400">Target Hafalan</h4>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $targetAyat }} <span
                        class="text-sm font-normal text-gray-500">ayat</span></p>
            </div>

            <!-- Hafalan Hari Ini -->
            <div
                class="rounded-xl border border-gray-100 bg-white p-5 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                <div class="mb-4 flex items-center justify-between">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span
                        class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">Progress</span>
                </div>
                <h4 class="mb-1 text-sm text-gray-600 dark:text-gray-400">Tercapai Hari Ini</h4>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $hafalanHariIni }} <span
                        class="text-sm font-normal text-gray-500">/ {{ $targetAyat }}</span></p>
                <div class="mt-2 h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                    <div class="h-2 rounded-full bg-emerald-500 transition-all duration-500"
                        style="width: {{ min(($hafalanHariIni / $targetAyat) * 100, 100) }}%"></div>
                </div>
            </div>

            <!-- Murajaah -->
            <div
                class="rounded-xl border border-gray-100 bg-white p-5 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                <div class="mb-4 flex items-center justify-between">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <span
                        class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">Review</span>
                </div>
                <h4 class="mb-1 text-sm text-gray-600 dark:text-gray-400">Murajaah Hari Ini</h4>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $murajaahHariIni }} <span
                        class="text-sm font-normal text-gray-500">ayat</span></p>
            </div>

            <!-- Total Hafalan -->
            <div
                class="rounded-xl border border-gray-100 bg-white p-5 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                <div class="mb-4 flex items-center justify-between">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span
                        class="rounded-full bg-purple-100 px-2 py-1 text-xs font-semibold text-purple-600 dark:bg-purple-900/30 dark:text-purple-400">Total</span>
                </div>
                <h4 class="mb-1 text-sm text-gray-600 dark:text-gray-400">Total Hafalan</h4>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalHafalan }} <span
                        class="text-sm font-normal text-gray-500">ayat</span></p>
            </div>
        </div>

        <!-- Action Sections -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Tugas Hari Ini -->
            <div
                class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                    <h4 class="flex items-center text-lg font-bold text-white">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        Tugas Hari Ini
                    </h4>
                </div>
                <div class="space-y-3 p-6">
                    <a href="{{ route('quran.index') }}"
                        class="group flex items-center rounded-xl border border-emerald-100 bg-gradient-to-r from-emerald-50 to-teal-50 p-4 transition hover:shadow-md dark:border-emerald-800 dark:from-emerald-900/20 dark:to-teal-900/20">
                        <div
                            class="mr-4 flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-500 font-bold text-white transition group-hover:scale-110">
                            1</div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900 dark:text-white">Hafal Ayat Baru</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pilih surah dan ayat untuk dihafal</p>
                        </div>
                        <svg class="h-5 w-5 text-emerald-600 transition group-hover:translate-x-1 dark:text-emerald-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route('quran.index') }}"
                        class="group flex items-center rounded-xl border border-blue-100 bg-gradient-to-r from-blue-50 to-cyan-50 p-4 transition hover:shadow-md dark:border-blue-800 dark:from-blue-900/20 dark:to-cyan-900/20">
                        <div
                            class="mr-4 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500 font-bold text-white transition group-hover:scale-110">
                            2</div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900 dark:text-white">Dengarkan Audio</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Perdengarkan ayat untuk memudahkan
                                hafalan</p>
                        </div>
                        <svg class="h-5 w-5 text-blue-600 transition group-hover:translate-x-1 dark:text-blue-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Murajaah Section -->
            <div
                class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-4">
                    <h4 class="flex items-center text-lg font-bold text-white">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Murajaah
                    </h4>
                </div>
                <div class="p-6">
                    @if ($murajaahHariIni > 0)
                        <div class="space-y-4">
                            <div
                                class="rounded-xl border-l-4 border-amber-500 bg-gradient-to-r from-amber-50 to-orange-50 p-4 dark:from-amber-900/20 dark:to-orange-900/20">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ $murajaahHariIni }} Ayat</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">perlu dimurajaah hari ini
                                        </p>
                                    </div>
                                    <div
                                        class="flex h-12 w-12 animate-pulse items-center justify-center rounded-full bg-amber-500">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('hafalan.index') }}"
                                class="block w-full transform rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-3 text-center font-bold text-white shadow-lg transition hover:scale-105 hover:from-amber-600 hover:to-orange-700">
                                Mulai Murajaah Sekarang
                            </a>
                        </div>
                    @else
                        <div class="py-8 text-center">
                            <div
                                class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                                <svg class="h-10 w-10 text-emerald-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">Masya Allah!</p>
                            <p class="mb-4 text-gray-600 dark:text-gray-400">Tidak ada murajaah hari ini</p>
                            <p class="text-sm text-gray-500 dark:text-gray-500">Lanjutkan dengan hafalan baru</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="rounded-xl bg-gradient-to-r from-emerald-500 via-teal-600 to-cyan-600 p-6 text-white shadow-xl">
            <div class="grid grid-cols-2 gap-4 text-center md:grid-cols-4">
                <div>
                    <p class="mb-1 text-3xl font-bold">{{ $totalHafalan }}</p>
                    <p class="text-sm text-emerald-100">Total Ayat</p>
                </div>
                <div>
                    <p class="mb-1 text-3xl font-bold">{{ ceil(($totalHafalan / 6236) * 100) }}%</p>
                    <p class="text-sm text-emerald-100">Progress</p>
                </div>
                <div>
                    <p class="mb-1 text-3xl font-bold">{{ $hafalanHariIni }}</p>
                    <p class="text-sm text-emerald-100">Hari Ini</p>
                </div>
                <div>
                    <p class="mb-1 text-3xl font-bold">{{ $murajaahHariIni }}</p>
                    <p class="text-sm text-emerald-100">Murajaah</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Cek apakah ada murajaah hari ini (data dari controller)
        const murajaahHariIni = {{ $murajaahHariIni }};

        if (murajaahHariIni > 0) {
            // Minta izin notifikasi browser
            if (Notification.permission === "granted") {
                tampilkanNotifikasi(murajaahHariIni);
            } else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                        tampilkanNotifikasi(murajaahHariIni);
                    }
                });
            }
        }

        function tampilkanNotifikasi(jumlah) {
            const notifikasi = new Notification("⏰ Pengingat Murajaah HafalQuran", {
                body: `Assalamu'alaikum! Anda memiliki ${jumlah} ayat yang perlu dimurajaah hari ini. Semangat!`,
                icon: "https://cdn-icons-png.flaticon.com/512/3018/3018523.png",
                badge: "https://cdn-icons-png.flaticon.com/512/3018/3018523.png"
            });

            // Buka halaman murajaah saat diklik
            notifikasi.onclick = function() {
                window.focus();
                window.location.href = "{{ route('murajaah.index') }}";
            };
        }
    </script>
</x-app-layout>
