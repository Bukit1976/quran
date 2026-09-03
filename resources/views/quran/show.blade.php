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
    <div class="space-y-4 sm:space-y-6">
        {{-- Bismillah --}}
        @if ($surah->nomor != 9)
            <div
                class="rounded-xl border border-gray-200 bg-white p-6 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <p class="font-arabic text-2xl leading-loose text-gray-900 dark:text-white sm:text-3xl">
                    بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ
                </p>
            </div>
        @endif

        {{-- Tombol Kontrol Audio --}}
        <div class="sticky top-20 z-40 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 p-4 shadow-lg">
            <div class="flex flex-wrap items-center justify-center gap-3">
                <button onclick="playAll()"
                    class="flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-bold text-emerald-600 transition hover:bg-emerald-50">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    </svg>
                    Putar Semua
                </button>
                <button onclick="stopAll()"
                    class="flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-bold text-red-600 transition hover:bg-red-50">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                    </svg>
                    Stop
                </button>
                <button onclick="downloadAll()"
                    class="flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-bold text-blue-600 transition hover:bg-blue-50">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download Semua
                </button>
            </div>
        </div>

        {{-- Daftar Ayat --}}
        @foreach ($surah->ayats as $index => $ayat)
            <div id="ayat-container-{{ $ayat->id }}"
                class="ayat-container rounded-xl border-2 border-gray-200 bg-white p-4 shadow-sm transition-all duration-500 dark:border-gray-700 dark:bg-gray-800 sm:p-6">

                {{-- Header --}}
                <div class="mb-4 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
                    <span
                        class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300 sm:text-sm">
                        Ayat {{ $ayat->nomor_ayat }}
                    </span>
                    <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
                        @if ($ayat->audio_url)
                            <audio id="audio-{{ $ayat->id }}" class="audio-player h-10 w-full rounded-lg sm:w-64"
                                data-ayat-id="{{ $ayat->id }}" data-index="{{ $index }}" controls>
                                <source src="{{ $ayat->audio_url }}" type="audio/mpeg">
                            </audio>
                        @endif
                        <a href="{{ route('hafalan.mulai', $ayat->id) }}"
                            class="whitespace-nowrap rounded-lg bg-emerald-500 px-4 py-2 text-center text-sm font-medium text-white transition hover:bg-emerald-600">
                            Mulai Hafal
                        </a>
                    </div>
                </div>

                {{-- Teks Arab UTUH dengan Word Highlight --}}
                <div class="font-arabic mb-4 text-right text-2xl leading-[2.2] text-gray-900 dark:text-white sm:text-3xl lg:text-4xl"
                    id="ayat-text-{{ $ayat->id }}" dir="rtl">
                    @php
                        // Pecah per kata (space), tapi JANGAN pecah per huruf
                        $words = preg_split('/\s+/', trim($ayat->teks_arab));
                    @endphp
                    @foreach ($words as $wIdx => $word)
                        <span class="quran-word" data-word-index="{{ $wIdx }}">{{ $word }}</span>
                    @endforeach
                </div>

                {{-- Transliterasi --}}
                @if ($ayat->transliterasi && trim($ayat->transliterasi) != '')
                    <div class="mb-3 rounded-lg bg-emerald-50 p-3 dark:bg-emerald-900/20">
                        <p class="text-sm italic text-emerald-700 dark:text-emerald-300 sm:text-base">
                            {{ $ayat->transliterasi }}
                        </p>
                    </div>
                @endif

                {{-- Terjemahan --}}
                <div class="border-t border-gray-200 pt-3 dark:border-gray-700">
                    <p class="text-sm text-gray-700 dark:text-gray-300 sm:text-base">
                        {{ $ayat->terjemahan }}
                    </p>
                </div>

                {{-- Download --}}
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
            <a href="{{ route('quran.index') }}"
                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                ← Kembali ke Daftar Surah
            </a>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Highlight container ayat aktif */
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

        /* Setiap kata dalam ayat - TIDAK dipecah per huruf */
        .quran-word {
            display: inline-block;
            margin: 0 2px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 4px;
            padding: 0 2px;
        }

        /* Kata yang sedang dibaca - WARNA EMAS dengan glow */
        .quran-word.active-word {
            color: #f59e0b !important;
            text-shadow:
                0 0 10px rgba(245, 158, 11, 0.6),
                0 0 20px rgba(245, 158, 11, 0.3);
            transform: scale(1.08);
            font-weight: 700;
        }

        /* Kata yang sudah dibaca - sedikit pudar */
        .quran-word.read-word {
            opacity: 0.7;
        }

        /* Warna Tajwid */
        .tajwid-ghunnah {
            color: #ef4444;
            font-weight: bold;
        }

        .tajwid-mad {
            color: #3b82f6;
        }

        .tajwid-qalqalah {
            color: #8b5cf6;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let isPlayingAll = false;
        let currentIndex = 0;
        const totalAyats = {{ $surah->ayats->count() }};
        let wordHighlightInterval = null;
        let lastActiveWord = null;

        // Highlight container ayat
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

        // Highlight per KATA dengan smooth transition
        function startWordHighlight(audio, ayatId) {
            stopWordHighlight();

            const textContainer = document.getElementById('ayat-text-' + ayatId);
            if (!textContainer) return;

            const words = textContainer.querySelectorAll('.quran-word');
            const totalWords = words.length;
            if (totalWords === 0) return;

            // Reset semua kata
            words.forEach(w => {
                w.classList.remove('active-word', 'read-word');
            });

            const duration = audio.duration || 10;
            const timePerWord = duration / totalWords;

            // Update setiap 100ms untuk smooth
            wordHighlightInterval = setInterval(() => {
                const currentTime = audio.currentTime;
                const wordIndex = Math.floor(currentTime / timePerWord);

                if (wordIndex >= totalWords) {
                    // Semua kata sudah dibaca
                    words.forEach(w => w.classList.add('read-word'));
                    if (lastActiveWord) lastActiveWord.classList.remove('active-word');
                    return;
                }

                // Hapus highlight dari kata sebelumnya
                if (lastActiveWord && lastActiveWord !== words[wordIndex]) {
                    lastActiveWord.classList.remove('active-word');
                    lastActiveWord.classList.add('read-word');
                }

                // Tambah highlight ke kata sekarang
                if (words[wordIndex]) {
                    words[wordIndex].classList.add('active-word');
                    lastActiveWord = words[wordIndex];
                }
            }, 100);
        }

        function stopWordHighlight() {
            if (wordHighlightInterval) {
                clearInterval(wordHighlightInterval);
                wordHighlightInterval = null;
            }
            if (lastActiveWord) {
                lastActiveWord.classList.remove('active-word');
                lastActiveWord = null;
            }
        }

        function playAll() {
            if (isPlayingAll) return;
            isPlayingAll = true;
            currentIndex = 0;
            playAyatByIndex(0);
        }

        function playAyatByIndex(index) {
            if (index >= totalAyats || !isPlayingAll) {
                stopAll();
                return;
            }

            const audios = document.querySelectorAll('.audio-player');
            if (index < audios.length) {
                const audio = audios[index];
                const ayatId = audio.getAttribute('data-ayat-id');

                highlightAyat(ayatId);

                audio.play().then(() => {
                    if (audio.duration) {
                        startWordHighlight(audio, ayatId);
                    } else {
                        audio.addEventListener('loadedmetadata', () => {
                            startWordHighlight(audio, ayatId);
                        });
                    }
                }).catch(err => {
                    console.error('Error:', err);
                    if (isPlayingAll) setTimeout(() => playAyatByIndex(index + 1), 500);
                });

                audio.onended = function() {
                    stopWordHighlight();
                    if (isPlayingAll) setTimeout(() => playAyatByIndex(index + 1), 300);
                };

                audio.onerror = function() {
                    stopWordHighlight();
                    if (isPlayingAll) setTimeout(() => playAyatByIndex(index + 1), 500);
                };
            } else {
                stopAll();
            }
        }

        function stopAll() {
            isPlayingAll = false;
            stopWordHighlight();
            document.querySelectorAll('.audio-player').forEach(audio => {
                audio.pause();
                audio.currentTime = 0;
                audio.onended = null;
                audio.onerror = null;
            });
            document.querySelectorAll('.ayat-container').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.quran-word').forEach(w => {
                w.classList.remove('active-word', 'read-word');
            });
        }

        function downloadAll() {
            const audios = document.querySelectorAll('.audio-player source');
            audios.forEach((source, index) => {
                setTimeout(() => {
                    const link = document.createElement('a');
                    link.href = source.src;
                    link.download = 'ayat-' + (index + 1) + '.mp3';
                    link.click();
                }, index * 1000);
            });
        }

        // Handle individual play
        document.querySelectorAll('.audio-player').forEach(audio => {
            audio.addEventListener('play', function() {
                const ayatId = this.getAttribute('data-ayat-id');
                highlightAyat(ayatId);
                startWordHighlight(this, ayatId);

                document.querySelectorAll('.audio-player').forEach(a => {
                    if (a !== this) a.pause();
                });
            });

            audio.addEventListener('pause', function() {
                // Biarkan highlight tetap di posisi terakhir
            });
        });
    </script>
@endpush
