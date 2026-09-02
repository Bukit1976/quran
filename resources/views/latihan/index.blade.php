<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100 sm:text-2xl">
                    Mode Latihan Hafalan
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ $ayat->surah->nama }} - Ayat {{ $ayat->nomor_ayat }}
                </p>
            </div>
            <a href="{{ route('quran.show', $ayat->surah_id) }}"
                class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-medium text-gray-900 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl space-y-6">
        <!-- Ayat Lengkap -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">
            <h3 class="mb-4 flex items-center text-lg font-semibold text-gray-900 dark:text-white">
                <svg class="mr-2 h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                Ayat Lengkap
            </h3>
            <div class="font-arabic mb-4 text-right text-3xl leading-loose text-gray-900 dark:text-white sm:text-4xl">
                {{ $ayat->teks_arab }}
            </div>
            <p class="text-center text-sm italic text-emerald-600 dark:text-emerald-400">
                {{ $ayat->transliterasi }}
            </p>
        </div>

        <!-- Pilih Mode Latihan -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                Pilih Mode Latihan
            </h3>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <!-- Mode 1 -->
                <a href="{{ route('latihan.mode', ['ayat' => $ayat->id, 'mode' => 1]) }}"
                    class="group block rounded-xl border-2 border-emerald-200 bg-gradient-to-r from-emerald-50 to-teal-50 p-4 transition hover:border-emerald-500 dark:border-emerald-800 dark:from-emerald-900/20 dark:to-teal-900/20">
                    <div class="mb-2 flex items-center">
                        <span
                            class="mr-3 flex h-8 w-8 items-center justify-center rounded-full bg-emerald-500 font-bold text-white">1</span>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Lihat Lengkap</h4>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Baca dan hafalkan ayat secara utuh</p>
                </a>

                <!-- Mode 2 -->
                <a href="{{ route('latihan.mode', ['ayat' => $ayat->id, 'mode' => 2]) }}"
                    class="group block rounded-xl border-2 border-blue-200 bg-gradient-to-r from-blue-50 to-cyan-50 p-4 transition hover:border-blue-500 dark:border-blue-800 dark:from-blue-900/20 dark:to-cyan-900/20">
                    <div class="mb-2 flex items-center">
                        <span
                            class="mr-3 flex h-8 w-8 items-center justify-center rounded-full bg-blue-500 font-bold text-white">2</span>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Sembunyikan 30%</h4>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Sebagian kata disembunyikan untuk diuji</p>
                </a>

                <!-- Mode 3 -->
                <a href="{{ route('latihan.mode', ['ayat' => $ayat->id, 'mode' => 3]) }}"
                    class="group block rounded-xl border-2 border-amber-200 bg-gradient-to-r from-amber-50 to-orange-50 p-4 transition hover:border-amber-500 dark:border-amber-800 dark:from-amber-900/20 dark:to-orange-900/20">
                    <div class="mb-2 flex items-center">
                        <span
                            class="mr-3 flex h-8 w-8 items-center justify-center rounded-full bg-amber-500 font-bold text-white">3</span>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Sembunyikan 60%</h4>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Lebih banyak kata disembunyikan</p>
                </a>

                <!-- Mode 4 -->
                <a href="{{ route('latihan.mode', ['ayat' => $ayat->id, 'mode' => 4]) }}"
                    class="group block rounded-xl border-2 border-purple-200 bg-gradient-to-r from-purple-50 to-pink-50 p-4 transition hover:border-purple-500 dark:border-purple-800 dark:from-purple-900/20 dark:to-pink-900/20">
                    <div class="mb-2 flex items-center">
                        <span
                            class="mr-3 flex h-8 w-8 items-center justify-center rounded-full bg-purple-500 font-bold text-white">4</span>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Tes Total</h4>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Semua kata disembunyikan, coba dari hafalan</p>
                </a>
            </div>
        </div>

        <!-- Audio Player dengan Pengulangan -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">
            <h3 class="mb-4 flex items-center text-lg font-semibold text-gray-900 dark:text-white">
                <svg class="mr-2 h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                </svg>
                Dengarkan & Ulangi
            </h3>

            @if ($ayat->audio_url)
                <div class="space-y-4">
                    <audio id="audioPlayer" controls class="w-full rounded-lg">
                        <source src="{{ $ayat->audio_url }}" type="audio/mpeg">
                        Browser tidak support.
                    </audio>

                    <div class="grid grid-cols-2 gap-2 sm:grid-cols-4">
                        <button onclick="putarUlang(3)"
                            class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-600">
                            🔁 3x Ulang
                        </button>
                        <button onclick="putarUlang(5)"
                            class="rounded-lg bg-blue-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-600">
                            🔁 5x Ulang
                        </button>
                        <button onclick="putarUlang(10)"
                            class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-amber-600">
                            10x Ulang
                        </button>
                        <button onclick="putarUlang(20)"
                            class="rounded-lg bg-purple-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-purple-600">
                            🔁 20x Ulang
                        </button>
                    </div>

                    <div id="statusPutar" class="hidden text-center text-sm text-gray-600 dark:text-gray-400">
                        Sedang memutar... <span id="counterPutar" class="font-bold text-emerald-600">0</span> / <span
                            id="targetPutar">0</span>
                    </div>
                </div>
            @else
                <p class="text-center text-gray-500 dark:text-gray-400">Audio tidak tersedia</p>
            @endif
        </div>
    </div>

    <script>
        let audioPlayer = document.getElementById('audioPlayer');
        let statusPutar = document.getElementById('statusPutar');
        let counterPutar = document.getElementById('counterPutar');
        let targetPutar = document.getElementById('targetPutar');
        let targetCount = 0;
        let currentCount = 0;

        function putarUlang(jumlah) {
            targetCount = jumlah;
            currentCount = 0;
            statusPutar.classList.remove('hidden');
            targetPutar.textContent = targetCount;
            counterPutar.textContent = currentCount;

            audioPlayer.currentTime = 0;
            audioPlayer.play();
        }

        audioPlayer.addEventListener('ended', function() {
            if (currentCount < targetCount - 1) {
                currentCount++;
                counterPutar.textContent = currentCount;
                audioPlayer.currentTime = 0;
                audioPlayer.play();
            } else {
                currentCount = targetCount;
                counterPutar.textContent = currentCount;
                statusPutar.innerHTML = '<span class="text-emerald-600 font-bold">✅ Selesai!</span>';
            }
        });
    </script>
</x-app-layout>
