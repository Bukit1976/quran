@extends('layouts.app')

@section('title', "Mode {$mode} - Latihan Hafalan")

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100 sm:text-2xl">
                Mode {{ $mode }} - Latihan Hafalan
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ $ayat->surah->nama }} - Ayat {{ $ayat->nomor_ayat }}
            </p>
        </div>
        <a href="{{ route('latihan.index', $ayat->id) }}"
            class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-medium text-gray-900 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
            ← Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">
        <!-- Info Mode -->
        <div class="rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 p-6 text-white shadow-lg">
            <h3 class="mb-2 text-xl font-bold">
                @if ($mode == 1)
                    Mode 1: Lihat Lengkap
                @elseif($mode == 2)
                    Mode 2: Sembunyikan 30% Kata
                @elseif($mode == 3)
                    Mode 3: Sembunyikan 60% Kata
                @elseif($mode == 4)
                    Mode 4: Tes Total (Semua Disembunyikan)
                @endif
            </h3>
            <p class="text-sm text-emerald-100">
                @if ($mode == 1)
                    Baca dan hafalkan ayat secara utuh
                @elseif($mode == 2)
                    Coba ingat kata-kata yang disembunyikan
                @elseif($mode == 3)
                    Lebih menantang! Coba ingat lebih banyak kata
                @elseif($mode == 4)
                    Tes hafalan total, coba baca dari ingatan
                @endif
            </p>
        </div>

        <!-- Ayat dengan Kata Tersembunyi -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800 sm:p-8">
            <div
                class="font-arabic text-right text-2xl leading-loose text-gray-900 dark:text-white sm:text-3xl lg:text-4xl">
                @foreach ($kataKata as $index => $kata)
                    @if (in_array($index, $kataTersembunyi))
                        <span
                            class="mx-1 my-1 inline-block min-w-[60px] rounded bg-gray-200 px-2 text-center text-gray-400 dark:bg-gray-700 dark:text-gray-500">
                            ______
                        </span>
                    @else
                        <span class="mx-1 my-1 inline-block">{{ $kata }}</span>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <button onclick="tampilkanSemua()"
                class="rounded-lg bg-emerald-500 px-6 py-3 font-medium text-white transition hover:bg-emerald-600">
                👁️ Tampilkan Semua Kata
            </button>
            <a href="{{ route('latihan.index', $ayat->id) }}"
                class="rounded-lg bg-gray-200 px-6 py-3 text-center font-medium text-gray-900 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                🔄 Coba Mode Lain
            </a>
        </div>

        <!-- Terjemahan (Hidden by default) -->
        <div id="terjemahanBox"
            class="hidden rounded-xl border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">
            <h4 class="mb-2 font-semibold text-gray-900 dark:text-white">Terjemahan:</h4>
            <p class="text-gray-700 dark:text-gray-300">{{ $ayat->terjemahan }}</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function tampilkanSemua() {
            const spans = document.querySelectorAll('.font-arabic span');
            spans.forEach(span => {
                if (span.textContent.trim() === '______') {
                    span.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-400', 'dark:text-gray-500');
                    span.classList.add('text-emerald-600', 'dark:text-emerald-400');
                }
            });
            document.getElementById('terjemahanBox').classList.remove('hidden');
        }
    </script>
@endpush
