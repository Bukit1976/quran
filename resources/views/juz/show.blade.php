@extends('layouts.app')

@section('title', 'Juz ' . $juz)

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100 sm:text-2xl">
                Juz {{ $juz }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ $ayats->count() }} Ayat
            </p>
        </div>
        <a href="{{ route('juz.index') }}"
            class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-medium text-gray-900 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
            ← Kembali
        </a>
    </div>
@endsection

@section('content')
    {{-- Container utama dengan dark mode support --}}
    <div class="min-h-screen bg-gray-50 transition-colors duration-300 dark:bg-gray-900">

        {{-- Tombol Kontrol Audio - DENGAN SPACING KIRI-KANAN --}}
        <div
            class="sticky top-20 z-40 mx-4 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 p-4 shadow-lg dark:from-emerald-700 dark:to-teal-800 sm:mx-6 lg:mx-8">
            <div class="flex items-center justify-between gap-3">
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
            </div>
        </div>

        <div class="space-y-4 px-4 py-6 sm:space-y-6 sm:px-6 lg:px-8">
            @php
                $surahSaatIni = null;
            @endphp

            @foreach ($ayats as $index => $ayat)
                @if ($surahSaatIni !== $ayat->surah->nama)
                    @php $surahSaatIni = $ayat->surah->nama; @endphp
                    <div
                        class="rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 p-4 text-white shadow-lg dark:from-emerald-700 dark:to-teal-800">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold">{{ $ayat->surah->nama }}</h3>
                                <p class="text-sm text-emerald-100">{{ $ayat->surah->nama_arab }}</p>
                            </div>
                            <div class="font-arabic text-3xl">{{ $ayat->surah->nama_arab }}</div>
                        </div>
                    </div>
                @endif

                <div id="ayat-container-{{ $ayat->id }}"
                    class="ayat-container rounded-xl border-2 border-gray-200 bg-white p-4 shadow-sm transition-all duration-500 dark:border-gray-700 dark:bg-gray-800 sm:p-6">

                    <div class="mb-4 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
                        <span
                            class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300 sm:text-sm">
                            Ayat {{ $ayat->nomor_ayat }} - {{ $ayat->surah->nama }}
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
                                    <source src="{{ $ayat->audio_url }}" type="audio/mpeg">
                                </audio>
                            @endif
                            <a href="{{ route('hafalan.mulai', $ayat->id) }}"
                                class="flex-shrink-0 whitespace-nowrap rounded-lg bg-emerald-500 px-3 py-2 text-xs font-medium text-white transition hover:bg-emerald-600 sm:text-sm">
                                Mulai Hafal
                            </a>
                        </div>
                    </div>

                    <div class="font-arabic quran-text mb-4 text-right text-2xl text-gray-900 dark:text-white sm:text-3xl lg:text-4xl"
                        id="ayat-text-{{ $ayat->id }}" dir="rtl" style="line-height: 2.8;">
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
                            <a href="{{ $ayat->audio_url }}" download
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
                <a href="{{ route('juz.index') }}"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    ← Kembali ke Daftar Juz
                </a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .quran-text {
            line-height: 2.4 !important;
            word-spacing: 0 !important;
            letter-spacing: 0 !important;
            text-align: right !important;
            text-align-last: right !important;
            text-justify: none !important;
            white-space: normal !important;
        }

        .quran-word {
            display: inline !important;
            margin: 0 1px !important;
            padding: 0 !important;
            transition: all 0.3s ease !important;
            background: transparent !important;
            color: inherit !important;
        }

        .quran-word.active-word {
            color: #fbbf24 !important;
            background: transparent !important;
            text-shadow:
                0 0 8px rgba(251, 191, 36, 0.8),
                0 0 16px rgba(251, 191, 36, 0.6),
                0 0 24px rgba(251, 191, 36, 0.4) !important;
            transform: scale(1.05) !important;
            font-weight: 700 !important;
            animation: fluidPulse 2s ease-in-out infinite !important;
        }

        @keyframes fluidPulse {

            0%,
            100% {
                text-shadow: 0 0 8px rgba(251, 191, 36, 0.8), 0 0 16px rgba(251, 191, 36, 0.6);
                transform: scale(1.05);
            }

            50% {
                text-shadow: 0 0 12px rgba(251, 191, 36, 1), 0 0 24px rgba(251, 191, 36, 0.8);
                transform: scale(1.08);
            }
        }

        .quran-word.read-word {
            opacity: 0.5;
            transition: opacity 0.6s ease;
        }

        .ayat-container.active {
            border-color: #10b981 !important;
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.5) !important;
            background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%) !important;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
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
                startFluidHighlight(audio, ayatId);
            } else {
                audio.pause();
                updateButton(ayatId, false);
                stopFluidHighlight();
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

        function startFluidHighlight(audio, ayatId) {
            stopFluidHighlight();
            const textContainer = document.getElementById('ayat-text-' + ayatId);
            if (!textContainer) return;

            const words = textContainer.querySelectorAll('.quran-word');
            const totalWords = words.length;
            if (totalWords === 0) return;

            words.forEach(w => w.classList.remove('active-word', 'read-word'));

            let lastWordIndex = -1;

            const updateHighlight = () => {
                if (audio.paused || audio.ended) return;

                const currentTime = audio.currentTime;
                const duration = audio.duration;
                if (!duration || duration <= 0) {
                    rafId = requestAnimationFrame(updateHighlight);
                    return;
                }

                const progress = currentTime / duration;
                const floatIndex = progress * (totalWords - 1);
                const currentWordIndex = Math.floor(floatIndex);

                if (currentWordIndex !== lastWordIndex) {
                    if (lastWordIndex >= 0 && lastWordIndex < totalWords) {
                        words[lastWordIndex].classList.remove('active-word');
                        words[lastWordIndex].classList.add('read-word');
                    }

                    if (currentWordIndex >= 0 && currentWordIndex < totalWords) {
                        words[currentWordIndex].classList.add('active-word');
                        words[currentWordIndex].classList.remove('read-word');
                    }

                    lastWordIndex = currentWordIndex;
                }

                rafId = requestAnimationFrame(updateHighlight);
            };

            rafId = requestAnimationFrame(updateHighlight);
        }

        function stopFluidHighlight() {
            if (rafId) {
                cancelAnimationFrame(rafId);
                rafId = null;
            }
            document.querySelectorAll('.quran-word').forEach(w => {
                w.classList.remove('active-word', 'read-word');
            });
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
                startFluidHighlight(audio, ayatId);
            }).catch(err => {
                console.error('Error:', err);
                if (isPlayingAll) setTimeout(() => playAyatByIndex(index + 1), 500);
            });

            audio.onended = function() {
                stopFluidHighlight();
                updateButton(ayatId, false);
                if (isPlayingAll) setTimeout(() => playAyatByIndex(index + 1), 300);
            };

            audio.onerror = function() {
                stopFluidHighlight();
                updateButton(ayatId, false);
                if (isPlayingAll) setTimeout(() => playAyatByIndex(index + 1), 500);
            };
        }

        function stopAll() {
            isPlayingAll = false;
            stopFluidHighlight();
            getAllAudios().forEach(audio => {
                audio.pause();
                audio.currentTime = 0;
                audio.onended = null;
                audio.onerror = null;
                resetButton(audio.getAttribute('data-ayat-id'));
            });
            document.querySelectorAll('.ayat-container').forEach(el => el.classList.remove('active'));
        }

        document.addEventListener('DOMContentLoaded', function() {
            getAllAudios().forEach(audio => {
                audio.addEventListener('play', function() {
                    const ayatId = this.getAttribute('data-ayat-id');
                    highlightAyat(ayatId);
                    startFluidHighlight(this, ayatId);
                });

                audio.addEventListener('pause', function() {
                    const ayatId = this.getAttribute('data-ayat-id');
                    updateButton(ayatId, false);
                    stopFluidHighlight();
                });

                audio.addEventListener('ended', function() {
                    const ayatId = this.getAttribute('data-ayat-id');
                    updateButton(ayatId, false);
                    stopFluidHighlight();
                });
            });
        });
    </script>
@endpush
