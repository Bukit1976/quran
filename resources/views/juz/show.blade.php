<x-app-layout>
    <x-slot name="header">
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
    </x-slot>

    <div class="space-y-4 sm:space-y-6">
        @php
            $surahSaatIni = null;
        @endphp

        @foreach ($ayats as $ayat)
            {{-- Tampilkan Header Surah jika berganti surah --}}
            @if ($surahSaatIni !== $ayat->surah->nama)
                @php $surahSaatIni = $ayat->surah->nama; @endphp

                <div class="rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 p-4 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold">{{ $ayat->surah->nama }}</h3>
                            <p class="text-sm text-emerald-100">{{ $ayat->surah->nama_arab }}</p>
                        </div>
                        <div class="font-arabic text-3xl">
                            {{ $ayat->surah->nama_arab }}
                        </div>
                    </div>
                </div>
            @endif

            {{-- Tampilkan Ayat --}}
            <div
                class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition hover:shadow-md dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                <div class="mb-4 flex items-start justify-between">
                    <span
                        class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300 sm:text-sm">
                        Ayat {{ $ayat->nomor_ayat }}
                    </span>
                    <div class="flex gap-2">
                        @if ($ayat->audio_url)
                            <audio controls class="h-8 w-32 sm:w-48">
                                <source src="{{ $ayat->audio_url }}" type="audio/mpeg">
                            </audio>
                        @endif
                        <a href="{{ route('hafalan.mulai', $ayat->id) }}"
                            class="rounded-lg bg-emerald-500 px-3 py-2 text-xs font-medium text-white transition hover:bg-emerald-600 sm:text-sm">
                            Hafal
                        </a>
                    </div>
                </div>

                <div
                    class="font-arabic mb-4 text-right text-2xl leading-loose text-gray-900 dark:text-white sm:text-3xl lg:text-4xl">
                    {{ $ayat->teks_arab }}
                </div>

                <div class="space-y-2 border-t border-gray-200 pt-3 dark:border-gray-700">
                    <p class="text-sm italic text-emerald-600 dark:text-emerald-400 sm:text-base">
                        {{ $ayat->transliterasi }}
                    </p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 sm:text-base">
                        {{ $ayat->terjemahan }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
