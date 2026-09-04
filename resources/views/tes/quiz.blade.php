@extends('layouts.app')

@section('title', 'Sedang Mengerjakan Tes')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Sedang Mengerjakan Tes</h2>
@endsection

@section('content')
    <div class="mx-auto max-w-4xl" x-data="quizApp()">
        <!-- Progress Bar -->
        <div class="mb-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">
            <div class="mb-3 flex justify-between text-sm font-medium text-gray-600 dark:text-gray-400">
                <span class="flex items-center gap-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Soal <span x-text="currentSoal + 1" class="text-emerald-500"></span> / <span
                        x-text="soal.length"></span>
                </span>
                <span class="flex items-center gap-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Skor: <span x-text="skor" class="font-bold text-emerald-500"></span>
                </span>
            </div>
            <div class="h-3 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 transition-all duration-500 ease-out"
                    :style="`width: ${((currentSoal) / soal.length) * 100}%`"></div>
            </div>
        </div>

        <!-- Area Soal -->
        <template x-if="!selesai">
            <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-xl dark:border-gray-700 dark:bg-gray-800">

                <!-- Tipe: Lanjutkan Ayat & Tebak Arti -->
                <template x-if="jenis !== 'susun_kata'">
                    <div>
                        <div
                            class="mb-8 rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50 p-6 dark:from-gray-700 dark:to-gray-600">
                            <p class="mb-2 text-center text-sm text-gray-600 dark:text-gray-400">Lengkapi ayat berikut:</p>
                            <div class="font-arabic text-right text-3xl leading-loose text-gray-900 dark:text-white"
                                x-text="soal[currentSoal].ayat.teks_arab.substring(0, 50) + '...'"></div>
                        </div>

                        <div class="space-y-3">
                            <template x-for="(pilihan, index) in soal[currentSoal].pilihan" :key="index">
                                <button @click="jawab(pilihan)"
                                    :class="{
                                        'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg scale-105': jawaban ===
                                            pilihan && benar,
                                        'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg': jawaban ===
                                            pilihan && !benar,
                                        'bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600 hover:shadow-md': jawaban !==
                                            pilihan
                                    }"
                                    class="w-full rounded-xl border-2 border-transparent p-5 text-left font-medium transition-all duration-200">
                                    <span x-text="pilihan"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Tipe: Susun Kata -->
                <template x-if="jenis === 'susun_kata'">
                    <div>
                        <div class="mb-6 text-center">
                            <p class="text-lg font-medium text-gray-700 dark:text-gray-300">Susun kata-kata berikut menjadi
                                ayat yang benar:</p>
                        </div>

                        <!-- Jawaban User -->
                        <div
                            class="mb-8 rounded-2xl border-2 border-dashed border-gray-300 bg-gradient-to-br from-gray-50 to-gray-100 p-6 dark:border-gray-600 dark:from-gray-700 dark:to-gray-600">
                            <p class="mb-4 text-center text-sm font-medium text-gray-600 dark:text-gray-400">Jawaban Anda:
                            </p>
                            <div class="font-arabic flex min-h-[100px] flex-wrap items-center justify-center gap-2 text-2xl"
                                :class="jawabanSusun.length === 0 ? 'text-gray-400' : 'text-gray-900 dark:text-white'">
                                <template x-if="jawabanSusun.length === 0">
                                    <span class="text-gray-400">Klik kata untuk menyusun...</span>
                                </template>
                                <template x-for="(kata, index) in jawabanSusun" :key="index">
                                    <button @click="hapusKata(index)"
                                        class="group relative overflow-hidden rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 px-4 py-2 font-semibold text-white shadow-lg transition-all duration-200 hover:scale-110 hover:from-red-500 hover:to-pink-500 hover:shadow-xl"
                                        x-text="kata">
                                        <span
                                            class="absolute right-1 top-1/2 hidden -translate-y-1/2 text-xs opacity-0 transition-opacity group-hover:opacity-100">×</span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <!-- Pilihan Kata Acak -->
                        <div
                            class="rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 p-6 dark:from-gray-700 dark:to-gray-600">
                            <p class="mb-4 text-center text-sm font-medium text-gray-600 dark:text-gray-400">Pilihan Kata:
                            </p>
                            <div class="font-arabic flex flex-wrap justify-center gap-2 text-xl">
                                <template x-for="(kata, index) in soal[currentSoal].kata_acak" :key="index">
                                    <button @click="tambahKata(kata)"
                                        :class="{
                                            'opacity-30 cursor-not-allowed': jawabanSusun.includes(kata)
                                        }"
                                        class="rounded-xl bg-gradient-to-r from-blue-500 to-indigo-500 px-4 py-2 font-semibold text-white shadow-md transition-all duration-200 hover:scale-110 hover:shadow-lg active:scale-95 disabled:cursor-not-allowed"
                                        x-text="kata" :disabled="jawabanSusun.includes(kata)"></button>
                                </template>
                            </div>
                        </div>

                        <button @click="cekJawabanSusun()" :disabled="jawabanSusun.length === 0 || jawabanDicek"
                            class="mt-8 w-full rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 py-4 font-bold text-white shadow-lg transition-all duration-200 hover:from-emerald-600 hover:to-teal-600 hover:shadow-xl disabled:cursor-not-allowed disabled:opacity-50">
                            <span x-show="!jawabanDicek">✓ Cek Jawaban</span>
                            <span x-show="jawabanDicek">Sudah Dicek</span>
                        </button>
                    </div>
                </template>

                <!-- Feedback & Next Button -->
                <template x-if="jawabanDicek">
                    <div
                        class="mt-8 rounded-xl border-2 border-gray-200 bg-gray-50 p-6 text-center dark:border-gray-700 dark:bg-gray-700">
                        <div class="mb-4 flex items-center justify-center gap-3">
                            <svg x-show="benar" class="h-12 w-12 text-emerald-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <svg x-show="!benar" class="h-12 w-12 text-red-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-xl font-bold" :class="benar ? 'text-emerald-500' : 'text-red-500'"
                                    x-text="benar ? 'Masya Allah! Benar!' : 'Belum Tepat'"></p>
                                <p class="text-sm text-gray-600 dark:text-gray-400"
                                    x-text="benar ? 'Jawaban Anda sempurna' : 'Coba lagi di soal berikutnya'"></p>
                            </div>
                        </div>
                        <button @click="soalBerikutnya()"
                            class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-500 px-8 py-3 font-medium text-white shadow-lg transition-all duration-200 hover:from-blue-600 hover:to-indigo-600 hover:shadow-xl">
                            <span>Soal Berikutnya</span>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        </template>

        <!-- Form Simpan (Hidden) -->
        <template x-if="selesai">
            <div
                class="rounded-2xl border border-gray-200 bg-white p-8 text-center shadow-xl dark:border-gray-700 dark:bg-gray-800">
                <div class="mb-6">
                    <svg class="mx-auto h-20 w-20 text-emerald-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">Tes Selesai!</h3>
                    <p class="text-gray-600 dark:text-gray-400">Total Skor Anda: <span x-text="skor"
                            class="font-bold text-emerald-500"></span></p>
                </div>
                <form :action="'/tes/simpan'" method="POST">
                    @csrf
                    <input type="hidden" name="skor" :value="skor">
                    <input type="hidden" name="jenis" :value="jenis">
                    <input type="hidden" name="ayat_id" :value="soal[0].ayat.id">
                    <button type="submit"
                        class="w-full rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 py-4 text-lg font-bold text-white shadow-lg transition-all duration-200 hover:from-emerald-600 hover:to-teal-600 hover:shadow-xl">
                        Lihat Hasil Akhir
                    </button>
                </form>
            </div>
        </template>
    </div>
