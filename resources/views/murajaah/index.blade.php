@extends('layouts.app')

@section('title', 'Jadwal Murajaah')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100 sm:text-2xl">
        {{ __('Jadwal Murajaah') }}
    </h2>
@endsection

@section('content')
    <div class="space-y-6">
        @if (
            (!isset($murajaahHariIni) || $murajaahHariIni->isEmpty()) &&
                (!isset($murajaahSelesai) || $murajaahSelesai->isEmpty()))
            <div
                class="rounded-xl border border-gray-200 bg-white p-8 text-center shadow-lg dark:border-gray-700 dark:bg-gray-800 sm:p-12">
                <svg class="mx-auto mb-4 h-20 w-20 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">Tidak Ada Murajaah Hari Ini</h3>
                <p class="mb-6 text-gray-600 dark:text-gray-400">Masya Allah! Lanjutkan hafalan baru Anda atau tunggu jadwal
                    murajaah berikutnya.</p>
                <a href="{{ route('hafalan.index') }}"
                    class="inline-block rounded-lg bg-emerald-500 px-6 py-3 font-medium text-white transition hover:bg-emerald-600">
                    Lihat Hafalan Saya
                </a>
            </div>
        @else
            {{-- MURAJAAH HARI INI (BELUM SELESAI) --}}
            @if (isset($murajaahHariIni) && !$murajaahHariIni->isEmpty())
                <div
                    class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                    <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-4">
                        <h3 class="flex items-center text-lg font-bold text-white">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Murajaah Hari Ini
                        </h3>
                    </div>
                    <div class="space-y-4 p-4 sm:p-6">
                        @foreach ($murajaahHariIni as $surahNama => $murajaahs)
                            <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="bg-gray-50 px-4 py-2 dark:bg-gray-700/50">
                                    <h4 class="font-semibold text-gray-900 dark:text-white">{{ $surahNama }}</h4>
                                </div>
                                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($murajaahs as $murajaah)
                                        <div
                                            class="flex flex-col gap-3 p-4 transition hover:bg-gray-50 dark:hover:bg-gray-700/30 sm:flex-row sm:items-center sm:justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 font-bold text-amber-700 dark:bg-amber-900 dark:text-amber-300">
                                                    {{ $murajaah->ayat->nomor_ayat }}
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900 dark:text-white">
                                                        Ayat {{ $murajaah->ayat->nomor_ayat }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $murajaah->ayat->terjemahan }}
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- TOMBOL AKSI --}}
                                            <div class="flex flex-wrap gap-2">
                                                {{-- Tombol Lihat --}}
                                                <a href="{{ route('quran.show', $murajaah->ayat->surah_id) }}#ayat-{{ $murajaah->ayat_id }}"
                                                    class="inline-flex items-center rounded-lg bg-blue-500 px-3 py-2 text-sm font-medium text-white transition hover:bg-blue-600"
                                                    title="Lihat Ayat">
                                                    <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Lihat
                                                </a>

                                                {{-- Tombol Putar --}}
                                                <button
                                                    onclick="playAudio({{ $murajaah->ayat_id }}, '{{ $murajaah->ayat->audio_url }}')"
                                                    class="inline-flex items-center rounded-lg bg-purple-500 px-3 py-2 text-sm font-medium text-white transition hover:bg-purple-600"
                                                    title="Putar Audio">
                                                    <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Putar
                                                </button>

                                                {{-- Tombol Selesai --}}
                                                <form action="{{ route('murajaah.selesai', $murajaah->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="rounded-lg bg-emerald-500 px-3 py-2 text-sm font-medium text-white transition hover:bg-emerald-600">
                                                        ✓ Selesai
                                                    </button>
                                                </form>

                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('murajaah.hapus', $murajaah->id) }}" method="POST"
                                                    class="inline" onsubmit="return confirm('Hapus jadwal murajaah ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="rounded-lg bg-red-500 px-3 py-2 text-sm font-medium text-white transition hover:bg-red-600"
                                                        title="Hapus">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- MURAJAAH YANG SUDAH SELESAI HARI INI --}}
            @if (isset($murajaahSelesai) && !$murajaahSelesai->isEmpty())
                <div
                    class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                        <h3 class="flex items-center text-lg font-bold text-white">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Selesai Hari Ini
                        </h3>
                    </div>
                    <div class="space-y-4 p-4 sm:p-6">
                        @foreach ($murajaahSelesai as $item)
                            <div class="flex items-center justify-between rounded-lg bg-gray-50 p-4 dark:bg-gray-700/30">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 font-bold text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            {{ $item->ayat->surah->nama }} - Ayat {{ $item->ayat->nomor_ayat }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Selesai pada {{ $item->updated_at->format('H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>

    {{-- AUDIO PLAYER --}}
    <audio id="audioPlayer" preload="none"></audio>

    <script>
        function playAudio(ayatId, audioUrl) {
            const audioPlayer = document.getElementById('audioPlayer');

            if (audioPlayer.src === audioUrl && !audioPlayer.paused) {
                audioPlayer.pause();
                return;
            }

            audioPlayer.src = audioUrl;
            audioPlayer.play();

            // Notifikasi
            const notification = document.createElement('div');
            notification.className = 'fixed bottom-4 right-4 bg-emerald-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            notification.textContent = 'Memutar audio ayat ' + ayatId;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        window.addEventListener('beforeunload', () => {
            const audioPlayer = document.getElementById('audioPlayer');
            audioPlayer.pause();
        });
    </script>
@endsection
