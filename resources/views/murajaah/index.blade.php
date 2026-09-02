<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100 sm:text-2xl">
            {{ __('Jadwal Murajaah') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        @if ($murajaahHariIni->isEmpty() && $murajaahSelesai->isEmpty())
            <div
                class="rounded-xl border border-gray-200 bg-white p-8 text-center shadow-lg dark:border-gray-700 dark:bg-gray-800 sm:p-12">
                <svg class="mx-auto mb-4 h-20 w-20 text-emerald-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">Tidak Ada Murajaah Hari Ini</h3>
                <p class="text-gray-600 dark:text-gray-400">Masya Allah! Lanjutkan hafalan baru Anda.</p>
                <a href="{{ route('quran.index') }}"
                    class="mt-6 inline-block rounded-lg bg-emerald-500 px-6 py-3 font-medium text-white transition hover:bg-emerald-600">
                    Mulai Hafalan Baru
                </a>
            </div>
        @else
            <!-- Murajaah Belum Selesai -->
            @if (!$murajaahHariIni->isEmpty())
                <div
                    class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                    <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-4">
                        <h3 class="flex items-center text-lg font-bold text-white">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Murajaah Hari Ini ({{ $murajaahHariIni->sum(fn($g) => $g->count()) }} ayat)
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
                                            class="flex items-center justify-between p-4 transition hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 font-bold text-amber-700 dark:bg-amber-900 dark:text-amber-300">
                                                    {{ $murajaah->ayat->nomor_ayat }}
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900 dark:text-white">Ayat
                                                        {{ $murajaah->ayat->nomor_ayat }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $murajaah->ayat->terjemahan }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex gap-2">
                                                <a href="{{ route('latihan.index', $murajaah->ayat_id) }}"
                                                    class="rounded-lg bg-emerald-500 px-3 py-2 text-sm font-medium text-white transition hover:bg-emerald-600">
                                                    Latih
                                                </a>
                                                <form action="{{ route('murajaah.selesai', $murajaah->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="rounded-lg bg-blue-500 px-3 py-2 text-sm font-medium text-white transition hover:bg-blue-600">
                                                        ✓ Selesai
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

            <!-- Murajaah Selesai -->
            @if (!$murajaahSelesai->isEmpty())
                <div
                    class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                        <h3 class="flex items-center text-lg font-bold text-white">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Sudah Dimurajaah Hari Ini ({{ $murajaahSelesai->count() }})
                        </h3>
                    </div>

                    <div class="p-4 sm:p-6">
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($murajaahSelesai as $murajaah)
                                <div
                                    class="flex items-center justify-between rounded-lg border border-emerald-200 bg-emerald-50 p-3 dark:border-emerald-800 dark:bg-emerald-900/20">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $murajaah->ayat->surah->nama }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">Ayat
                                            {{ $murajaah->ayat->nomor_ayat }}</p>
                                    </div>
                                    <svg class="h-6 w-6 text-emerald-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