@endsection

@push('scripts')
    <script>
        function quizApp() {
            return {
                soal: @json($dataSoal),
                jenis: @json($jenis),
                currentSoal: 0,
                skor: 0,
                jawaban: null,
                jawabanSusun: [],
                jawabanDicek: false,
                benar: false,
                selesai: false,

                jawab(pilihan) {
                    if (this.jawabanDicek) return;
                    this.jawaban = pilihan;
                    this.jawabanDicek = true;

                    let benarText = this.soal[this.currentSoal].jawaban_benar;
                    if (Array.isArray(benarText)) benarText = benarText.join(' ');

                    this.benar = (pilihan === benarText);
                    if (this.benar) this.skor += 20;
                },

                tambahKata(kata) {
                    if (!this.jawabanSusun.includes(kata)) {
                        this.jawabanSusun.push(kata);
                    }
                },
                hapusKata(index) {
                    this.jawabanSusun.splice(index, 1);
                },

                cekJawabanSusun() {
                    if (this.jawabanDicek || this.jawabanSusun.length === 0) return;
                    this.jawabanDicek = true;
                    let benarArr = this.soal[this.currentSoal].jawaban_benar;
                    this.benar = JSON.stringify(this.jawabanSusun) === JSON.stringify(benarArr);
                    if (this.benar) this.skor += 20;
                },

                soalBerikutnya() {
                    this.currentSoal++;
                    this.jawaban = null;
                    this.jawabanSusun = [];
                    this.jawabanDicek = false;
                    this.benar = false;

                    if (this.currentSoal >= this.soal.length) {
                        this.selesai = true;
                    }
                }
            }
        }
    </script>
@endpush
