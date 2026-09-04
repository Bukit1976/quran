@extends('layouts.app')

@section('title', 'Surah ' . $surah->nama)

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-100 sm:text-2xl">
                Surah {{ $surah->nama }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $surah->jumlah_ayat }} Ayat</p>
        </div>
        <div class="font-arabic text-3xl text-emerald-600 dark:text-emerald-400 sm:text-4xl">
            {{ $surah->nama_arab }}
        </div>
    </div>
@endsection

@section('content')
    @php
        // Dapatkan base URL qori dari settings
        $qoriBaseUrl = 'https://everyayah.com/data/Alafasy_128kbps/';

        if (isset($userSettings) && $userSettings) {
            $qoriBaseUrl = match ($userSettings->qori_murattal) {
                'abdul_basit' => 'https://everyayah.com/data/Abdul_Basit_128kbps/',
                'maher_almuaiqly' => 'https://everyayah.com/data/Maher_AlMuaiqly_128kbps/',
                'saad_ghamdi' => 'https://everyayah.com/data/Saad_AlGhamdi_128kbps/',
                'ahmad_alajamy' => 'https://everyayah.com/data/Ahmad_ibn_Ali_al-Ajamy_128kbps/',
                default => 'https://everyayah.com/data/Alafasy_128kbps/',
            };
        }
    @endphp

    {{-- Container utama dengan dark mode support --}}
    <div class="min-h-screen bg-gray-50 transition-colors duration-300 dark:bg-gray-900">

        {{-- Tombol Kontrol Audio --}}
        <div
            class="sticky top-20 z-40 mx-4 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 p-4 shadow-lg dark:from-emerald-700 dark:to-teal-800 sm:mx-6 lg:mx-8">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <button onclick="playAll()"
                    class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-bold text-emerald-600 transition hover:bg-emerald-50 dark:bg-gray-100">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    </svg>
                    Putar Semua
                </button>
                <button onclick="stopAll()"
                    class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-bold text-red-600 transition hover:bg-red-50 dark:bg-gray-100">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                    </svg>
                    Stop
                </button>
                <button onclick="downloadAll()"
                    class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-bold text-blue-600 transition hover:bg-blue-50 dark:bg-gray-100">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download
                </button>
            </div>
        </div>

        <div class="space-y-4 px-4 py-6 sm:space-y-6 sm:px-6 lg:px-8">

            {{-- BISMILLAH DENGAN AUDIO --}}
            @if ($surah->nomor != 9 && $surah->nomor != 1)
                <div id="ayat-container-bismillah"
                    class="ayat-container rounded-xl border-2 border-gray-200 bg-white p-4 shadow-sm transition-all duration-500 dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                    <div class="mb-4 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
                        <span
                            class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300 sm:text-sm">
                            Basmalah
                        </span>
                        <div class="flex w-full items-center justify-between gap-2 sm:w-auto">
                            <button onclick="toggleAyat('bismillah')" id="btn-play-bismillah"
                                class="flex items-center gap-1 rounded-lg bg-emerald-500 px-3 py-2 text-xs font-bold text-white transition hover:bg-emerald-600 sm:gap-2 sm:px-4 sm:text-sm">
                                <svg id="icon-play-bismillah" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                </svg>
                                <svg id="icon-pause-bismillah" class="hidden h-4 w-4 sm:h-5 sm:w-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 9v6m4-6v6" />
                                </svg>
                                <span id="text-play-bismillah">Putar</span>
                            </button>
                            <audio id="audio-bismillah" class="hidden" data-ayat-id="bismillah" data-index="-1">
                                <source src="{{ $qoriBaseUrl }}001001.mp3" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>

                    <div class="font-arabic quran-text mb-4 text-right text-2xl text-gray-900 dark:text-white sm:text-3xl lg:text-4xl"
                        id="ayat-text-bismillah" dir="rtl">
                        @php
                            $words = preg_split('/\s+/', trim('بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ'));
                        @endphp
                        @foreach ($words as $wIdx => $word)
                            <span class="quran-word" data-word-index="{{ $wIdx }}">{{ $word }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Cek apakah ada Ayat 1 di database --}}
            @php
                $firstAyat = $surah->ayats->first();
                $hasAyat1 = $firstAyat && $firstAyat->nomor_ayat == 1;
            @endphp

            @if (!$hasAyat1 && $surah->nomor != 1)
                <div
                    class="rounded-xl border-2 border-yellow-400 bg-yellow-50 p-4 dark:border-yellow-600 dark:bg-yellow-900/20">
                    <p class="text-sm text-yellow-800 dark:text-yellow-300">
                        <strong>⚠️ Catatan:</strong> Database tidak memiliki Ayat 1 untuk surah ini.
                    </p>
                </div>
            @endif

            {{-- Daftar Ayat --}}
            @foreach ($surah->ayats as $index => $ayat)
                {{-- TAMBAHAN: scroll-mt-28 agar tidak tertutup header saat di-scroll otomatis --}}
                <div id="ayat-container-{{ $ayat->id }}"
                    class="ayat-container scroll-mt-28 rounded-xl border-2 border-gray-200 bg-white p-4 shadow-sm transition-all duration-500 dark:border-gray-700 dark:bg-gray-800 sm:p-6">

                    <div class="mb-4 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
                        <span
                            class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300 sm:text-sm">
                            Ayat {{ $ayat->nomor_ayat }}
                        </span>
                        <div class="flex w-full items-center justify-between gap-2 sm:w-auto">
                            @if ($ayat->audio_url)
                                <button onclick="toggleAyat({{ $ayat->id }})" id="btn-play-{{ $ayat->id }}"
                                    class="flex items-center gap-1 rounded-lg bg-emerald-500 px-3 py-2 text-xs font-bold text-white transition hover:bg-emerald-600 sm:gap-2 sm:px-4 sm:text-sm">
                                    <svg id="icon-play-{{ $ayat->id }}" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    </svg>
                                    <svg id="icon-pause-{{ $ayat->id }}" class="hidden h-4 w-4 sm:h-5 sm:w-5"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 9v6m4-6v6" />
                                    </svg>
                                    <span id="text-play-{{ $ayat->id }}">Putar</span>
                                </button>

                                <audio id="audio-{{ $ayat->id }}" class="hidden" data-ayat-id="{{ $ayat->id }}"
                                    data-index="{{ $index }}">
                                    <source
                                        src="{{ $qoriBaseUrl }}{{ str_pad($surah->nomor, 3, '0', STR_PAD_LEFT) }}{{ str_pad($ayat->nomor_ayat, 3, '0', STR_PAD_LEFT) }}.mp3"
                                        type="audio/mpeg">
                                </audio>
                            @endif

                            <a href="{{ route('hafalan.mulai', $ayat->id) }}"
                                class="flex-shrink-0 whitespace-nowrap rounded-lg bg-emerald-500 px-3 py-2 text-xs font-medium text-white transition hover:bg-emerald-600 sm:text-sm">
                                Mulai Hafal
                            </a>
                        </div>
                    </div>

                    <div class="font-arabic quran-text mb-4 text-right text-2xl text-gray-900 dark:text-white sm:text-3xl lg:text-4xl"
                        id="ayat-text-{{ $ayat->id }}" dir="rtl">
                        @php
                            $words = preg_split('/\s+/', trim($ayat->teks_arab));
                        @endphp
                        @foreach ($words as $wIdx => $word)
                            <span class="quran-word" data-word-index="{{ $wIdx }}">{{ $word }}</span>
                        @endforeach
                    </div>

                    @if ($ayat->transliterasi && trim($ayat->transliterasi) != '')
                        <div class="mb-3 rounded-lg bg-emerald-50 p-3 dark:bg-emerald-900/20">
                            <p class="text-sm italic text-emerald-700 dark:text-emerald-300 sm:text-base">
                                {{ $ayat->transliterasi }}
                            </p>
                        </div>
                    @endif

                    <div class="border-t border-gray-200 pt-3 dark:border-gray-700">
                        <p class="text-sm text-gray-700 dark:text-gray-300 sm:text-base">
                            {{ $ayat->terjemahan }}
                        </p>
                    </div>

                    @if ($ayat->audio_url)
                        <div class="mt-3 text-right">
                            <a href="{{ $qoriBaseUrl }}{{ str_pad($surah->nomor, 3, '0', STR_PAD_LEFT) }}{{ str_pad($ayat->nomor_ayat, 3, '0', STR_PAD_LEFT) }}.mp3"
                                download
                                class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download Audio
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach

            <div class="mt-6 pb-8 text-center">
                <a href="{{ route('quran.index') }}"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    ← Kembali ke Daftar Surah
                </a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .quran-text {
            font-family: 'Amiri', 'Traditional Arabic', 'Scheherazade', serif !important;
            font-size: 28px !important;
            line-height: 2.8 !important;
            text-align: right !important;
            max-width: 100% !important;
            direction: rtl !important;
            word-spacing: 0.1em !important;
            letter-spacing: 0 !important;
            text-justify: none !important;
            text-align-last: right !important;
            white-space: normal !important;
        }

        .quran-word {
            display: inline !important;
            margin: 0 2px !important;
            padding: 0 !important;
            transition: color 0.15s ease, text-shadow 0.15s ease !important;
            border-radius: 0 !important;
            background: transparent !important;
        }

        .quran-word.active-word {
            color: #fbbf24 !important;
            background: transparent !important;
            text-shadow: 0 0 10px rgba(251, 191, 36, 0.5), 0 0 20px rgba(251, 191, 36, 0.3) !important;
            font-weight: 700 !important;
            transform: none !important;
            padding: 0 !important;
        }

        .quran-word.read-word {
            opacity: 0.5;
            transition: opacity 0.3s ease;
        }

        .ayat-container.active {
            border-color: #10b981 !important;
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.5) !important;
            background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%) !important;
        }

        .dark .ayat-container.active {
            border-color: #34d399 !important;
            box-shadow: 0 0 30px rgba(52, 211, 153, 0.5) !important;
            background: linear-gradient(135deg, #064e3b 0%, #1f2937 100%) !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let isPlayingAll = false;
        let currentIndex = 0;
        let activeWordElements = new Map();
        let rafId = null;

        function getAllAudios() {
            return document.querySelectorAll('audio.hidden');
        }

        function toggleAyat(ayatId) {
            const audio = document.getElementById('audio-' + ayatId);
            if (!audio) return;

            if (audio.paused) {
                getAllAudios().forEach(a => {
                    if (a !== audio) {
                        a.pause();
                        resetButton(a.getAttribute('data-ayat-id'));
                    }
                });

                audio.play();
                updateButton(ayatId, true);
                highlightAyat(ayatId);
                startSmoothHighlight(audio, ayatId);
            } else {
                audio.pause();
                updateButton(ayatId, false);
                stopSmoothHighlight();
            }
        }

        function updateButton(ayatId, isPlaying) {
            const iconPlay = document.getElementById('icon-play-' + ayatId);
            const iconPause = document.getElementById('icon-pause-' + ayatId);
            const textPlay = document.getElementById('text-play-' + ayatId);
            if (iconPlay && iconPause && textPlay) {
                iconPlay.classList.toggle('hidden', isPlaying);
                iconPause.classList.toggle('hidden', !isPlaying);
                textPlay.textContent = isPlaying ? 'Jeda' : 'Putar';
            }
        }

        function resetButton(ayatId) {
            updateButton(ayatId, false);
        }

        function highlightAyat(ayatId) {
            document.querySelectorAll('.ayat-container').forEach(el => el.classList.remove('active'));
            const activeContainer = document.getElementById('ayat-container-' + ayatId);
            if (activeContainer) {
                activeContainer.classList.add('active');
                activeContainer.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }

        function startSmoothHighlight(audio, ayatId) {
            stopSmoothHighlight();

            const textContainer = document.getElementById('ayat-text-' + ayatId);
            if (!textContainer) return;

            const words = textContainer.querySelectorAll('.quran-word');
            const totalWords = words.length;
            if (totalWords === 0) return;

            words.forEach(w => w.classList.remove('active-word', 'read-word'));
            activeWordElements.set(ayatId, {
                words,
                totalWords
            });

            const updateHighlight = () => {
                if (audio.paused || audio.ended) return;

                const currentTime = audio.currentTime;
                const duration = audio.duration;
                if (!duration || duration <= 0) return;

                const progress = currentTime / duration;
                let wordIndex = Math.floor(progress * totalWords);

                if (wordIndex >= totalWords) wordIndex = totalWords - 1;
                if (wordIndex < 0) wordIndex = 0;

                words.forEach((w, idx) => {
                    if (idx < wordIndex) {
                        w.classList.add('read-word');
                        w.classList.remove('active-word');
                    } else if (idx === wordIndex) {
                        w.classList.add('active-word');
                        w.classList.remove('read-word');
                    } else {
                        w.classList.remove('active-word', 'read-word');
                    }
                });

                rafId = requestAnimationFrame(updateHighlight);
            };

            rafId = requestAnimationFrame(updateHighlight);
            audio.ontimeupdate = () => {
                if (rafId) return;
                rafId = requestAnimationFrame(updateHighlight);
            };
        }

        function stopSmoothHighlight() {
            if (rafId) {
                cancelAnimationFrame(rafId);
                rafId = null;
            }
            document.querySelectorAll('.quran-word').forEach(w => w.classList.remove('active-word'));
        }

        function playAll() {
            if (isPlayingAll) return;
            isPlayingAll = true;
            currentIndex = 0;
            playAyatByIndex(0);
        }

        function playAyatByIndex(index) {
            const audios = getAllAudios();
            if (index >= audios.length || !isPlayingAll) {
                stopAll();
                return;
            }

            const audio = audios[index];
            const ayatId = audio.getAttribute('data-ayat-id');

            highlightAyat(ayatId);
            updateButton(ayatId, true);

            audio.play().then(() => {
                startSmoothHighlight(audio, ayatId);
            }).catch(err => {
                console.error('Error:', err);
                if (isPlayingAll) setTimeout(() => playAyatByIndex(index + 1), 500);
            });

            audio.onended = function() {
                stopSmoothHighlight();
                updateButton(ayatId, false);
                if (isPlayingAll) setTimeout(() => playAyatByIndex(index + 1), 300);
            };

            audio.onerror = function() {
                stopSmoothHighlight();
                updateButton(ayatId, false);
                if (isPlayingAll) setTimeout(() => playAyatByIndex(index + 1), 500);
            };
        }

        function stopAll() {
            isPlayingAll = false;
            stopSmoothHighlight();
            getAllAudios().forEach(audio => {
                audio.pause();
                audio.currentTime = 0;
                audio.onended = null;
                audio.onerror = null;
                audio.ontimeupdate = null;
                resetButton(audio.getAttribute('data-ayat-id'));
            });
            document.querySelectorAll('.ayat-container').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.quran-word').forEach(w => w.classList.remove('active-word', 'read-word'));
        }

        function downloadAll() {
            const audios = document.querySelectorAll('audio.hidden source');
            audios.forEach((source, index) => {
                setTimeout(() => {
                    const link = document.createElement('a');
                    link.href = source.src;
                    link.download = 'ayat-' + (index + 1) + '.mp3';
                    link.click();
                }, index * 1000);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // ==========================================
            // FITUR BARU: AUTO-SCROLL & HIGHLIGHT DARI LINK LUAR
            // ==========================================
            const hash = window.location.hash; // Contoh: "#ayat-123" atau "#123"
            if (hash) {
                // Bersihkan tanda '#' dan prefix 'ayat-' jika ada
                let targetId = hash.replace('#', '').replace('ayat-', '');

                // Cari elemen container ayat yang sesuai
                const targetElement = document.getElementById('ayat-container-' + targetId);

                if (targetElement) {
                    // Tunggu 300ms agar halaman benar-benar selesai dimuat
                    setTimeout(() => {
                        // 1. Scroll halus ke tengah layar
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });

                        // 2. Tambahkan efek highlight (class .active sudah ada di CSS Anda)
                        targetElement.classList.add('active');

                        // 3. Hilangkan highlight setelah 3 detik agar tidak mengganggu
                        setTimeout(() => {
                            targetElement.classList.remove('active');
                        }, 3000);
                    }, 300);
                }
            }
            // ==========================================

            getAllAudios().forEach(audio => {
                audio.addEventListener('play', function() {
                    const ayatId = this.getAttribute('data-ayat-id');
                    highlightAyat(ayatId);
                    startSmoothHighlight(this, ayatId);
                });

                audio.addEventListener('pause', function() {
                    const ayatId = this.getAttribute('data-ayat-id');
                    updateButton(ayatId, false);
                    stopSmoothHighlight();
                });

                audio.addEventListener('ended', function() {
                    const ayatId = this.getAttribute('data-ayat-id');
                    updateButton(ayatId, false);
                    stopSmoothHighlight();
                });
            });
        });
    </script>
@endpush
