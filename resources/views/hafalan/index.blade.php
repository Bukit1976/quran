@extends('layouts.app')

@section('title', 'Hafalan Saya')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100 sm:text-2xl">
        {{ __('Hafalan Saya') }}
    </h2>
@endsection

@section('content')
    <div class="space-y-6">
        @if (!isset($hafalan) || $hafalan->isEmpty())
            <div
                class="rounded-xl border border-gray-200 bg-white p-8 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-12">
                <h3 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">Belum Ada Hafalan</h3>
                <p class="mb-6 text-gray-600 dark:text-gray-400">Mulai perjalanan menghafal Al-Qur'an Anda sekarang</p>
                <a href="{{ route('quran.index') }}"
                    class="inline-block rounded-lg bg-emerald-500 px-6 py-3 font-medium text-white transition hover:bg-emerald-600">
                    Mulai Menghafal
                </a>
            </div>
        @else
            @foreach ($hafalan as $surahNama => $ayahs)
                <div
                    class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                        <h4 class="text-lg font-semibold text-white">{{ $surahNama }}</h4>
                    </div>
                    <div class="space-y-3 p-4 sm:p-6">
                        @foreach ($ayahs as $hafalanItem)
                            <div
                                class="rounded-lg bg-gray-50 p-3 transition hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700 sm:p-4">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <!-- Informasi Ayat -->
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300">
                                            {{ $hafalanItem->ayat->nomor_ayat }}
                                        </div>
                                        <span class="text-sm text-gray-900 dark:text-white sm:text-base">Ayat
                                            {{ $hafalanItem->ayat->nomor_ayat }}</span>

                                        <!-- Status Badge -->
                                        @if ($hafalanItem->status === 'sudah_hafal')
                                            <span
                                                class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300 sm:text-sm">✓
                                                Hafal</span>
                                        @elseif($hafalanItem->status === 'sedang_dihafal')
                                            <span
                                                class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300 sm:text-sm">Menghafal</span>
                                        @else
                                            <span
                                                class="rounded-full bg-gray-200 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-600 dark:text-gray-300 sm:text-sm">○
                                                Belum</span>
                                        @endif
                                    </div>

                                    <!-- Tombol Aksi -->
                                    <div class="flex flex-wrap gap-1.5 sm:gap-2">
                                        <!-- Tombol Lihat -->
                                        <a href="{{ route('quran.show', $hafalanItem->ayat->surah_id) }}#ayat-{{ $hafalanItem->ayat_id }}"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-500 text-white transition hover:bg-blue-600 sm:h-9 sm:w-9"
                                            title="Lihat Ayat">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        <!-- Tombol Putar -->
                                        <button
                                            onclick="playAudio({{ $hafalanItem->ayat_id }}, '{{ $hafalanItem->ayat->audio_url }}')"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-purple-500 text-white transition hover:bg-purple-600 sm:h-9 sm:w-9"
                                            title="Putar Audio">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>

                                        <!-- Tombol Hafal -->
                                        @if ($hafalanItem->status !== 'sudah_hafal')
                                            <a href="{{ route('hafalan.mulai', $hafalanItem->ayat_id) }}"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-500 text-white transition hover:bg-emerald-600 sm:h-9 sm:w-9"
                                                title="Mulai Menghafal">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </a>
                                        @endif

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('hafalan.destroy', $hafalanItem->id) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus hafalan ayat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-red-500 text-white transition hover:bg-red-600 sm:h-9 sm:w-9"
                                                title="Hapus Hafalan">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Audio Player Hidden -->
    <audio id="audioPlayer" preload="none"></audio>

    <script>
        function playAudio(ayatId, audioUrl) {
            const audioPlayer = document.getElementById('audioPlayer');

            // Jika audio sedang berputar dan ini adalah audio yang sama, pause
            if (audioPlayer.src === audioUrl && !audioPlayer.paused) {
                audioPlayer.pause();
                return;
            }

            // Putar audio baru
            audioPlayer.src = audioUrl;
            audioPlayer.play();

            // Tampilkan notifikasi
            showNotification('Memutar audio ayat ' + ayatId);
        }

        function showNotification(message) {
            // Buat elemen notifikasi
            const notification = document.createElement('div');
            notification.className = 'fixed bottom-4 right-4 bg-emerald-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            notification.textContent = message;

            document.body.appendChild(notification);

            // Hapus setelah 3 detik
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Pause audio saat halaman ditinggalkan
        window.addEventListener('beforeunload', () => {
            const audioPlayer = document.getElementById('audioPlayer');
            audioPlayer.pause();
        });
    </script>
@endsection
