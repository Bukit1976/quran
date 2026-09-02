<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 sm:text-2xl dark:text-gray-100">
                    Surah {{ $surah->nama }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $surah->jumlah_ayat }} Ayat</p>
            </div>
            <div class="font-arabic text-3xl text-emerald-600 sm:text-4xl dark:text-emerald-400">
                {{ $surah->nama_arab }}
            </div>
        </div>
    </x-slot>

    <div class="space-y-4 sm:space-y-6">
        @if ($surah->nomor != 9)
            <div
                class="rounded-xl border border-gray-200 bg-white p-6 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <p class="font-arabic text-2xl text-gray-900 sm:text-3xl dark:text-white">بِسْمِ اللَّهِ الرَّحْمَٰنِ
                    الرَّحِيمِ</p>
            </div>
        @endif

        @foreach ($surah->ayats as $ayat)
            <div
                class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition hover:shadow-md sm:p-6 dark:border-gray-700 dark:bg-gray-800">

                {{-- Header ayat dengan audio player & tombol Mulai Hafal --}}
                <div class="mb-4 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
                    <span
                        class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 sm:text-sm dark:bg-emerald-900 dark:text-emerald-300">
                        Ayat {{ $ayat->nomor_ayat }}
                    </span>

                    <div class="flex w-full items-center gap-2 sm:w-auto">
                        @if ($ayat->audio_url)
                            <audio controls class="h-8 w-full rounded-lg sm:w-48">
                                <source src="{{ $ayat->audio_url }}" type="audio/mpeg">
                                Browser tidak support.
                            </audio>
                        @endif

                        <a href="{{ route('hafalan.mulai', $ayat->id) }}"
                            class="whitespace-nowrap rounded-lg bg-emerald-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-600">
                            Mulai Hafal
                        </a>
                    </div>
                </div>

                {{-- Teks Arab --}}
                <div
                    class="font-arabic mb-4 text-right text-2xl leading-loose text-gray-900 sm:text-3xl lg:text-4xl dark:text-white">
                    {{ $ayat->teks_arab }}
                </div>

                {{-- Transliterasi & Terjemahan --}}
                <div class="space-y-2 border-t border-gray-200 pt-3 dark:border-gray-700">
                    <p class="text-sm italic text-emerald-600 sm:text-base dark:text-emerald-400">
                        {{ $ayat->transliterasi }}
                    </p>
                    <p class="text-sm text-gray-700 sm:text-base dark:text-gray-300">
                        {{ $ayat->terjemahan }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
