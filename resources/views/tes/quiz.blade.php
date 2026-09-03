@extends('layouts.app')

@section('title', 'Sedang Mengerjakan Tes')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Sedang Mengerjakan Tes</h2>
@endsection

@section('content')
    <div class="mx-auto max-w-3xl" x-data="quizApp()">
        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="mb-1 flex justify-between text-sm text-gray-600 dark:text-gray-400">
                <span>Soal <span x-text="currentSoal + 1"></span> dari <span x-text="soal.length"></span></span>
                <span>Skor: <span x-text="skor"></span></span>
            </div>
            <div class="h-2.5 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                <div class="h-2.5 rounded-full bg-emerald-500 transition-all duration-300"
                    :style="`width: ${((currentSoal) / soal.length) * 100}%`"></div>
            </div>
        </div>

        <!-- Area Soal -->
        <template x-if="!selesai">
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">

                <!-- Tipe: Lanjutkan Ayat & Tebak Arti -->
                <template x-if="jenis !== 'susun_kata'">
                    <div>
                        <div class="font-arabic mb-6 text-right text-3xl leading-loose text-gray-900 dark:text-white"
                            x-text="soal[currentSoal].ayat.teks_arab.substring(0, 50) + '...'"></div>

                        <div class="space-y-3">
                            <template x-for="(pilihan, index) in soal[currentSoal].pilihan" :key="index">
                                <button @click="jawab(pilihan)"
                                    :class="{
                                        'bg-emerald-500 text-white': jawaban === pilihan &&
                                            benar,
                                        'bg-red-500 text-white': jawaban === pilihan && !
                                            benar,
                                        'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600': jawaban !==
                                            pilihan
                                    }"
                                    class="w-full rounded-lg p-4 text-left font-medium transition">
                                    <span x-text="pilihan"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Tipe: Susun Kata -->
                <template x-if="jenis === 'susun_kata'">
                    <div>
                        <p class="mb-4 text-center text-gray-600 dark:text-gray-400">Klik kata di bawah ini untuk
                            menyusun ayat:</p>

                        <!-- Jawaban User -->
                        <div
                            class="font-arabic mb-6 flex min-h-[80px] flex-wrap justify-center gap-2 rounded-lg bg-gray-50 p-4 text-2xl text-gray-900 dark:bg-gray-900 dark:text-white">
                            <template x-for="(kata, index) in jawabanSusun" :key="index">
                                <button @click="hapusKata(index)"
                                    class="rounded-lg bg-emerald-100 px-3 py-1 text-emerald-800 transition hover:bg-red-100 hover:text-red-800 dark:bg-emerald-900 dark:text-emerald-200"
                                    x-text="kata"></button>
                            </template>
                        </div>

                        <!-- Pilihan Kata Acak -->
                        <div class="font-arabic flex flex-wrap justify-center gap-2 text-2xl">
                            <template x-for="(kata, index) in soal[currentSoal].kata_acak" :key="index">
                                <button @click="tambahKata(kata)"
                                    class="rounded-lg bg-blue-100 px-3 py-1 text-blue-800 transition hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-200"
                                    x-text="kata"></button>
                            </template>
                        </div>

                        <button @click="cekJawabanSusun()"
                            class="mt-6 w-full rounded-lg bg-emerald-500 py-3 font-bold text-white transition hover:bg-emerald-600">Cek
                            Jawaban</button>
                    </div>
                </template>

                <!-- Feedback & Next Button -->
                <template x-if="jawabanDicek">
                    <div class="mt-6 border-t border-gray-200 pt-6 text-center dark:border-gray-700">
                        <p class="mb-4 text-lg font-bold" :class="benar ? 'text-emerald-500' : 'text-red-500'"
                            x-text="benar ? '✅ Benar! Masya Allah' : '❌ Kurang Tepat'"></p>
                        <button @click="soalBerikutnya()"
                            class="rounded-lg bg-blue-500 px-6 py-2 font-medium text-white transition hover:bg-blue-600">Soal
                            Berikutnya →</button>
                    </div>
                </template>
            </div>
        </template>

        <!-- Form Simpan (Hidden) -->
        <template x-if="selesai">
            <form :action="'/tes/simpan'" method="POST" class="text-center">
                @csrf
                <input type="hidden" name="skor" :value="skor">
                <input type="hidden" name="jenis" :value="jenis">
                <input type="hidden" name="ayat_id" :value="soal[0].ayat.id">
                <button type="submit"
                    class="rounded-lg bg-emerald-500 px-8 py-3 text-lg font-bold text-white transition hover:bg-emerald-600">Lihat
                    Hasil Akhir</button>
            </form>
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
                    this.jawabanSusun.push(kata);
                },
                hapusKata(index) {
                    this.jawabanSusun.splice(index, 1);
                },

                cekJawabanSusun() {
                    if (this.jawabanDicek) return;
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
