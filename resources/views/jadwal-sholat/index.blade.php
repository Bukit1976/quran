@extends('layouts.app')

@section('title', 'Jadwal Sholat')

@section('header')
    <div class="flex flex-col gap-2">
        <h2 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white">
            Jadwal Sholat Hari Ini
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Jadwal sholat akurat berdasarkan lokasi yang dipilih
        </p>
    </div>
@endsection

@section('content')
    <div x-data="jadwalSholat()" x-init="init()" class="mx-auto max-w-6xl space-y-6 px-4 md:px-0">

        {{-- =========================================================
             PANEL PEMILIHAN LOKASI - 3 LEVEL OTOMATIS
        ========================================================== --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-lg dark:border-gray-700 dark:bg-gray-800">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Lokasi Jadwal Sholat</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Pilih Provinsi, Kota, dan Kecamatan</p>
                    </div>
                </div>

                {{-- Dropdown Area: Responsif penuh untuk HP, rapi untuk Tablet/Desktop --}}
                <div class="flex flex-col gap-3 sm:flex-row w-full md:w-auto">
                    <!-- Provinsi -->
                    <select x-model="selectedProvinsi" @change="onProvinsiChange()"
                        class="w-full md:w-48 rounded-xl border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        <option value="">-- Provinsi --</option>
                        <template x-for="prov in provinsiList" :key="prov.id">
                            <option :value="prov.id" x-text="prov.nama"></option>
                        </template>
                    </select>

                    <!-- Kota/Kabupaten -->
                    <select x-model="selectedKota" @change="onKotaChange()" :disabled="!selectedProvinsi"
                        class="w-full md:w-48 rounded-xl border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 disabled:bg-gray-100 disabled:cursor-not-allowed dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:disabled:bg-gray-800">
                        <option value="">-- Kota --</option>
                        <template x-for="kota in kotaList" :key="kota">
                            <option :value="kota" x-text="kota"></option>
                        </template>
                    </select>

                    <!-- Kecamatan -->
                    <select x-model="selectedKecamatan" @change="onKecamatanChange()" :disabled="!selectedKota"
                        class="w-full md:w-48 rounded-xl border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 disabled:bg-gray-100 disabled:cursor-not-allowed dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:disabled:bg-gray-800">
                        <option value="">-- Kecamatan --</option>
                        <template x-for="kec in kecamatanList" :key="kec">
                            <option :value="kec" x-text="kec"></option>
                        </template>
                    </select>
                </div>
            </div>

            <div
                class="mt-4 flex items-center gap-2 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-300">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Jadwal sholat untuk: <strong x-text="kota || 'Belum dipilih'" class="break-words"></strong></span>
            </div>
        </div>

        {{-- =========================================================
             AUDIO ADZAN
        ========================================================== --}}
        <audio id="audioAdzan" preload="auto" x-ref="audioAdzan"></audio>

        {{-- =========================================================
             PANEL KONTROL ADZAN
        ========================================================== --}}
        <div
            class="rounded-2xl border border-emerald-200 bg-gradient-to-r from-emerald-50 via-teal-50 to-cyan-50 p-5 shadow-lg dark:border-emerald-800 dark:from-emerald-900/30 dark:via-teal-900/30 dark:to-cyan-900/30">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Pilihan Suara Adzan</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Pilihan tersimpan otomatis di browser</p>
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <select x-model="selectedAdzan" @change="gantiAdzan()"
                        class="w-full sm:min-w-[250px] rounded-xl border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        <optgroup label="🕌 Timur Tengah">
                            <option value="masjidil_haram">Masjidil Haram (Mekkah)</option>
                            <option value="mishary_alafasy">Mishary Rashid Alafasy</option>
                            <option value="abdul_basit">Abdul Basit (Mesir)</option>
                            <option value="saudi_1">Adzan Saudi (Madani)</option>
                        </optgroup>
                        <optgroup label="🌏 Asia">
                            <option value="turki_1">Turki (Sultan Ahmed)</option>
                            <option value="malaysia_1">Malaysia</option>
                            <option value="indonesia_1">Indonesia</option>
                            <option value="pakistan_1">Pakistan</option>
                        </optgroup>
                    </select>

                    <div class="flex gap-2">
                        <button @click="toggleAdzan()"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white shadow-lg transition-all hover:scale-105 active:scale-95"
                            :class="isPlaying ? 'bg-gradient-to-r from-red-500 to-pink-500' :
                                'bg-gradient-to-r from-amber-500 to-orange-500'">
                            <span x-text="isPlaying ? 'Stop' : 'Tes Adzan'"></span>
                        </button>
                        <button @click="toggleMute()"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold text-white shadow-lg transition-all hover:scale-105 active:scale-95"
                            :class="isMuted ? 'bg-red-500' : 'bg-gray-500'">
                            <span x-text="isMuted ? 'Unmute' : 'Mute'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- =========================================================
             COUNTDOWN
        ========================================================== --}}
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-700 p-6 md:p-8 text-white shadow-2xl">
            <div class="relative z-10">
                <div class="mb-4 flex items-center gap-2 text-emerald-100">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">Menuju Sholat Berikutnya:</span>
                </div>
                <h3 class="mb-2 text-3xl md:text-4xl font-bold"
                    x-text="translateNama(sholatBerikutnyaNama) || 'Memuat...'"></h3>
                <div class="flex items-baseline gap-2">
                    <span class="font-mono text-4xl md:text-5xl font-bold" x-text="countdown"></span>
                    <span class="text-emerald-200">lagi</span>
                </div>
                <div class="mt-4 flex flex-wrap items-center gap-2 text-sm text-emerald-100">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span x-text="kota" class="break-words"></span>
                </div>
                <div class="mt-2 text-sm text-emerald-100">
                    <span x-text="tanggalHijriah"></span>
                    <span> | </span>
                    <span x-text="tanggalMasehi"></span>
                </div>
            </div>
        </div>

        {{-- =========================================================
             LOADING
        ========================================================== --}}
        <div x-show="loading" class="flex justify-center py-12">
            <div class="h-16 w-16 animate-spin rounded-full border-4 border-emerald-200 border-t-emerald-600"></div>
        </div>

        {{-- =========================================================
             JADWAL SHOLAT
        ========================================================== --}}
        <div x-show="!loading" x-cloak class="grid grid-cols-2 md:grid-cols-3 gap-6 md:gap-8">

            {{-- SUBUH --}}
            <div class="relative p-4 md:p-6 text-center transition-all duration-300 hover:scale-110 group cursor-pointer"
                :class="{ 'scale-110': isNextPrayer('Fajr') }">
                <img src="{{ asset('Logo/Jadwal.png') }}" alt="Subuh"
                    class="h-24 w-24 md:h-32 md:w-32 mx-auto mb-3 object-contain drop-shadow-[0_0_15px_rgba(16,185,129,0.5)] group-hover:drop-shadow-[0_0_25px_rgba(16,185,129,0.8)] transition-all duration-300">
                <p class="mb-2 text-sm md:text-base font-bold tracking-wider text-gray-700 dark:text-gray-200">SUBUH</p>
                <p class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white"
                    x-text="formatWaktu(jadwalSholat.Fajr)"></p>
                <span x-show="isNextPrayer('Fajr')"
                    class="mt-3 inline-block rounded-full bg-emerald-500 px-4 py-1 text-xs font-bold text-white animate-pulse shadow-lg shadow-emerald-500/50">BERIKUTNYA</span>
            </div>

            {{-- TERBIT --}}
            <div class="relative p-4 md:p-6 text-center transition-all duration-300 hover:scale-110 group cursor-pointer">
                <img src="{{ asset('Logo/Jadwal.png') }}" alt="Terbit"
                    class="h-24 w-24 md:h-32 md:w-32 mx-auto mb-3 object-contain drop-shadow-[0_0_15px_rgba(245,158,11,0.5)] group-hover:drop-shadow-[0_0_25px_rgba(245,158,11,0.8)] transition-all duration-300">
                <p class="mb-2 text-sm md:text-base font-bold tracking-wider text-gray-700 dark:text-gray-200">TERBIT</p>
                <p class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white"
                    x-text="formatWaktu(jadwalSholat.Sunrise)"></p>
            </div>

            {{-- DZUHUR --}}
            <div class="relative p-4 md:p-6 text-center transition-all duration-300 hover:scale-110 group cursor-pointer"
                :class="{ 'scale-110': isNextPrayer('Dhuhr') }">
                <img src="{{ asset('Logo/Jadwal.png') }}" alt="Dzuhur"
                    class="h-24 w-24 md:h-32 md:w-32 mx-auto mb-3 object-contain drop-shadow-[0_0_15px_rgba(234,179,8,0.5)] group-hover:drop-shadow-[0_0_25px_rgba(234,179,8,0.8)] transition-all duration-300">
                <p class="mb-2 text-sm md:text-base font-bold tracking-wider text-gray-700 dark:text-gray-200">DZUHUR</p>
                <p class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white"
                    x-text="formatWaktu(jadwalSholat.Dhuhr)"></p>
                <span x-show="isNextPrayer('Dhuhr')"
                    class="mt-3 inline-block rounded-full bg-emerald-500 px-4 py-1 text-xs font-bold text-white animate-pulse shadow-lg shadow-emerald-500/50">BERIKUTNYA</span>
            </div>

            {{-- ASHAR --}}
            <div class="relative p-4 md:p-6 text-center transition-all duration-300 hover:scale-110 group cursor-pointer"
                :class="{ 'scale-110': isNextPrayer('Asr') }">
                <img src="{{ asset('Logo/Jadwal.png') }}" alt="Ashar"
                    class="h-24 w-24 md:h-32 md:w-32 mx-auto mb-3 object-contain drop-shadow-[0_0_15px_rgba(249,115,22,0.5)] group-hover:drop-shadow-[0_0_25px_rgba(249,115,22,0.8)] transition-all duration-300">
                <p class="mb-2 text-sm md:text-base font-bold tracking-wider text-gray-700 dark:text-gray-200">ASHAR</p>
                <p class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white"
                    x-text="formatWaktu(jadwalSholat.Asr)"></p>
                <span x-show="isNextPrayer('Asr')"
                    class="mt-3 inline-block rounded-full bg-emerald-500 px-4 py-1 text-xs font-bold text-white animate-pulse shadow-lg shadow-emerald-500/50">BERIKUTNYA</span>
            </div>

            {{-- MAGHRIB --}}
            <div class="relative p-4 md:p-6 text-center transition-all duration-300 hover:scale-110 group cursor-pointer"
                :class="{ 'scale-110': isNextPrayer('Maghrib') }">
                <img src="{{ asset('Logo/Jadwal.png') }}" alt="Maghrib"
                    class="h-24 w-24 md:h-32 md:w-32 mx-auto mb-3 object-contain drop-shadow-[0_0_15px_rgba(239,68,68,0.5)] group-hover:drop-shadow-[0_0_25px_rgba(239,68,68,0.8)] transition-all duration-300">
                <p class="mb-2 text-sm md:text-base font-bold tracking-wider text-gray-700 dark:text-gray-200">MAGHRIB</p>
                <p class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white"
                    x-text="formatWaktu(jadwalSholat.Maghrib)"></p>
                <span x-show="isNextPrayer('Maghrib')"
                    class="mt-3 inline-block rounded-full bg-emerald-500 px-4 py-1 text-xs font-bold text-white animate-pulse shadow-lg shadow-emerald-500/50">BERIKUTNYA</span>
            </div>

            {{-- ISYA --}}
            <div class="relative p-4 md:p-6 text-center transition-all duration-300 hover:scale-110 group cursor-pointer"
                :class="{ 'scale-110': isNextPrayer('Isha') }">
                <img src="{{ asset('Logo/Jadwal.png') }}" alt="Isya"
                    class="h-24 w-24 md:h-32 md:w-32 mx-auto mb-3 object-contain drop-shadow-[0_0_15px_rgba(99,102,241,0.5)] group-hover:drop-shadow-[0_0_25px_rgba(99,102,241,0.8)] transition-all duration-300">
                <p class="mb-2 text-sm md:text-base font-bold tracking-wider text-gray-700 dark:text-gray-200">ISYA</p>
                <p class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white"
                    x-text="formatWaktu(jadwalSholat.Isha)"></p>
                <span x-show="isNextPrayer('Isha')"
                    class="mt-3 inline-block rounded-full bg-emerald-500 px-4 py-1 text-xs font-bold text-white animate-pulse shadow-lg shadow-emerald-500/50">BERIKUTNYA</span>
            </div>

        </div>

        {{-- =========================================================
             INFO
        ========================================================== --}}
        <div
            class="rounded-2xl border border-amber-200 bg-gradient-to-br from-amber-50 to-orange-50 p-6 shadow-lg dark:border-amber-800 dark:from-amber-900/20 dark:to-orange-900/20">
            <div class="flex items-start gap-4">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-amber-500 text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="mb-2 text-sm font-bold text-amber-900 dark:text-amber-100">💡 Tips Penggunaan</h4>
                    <ul class="space-y-1 text-sm text-amber-800 dark:text-amber-200">
                        <li>• Pilih <strong>Provinsi → Kota → Kecamatan</strong> untuk akurasi terbaik.</li>
                        <li>• Data kecamatan tersedia untuk kota-kota besar di database.</li>
                        <li>• Jika data kecamatan belum tersedia, sistem otomatis menggunakan nama
                            <strong>Kota/Kabupaten</strong> yang Anda pilih.</li>
                        <li>• Lokasi & pilihan suara adzan tersimpan otomatis di browser Anda.</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- =========================================================
             TOAST
        ========================================================== --}}
        <div x-show="showToast" x-transition x-cloak
            class="fixed bottom-6 right-6 left-6 md:left-auto z-50 rounded-xl bg-emerald-600 px-6 py-4 text-white shadow-2xl">
            <div class="flex items-center gap-3">
                <svg class="h-6 w-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="font-semibold text-sm md:text-base" x-text="toastMessage"></p>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        function jadwalSholat() {
            return {
                /* =====================================================
                    DATA PROVINSI + KABUPATEN/KOTA + KECAMATAN (EMBED)
                ===================================================== */
                provinsiList: [{
                        id: 'dki',
                        nama: 'DKI Jakarta',
                        kota: ['Jakarta Pusat', 'Jakarta Utara', 'Jakarta Barat', 'Jakarta Selatan', 'Jakarta Timur',
                            'Kepulauan Seribu'
                        ]
                    },
                    {
                        id: 'jabar',
                        nama: 'Jawa Barat',
                        kota: ['Bandung', 'Bekasi', 'Bogor', 'Cimahi', 'Cirebon', 'Depok', 'Sukabumi', 'Tasikmalaya',
                            'Banjar', 'Bandung Barat', 'Garut', 'Indramayu', 'Karawang', 'Kuningan', 'Majalengka',
                            'Pangandaran', 'Purwakarta', 'Subang', 'Sumedang', 'Ciamis'
                        ]
                    },
                    {
                        id: 'jateng',
                        nama: 'Jawa Tengah',
                        kota: ['Semarang', 'Surakarta', 'Magelang', 'Pekalongan', 'Salatiga', 'Tegal', 'Banyumas',
                            'Batang', 'Blora', 'Boyolali', 'Brebes', 'Cilacap', 'Demak', 'Grobogan', 'Jepara',
                            'Karanganyar', 'Kebumen', 'Kendal', 'Klaten', 'Kudus', 'Pati', 'Pemalang',
                            'Purbalingga', 'Purworejo', 'Rembang', 'Sragen', 'Sukoharjo', 'Temanggung', 'Wonogiri',
                            'Wonosobo'
                        ]
                    },
                    {
                        id: 'diy',
                        nama: 'DI Yogyakarta',
                        kota: ['Yogyakarta', 'Bantul', 'Gunung Kidul', 'Kulon Progo', 'Sleman']
                    },
                    {
                        id: 'jatim',
                        nama: 'Jawa Timur',
                        kota: ['Surabaya', 'Malang', 'Sidoarjo', 'Gresik', 'Mojokerto', 'Pasuruan', 'Probolinggo',
                            'Madiun', 'Kediri', 'Blitar', 'Batu', 'Bangkalan', 'Banyuwangi', 'Bojonegoro',
                            'Bondowoso', 'Jember', 'Jombang', 'Lamongan', 'Lumajang', 'Magetan', 'Nganjuk', 'Ngawi',
                            'Pacitan', 'Pamekasan', 'Ponorogo', 'Sampang', 'Situbondo', 'Sumenep', 'Trenggalek',
                            'Tuban', 'Tulungagung'
                        ]
                    },
                    {
                        id: 'banten',
                        nama: 'Banten',
                        kota: ['Serang', 'Cilegon', 'Tangerang', 'Tangerang Selatan', 'Lebak', 'Pandeglang']
                    },
                    {
                        id: 'sumut',
                        nama: 'Sumatera Utara',
                        kota: ['Medan', 'Binjai', 'Pematang Siantar', 'Tanjung Balai', 'Tebing Tinggi', 'Sibolga',
                            'Padang Sidempuan', 'Gunungsitoli', 'Deli Serdang', 'Langkat', 'Karo', 'Simalungun',
                            'Asahan', 'Labuhan Batu', 'Tapanuli Utara', 'Tapanuli Tengah', 'Tapanuli Selatan',
                            'Mandailing Natal', 'Nias', 'Nias Selatan', 'Nias Utara', 'Nias Barat',
                            'Humbang Hasundutan', 'Pakpak Bharat', 'Samosir', 'Serdang Bedagai', 'Batu Bara',
                            'Padang Lawas', 'Padang Lawas Utara', 'Labuhan Batu Selatan', 'Labuhan Batu Utara'
                        ]
                    },
                    {
                        id: 'sumbar',
                        nama: 'Sumatera Barat',
                        kota: ['Padang', 'Bukittinggi', 'Padang Panjang', 'Payakumbuh', 'Sawahlunto', 'Solok',
                            'Pariaman', 'Agam', 'Dharmasraya', 'Kepulauan Mentawai', 'Lima Puluh Kota',
                            'Padang Pariaman', 'Pasaman', 'Pasaman Barat', 'Pesisir Selatan', 'Sijunjung',
                            'Solok Selatan', 'Tanah Datar'
                        ]
                    },
                    {
                        id: 'riau',
                        nama: 'Riau',
                        kota: ['Pekanbaru', 'Dumai', 'Bengkalis', 'Indragiri Hilir', 'Indragiri Hulu', 'Kampar',
                            'Kepulauan Meranti', 'Kuantan Singingi', 'Pelalawan', 'Rokan Hilir', 'Rokan Hulu',
                            'Siak'
                        ]
                    },
                    {
                        id: 'sumsel',
                        nama: 'Sumatera Selatan',
                        kota: ['Palembang', 'Lubuklinggau', 'Pagar Alam', 'Prabumulih', 'Banyuasin', 'Empat Lawang',
                            'Lahat', 'Muara Enim', 'Musi Banyuasin', 'Musi Rawas', 'Musi Rawas Utara', 'Ogan Ilir',
                            'Ogan Komering Ilir', 'Ogan Komering Ulu', 'Ogan Komering Ulu Selatan',
                            'Ogan Komering Ulu Timur', 'Penukal Abab Lematang Ilir'
                        ]
                    },
                    {
                        id: 'lampung',
                        nama: 'Lampung',
                        kota: ['Bandar Lampung', 'Metro', 'Lampung Barat', 'Lampung Selatan', 'Lampung Tengah',
                            'Lampung Timur', 'Lampung Utara', 'Mesuji', 'Pesawaran', 'Pesisir Barat', 'Pringsewu',
                            'Tanggamus', 'Tulang Bawang', 'Tulang Bawang Barat', 'Way Kanan'
                        ]
                    },
                    {
                        id: 'bali',
                        nama: 'Bali',
                        kota: ['Denpasar', 'Badung', 'Bangli', 'Buleleng', 'Gianyar', 'Jembrana', 'Karangasem',
                            'Klungkung', 'Tabanan'
                        ]
                    },
                    {
                        id: 'ntb',
                        nama: 'Nusa Tenggara Barat',
                        kota: ['Mataram', 'Bima', 'Dompu', 'Lombok Barat', 'Lombok Tengah', 'Lombok Timur',
                            'Lombok Utara', 'Sumbawa', 'Sumbawa Barat'
                        ]
                    },
                    {
                        id: 'kalbar',
                        nama: 'Kalimantan Barat',
                        kota: ['Pontianak', 'Singkawang', 'Bengkayang', 'Kapuas Hulu', 'Kayong Utara', 'Ketapang',
                            'Kubu Raya', 'Landak', 'Melawi', 'Sambas', 'Sanggau', 'Sekadau', 'Sintang'
                        ]
                    },
                    {
                        id: 'kalsel',
                        nama: 'Kalimantan Selatan',
                        kota: ['Banjarmasin', 'Banjarbaru', 'Balangan', 'Banjar', 'Barito Kuala', 'Hulu Sungai Selatan',
                            'Hulu Sungai Tengah', 'Hulu Sungai Utara', 'Kotabaru', 'Tabalong', 'Tanah Bumbu',
                            'Tanah Laut', 'Tapin'
                        ]
                    },
                    {
                        id: 'kaltim',
                        nama: 'Kalimantan Timur',
                        kota: ['Samarinda', 'Balikpapan', 'Bontang', 'Berau', 'Kutai Barat', 'Kutai Kartanegara',
                            'Kutai Timur', 'Mahakam Ulu', 'Paser', 'Penajam Paser Utara'
                        ]
                    },
                    {
                        id: 'sulsel',
                        nama: 'Sulawesi Selatan',
                        kota: ['Makassar', 'Palopo', 'Parepare', 'Bantaeng', 'Barru', 'Bone', 'Bulukumba', 'Enrekang',
                            'Gowa', 'Jeneponto', 'Kepulauan Selayar', 'Luwu', 'Luwu Timur', 'Luwu Utara', 'Maros',
                            'Pangkajene dan Kepulauan', 'Pinrang', 'Sidenreng Rappang', 'Sinjai', 'Soppeng',
                            'Takalar', 'Tana Toraja', 'Toraja Utara', 'Wajo'
                        ]
                    },
                    {
                        id: 'sulut',
                        nama: 'Sulawesi Utara',
                        kota: ['Manado', 'Bitung', 'Kotamobagu', 'Tomohon', 'Bolaang Mongondow',
                            'Bolaang Mongondow Selatan', 'Bolaang Mongondow Timur', 'Bolaang Mongondow Utara',
                            'Kepulauan Sangihe', 'Kepulauan Siau Tagulandang Biaro', 'Kepulauan Talaud', 'Minahasa',
                            'Minahasa Selatan', 'Minahasa Tenggara', 'Minahasa Utara'
                        ]
                    },
                    {
                        id: 'papua',
                        nama: 'Papua',
                        kota: ['Jayapura', 'Biak Numfor', 'Boven Digoel', 'Deiyai', 'Dogiyai', 'Intan Jaya',
                            'Jayawijaya', 'Keerom', 'Kepulauan Yapen', 'Lanny Jaya', 'Mamberamo Raya',
                            'Mamberamo Tengah', 'Mappi', 'Merauke', 'Mimika', 'Nabire', 'Nduga', 'Paniai',
                            'Pegunungan Bintang', 'Puncak', 'Puncak Jaya', 'Sarmi', 'Supiori', 'Tolikara',
                            'Waropen', 'Yahukimo', 'Yalimo'
                        ]
                    }
                ],

                dataKecamatan: {
                    'Jakarta Pusat': ['Gambir', 'Tanah Abang', 'Menteng', 'Senen', 'Cempaka Putih', 'Johar Baru',
                        'Kemayoran', 'Sawah Besar'
                    ],
                    'Jakarta Utara': ['Penjaringan', 'Pademangan', 'Tanjung Priok', 'Koja', 'Kelapa Gading', 'Cilincing'],
                    'Jakarta Barat': ['Cengkareng', 'Grogol Petamburan', 'Taman Sari', 'Tambora', 'Kebon Jeruk',
                        'Kalideres', 'Palmerah', 'Kembangan'
                    ],
                    'Jakarta Selatan': ['Jagakarsa', 'Pasar Minggu', 'Cilandak', 'Pesanggrahan', 'Kebayoran Lama',
                        'Kebayoran Baru', 'Mampang Prapatan', 'Pancoran', 'Tebet', 'Setiabudi'
                    ],
                    'Jakarta Timur': ['Pasar Rebo', 'Ciracas', 'Cipayung', 'Makasar', 'Kramat Jati', 'Jatinegara',
                        'Duren Sawit', 'Cakung', 'Pulo Gadung', 'Matraman'
                    ],
                    'Bandung': ['Andir', 'Astana Anyar', 'Antapani', 'Arcamanik', 'Babakan Ciparay', 'Bandung Kidul',
                        'Bandung Kulon', 'Bandung Wetan', 'Batununggal', 'Bojongloa Kaler', 'Bojongloa Kidul',
                        'Buahbatu', 'Cibeunying Kaler', 'Cibeunying Kidul', 'Cibiru', 'Cicendo', 'Cidadap', 'Cinambo',
                        'Coblong', 'Gedebage', 'Kiaracondong', 'Lengkong', 'Mandalajati', 'Panyileukan', 'Rancasari',
                        'Regol', 'Sukajadi', 'Sukasari', 'Sumur Bandung', 'Ujungberung'
                    ],
                    'Surabaya': ['Asemrowo', 'Benowo', 'Bubutan', 'Bulak', 'Dukuh Pakis', 'Gayungan', 'Genteng', 'Gubeng',
                        'Gunung Anyar', 'Jambangan', 'Karang Pilang', 'Kenjeran', 'Krembangan', 'Lakarsantri',
                        'Mulyorejo', 'Pabean Cantian', 'Pakal', 'Rungkut', 'Sambikerep', 'Sawahan', 'Semampir',
                        'Simokerto', 'Sukolilo', 'Sukomanunggal', 'Tambaksari', 'Tandes', 'Tegalsari',
                        'Tenggilis Mejoyo', 'Wiyung', 'Wonocolo', 'Wonokromo'
                    ],
                    'Semarang': ['Banyumanik', 'Candisari', 'Gajahmungkur', 'Gayamsari', 'Genuk', 'Gunungpati', 'Mijen',
                        'Ngaliyan', 'Pedurungan', 'Semarang Barat', 'Semarang Selatan', 'Semarang Tengah',
                        'Semarang Timur', 'Semarang Utara', 'Tembalang', 'Tugu'
                    ],
                    'Medan': ['Medan Amplas', 'Medan Area', 'Medan Barat', 'Medan Baru', 'Medan Belawan', 'Medan Deli',
                        'Medan Denai', 'Medan Helvetia', 'Medan Johor', 'Medan Kota', 'Medan Labuhan', 'Medan Maimun',
                        'Medan Marelan', 'Medan Polonia', 'Medan Selayang', 'Medan Sunggal', 'Medan Tembung',
                        'Medan Tuntungan'
                    ],
                    'Makassar': ['Biringkanaya', 'Bontoala', 'Mamajang', 'Manggala', 'Mariso', 'Panakkukang', 'Rappocini',
                        'Tamalate', 'Ujung Pandang', 'Ujung Tanah', 'Wajo'
                    ],
                    'Sidoarjo': ['Balongbendo', 'Buduran', 'Candi', 'Gedangan', 'Jabon', 'Krembung', 'Krian', 'Prambon',
                        'Porong', 'Sedati', 'Sidoarjo', 'Taman', 'Tanggulangin', 'Tarik', 'Tulangan', 'Waru', 'Wonoayu'
                    ],
                    'Malang': ['Blimbing', 'Kedungkandang', 'Klojen', 'Lowokwaru', 'Sukun'],
                    'Yogyakarta': ['Danurejan', 'Gedongtengen', 'Gondokusuman', 'Gondomanan', 'Jetis', 'Kotagede', 'Kraton',
                        'Mantrijeron', 'Mergangsan', 'Ngampilan', 'Pakualaman', 'Tegalrejo', 'Umbulharjo', 'Wirobrajan'
                    ],
                    'Bogor': ['Bogor Barat', 'Bogor Selatan', 'Bogor Tengah', 'Bogor Timur', 'Bogor Utara', 'Tanah Sareal'],
                    'Depok': ['Beji', 'Bojongsari', 'Cilodong', 'Cimanggis', 'Cinere', 'Cipayung', 'Limo', 'Pancoran Mas',
                        'Sawangan', 'Sukmajaya', 'Tapos'
                    ],
                    'Bekasi': ['Bantar Gebang', 'Bekasi Barat', 'Bekasi Selatan', 'Bekasi Timur', 'Bekasi Utara',
                        'Jatiasih', 'Jatisampurna', 'Medan Satria', 'Mustika Jaya', 'Pondok Gede', 'Pondok Melati',
                        'Rawalumbu'
                    ],
                    'Tangerang': ['Batuceper', 'Benda', 'Cibodas', 'Ciledug', 'Karawaci', 'Larangan', 'Neglasari', 'Periuk',
                        'Pinang', 'Tangerang'
                    ],
                    'Tangerang Selatan': ['Ciputat', 'Ciputat Timur', 'Pamulang', 'Pondok Aren', 'Serpong', 'Serpong Utara',
                        'Setu'
                    ],
                    'Denpasar': ['Denpasar Barat', 'Denpasar Selatan', 'Denpasar Timur', 'Denpasar Utara'],
                    'Palembang': ['Alang-Alang Lebar', 'Bukit Kecil', 'Gandus', 'Ilir Barat I', 'Ilir Barat II',
                        'Ilir Timur I', 'Ilir Timur II', 'Ilir Timur III', 'Kalidoni', 'Kemuning', 'Kertapati', 'Plaju',
                        'Sako', 'Seberang Ulu I', 'Seberang Ulu II', 'Sukarami'
                    ],
                    'Pekanbaru': ['Bukit Raya', 'Lima Puluh', 'Marpoyan Damai', 'Payung Sekaki', 'Pekanbaru Kota', 'Rumbai',
                        'Rumbai Barat', 'Rumbai Timur', 'Sail', 'Senapelan', 'Sukajadi', 'Tampan', 'Tenayan Raya'
                    ],
                    'Banjarmasin': ['Banjarmasin Barat', 'Banjarmasin Selatan', 'Banjarmasin Tengah', 'Banjarmasin Timur',
                        'Banjarmasin Utara'
                    ],
                    'Samarinda': ['Loa Janan Ilir', 'Palaran', 'Samarinda Ilir', 'Samarinda Kota', 'Samarinda Seberang',
                        'Samarinda Ulu', 'Sungai Kunjang'
                    ],
                    'Balikpapan': ['Balikpapan Barat', 'Balikpapan Kota', 'Balikpapan Selatan', 'Balikpapan Tengah',
                        'Balikpapan Timur', 'Balikpapan Utara'
                    ],
                    'Manado': ['Bunaken', 'Bunaken Kepulauan', 'Malalayang', 'Mapanget', 'Paal Dua', 'Sario', 'Singkil',
                        'Tikala', 'Tuminting', 'Wanea', 'Wenang'
                    ],
                    'Pontianak': ['Pontianak Barat', 'Pontianak Kota', 'Pontianak Selatan', 'Pontianak Timur',
                        'Pontianak Utara'
                    ],
                    'Padang': ['Bungus Teluk Kabung', 'Koto Tangah', 'Kuranji', 'Lubuk Begalung', 'Lubuk Kilangan',
                        'Nanggalo', 'Padang Barat', 'Padang Selatan', 'Padang Timur', 'Padang Utara', 'Pauh',
                        'Sei. Loloan'
                    ]
                },

                selectedProvinsi: localStorage.getItem('sholat_provinsi') || '',
                selectedKota: localStorage.getItem('sholat_kota_dropdown') || '',
                selectedKecamatan: localStorage.getItem('sholat_kecamatan_dropdown') || '',
                // manualKota DIHAPUS karena tidak lagi digunakan
                kotaList: [],
                kecamatanList: [],

                kota: localStorage.getItem('sholat_kota') || 'Sidoarjo',
                jadwalSholat: {
                    Fajr: '04:30',
                    Sunrise: '05:45',
                    Dhuhr: '11:45',
                    Asr: '15:00',
                    Maghrib: '17:45',
                    Isha: '19:00'
                },
                loading: true,
                tanggalHijriah: '',
                tanggalMasehi: '',
                sholatBerikutnyaNama: 'Fajr',
                countdown: '00:00:00',
                selectedAdzan: localStorage.getItem('selected_adzan') || 'masjidil_haram',
                adzanPlayed: false,
                isPlaying: false,
                isMuted: false,
                showToast: false,
                toastMessage: '',
                countdownInterval: null,
                toastTimeout: null,

                adzanSources: {
                    masjidil_haram: 'https://www.islamcan.com/audio/adhan/azan1.mp3',
                    mishary_alafasy: 'https://www.islamcan.com/audio/adhan/azan2.mp3',
                    abdul_basit: 'https://www.islamcan.com/audio/adhan/azan3.mp3',
                    saudi_1: 'https://www.islamcan.com/audio/adhan/azan4.mp3',
                    turki_1: 'https://www.islamcan.com/audio/adhan/azan5.mp3',
                    malaysia_1: 'https://www.islamcan.com/audio/adhan/azan6.mp3',
                    indonesia_1: 'https://www.islamcan.com/audio/adhan/azan7.mp3',
                    pakistan_1: 'https://www.islamcan.com/audio/adhan/azan8.mp3'
                },

                /* ===================================================== INIT ===================================================== */
                async init() {
                    this.updateAudioSource();
                    this.updateTanggal();

                    // Restore state dari localStorage
                    if (this.selectedProvinsi) {
                        this.loadKotaList(this.selectedProvinsi);
                        if (this.selectedKota) {
                            this.loadKecamatanList(this.selectedKota);
                            if (this.selectedKecamatan) {
                                this.kota = `${this.selectedKecamatan} ${this.selectedKota}`;
                            } else {
                                this.kota = this.selectedKota;
                            }
                        }
                    }

                    await this.ambilJadwal();
                    this.startCountdown();
                },

                updateTanggal() {
                    const now = new Date();
                    const options = {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    };
                    this.tanggalMasehi = now.toLocaleDateString('id-ID', options);
                    this.tanggalHijriah = now.toLocaleDateString('ar-SA', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    }) + ' H';
                },

                /* ===================================================== LOGIKA WILAYAH 3 LEVEL ===================================================== */
                loadKotaList(provId) {
                    const prov = this.provinsiList.find(p => p.id === provId);
                    this.kotaList = prov ? prov.kota : [];
                },

                loadKecamatanList(kotaNama) {
                    if (this.dataKecamatan[kotaNama]) {
                        this.kecamatanList = this.dataKecamatan[kotaNama];
                        this.showToastMessage(`📍 ${this.kecamatanList.length} kecamatan dimuat`);
                    } else {
                        this.kecamatanList = [];
                        this.showToastMessage(`⚠️ Data kecamatan untuk ${kotaNama} belum tersedia. Menggunakan nama Kota.`);
                    }
                },

                onProvinsiChange() {
                    this.selectedKota = '';
                    this.selectedKecamatan = '';
                    this.kota = 'Belum dipilih';
                    this.kecamatanList = [];

                    if (this.selectedProvinsi) {
                        localStorage.setItem('sholat_provinsi', this.selectedProvinsi);
                        this.loadKotaList(this.selectedProvinsi);
                        this.showToastMessage(`📍 ${this.kotaList.length} kota/kabupaten dimuat`);
                    } else {
                        this.kotaList = [];
                        localStorage.removeItem('sholat_provinsi');
                    }
                },

                onKotaChange() {
                    this.selectedKecamatan = '';
                    this.kecamatanList = [];

                    if (this.selectedKota) {
                        localStorage.setItem('sholat_kota_dropdown', this.selectedKota);
                        this.loadKecamatanList(this.selectedKota);

                        // Fallback otomatis: Jika tidak ada kecamatan, langsung pakai nama kota
                        if (this.kecamatanList.length === 0) {
                            this.kota = this.selectedKota;
                            localStorage.setItem('sholat_kota', this.kota);
                            this.gantiKota();
                        }
                    } else {
                        this.kota = 'Belum dipilih';
                        localStorage.removeItem('sholat_kota_dropdown');
                    }
                },

                onKecamatanChange() {
                    if (this.selectedKecamatan) {
                        this.kota = `${this.selectedKecamatan} ${this.selectedKota}`;
                        localStorage.setItem('sholat_kecamatan_dropdown', this.selectedKecamatan);
                        localStorage.setItem('sholat_kota', this.kota);
                        this.gantiKota();
                    } else {
                        this.kota = this.selectedKota;
                        localStorage.setItem('sholat_kota', this.kota);
                        localStorage.removeItem('sholat_kecamatan_dropdown');
                    }
                },

                // FUNGSI pakaiManualKota() DIHAPUS TOTAL agar tidak ada konflik

                /* ===================================================== GANTI KOTA ===================================================== */
                async gantiKota() {
                    this.showToastMessage(`📍 Memuat jadwal ${this.kota}...`);
                    this.loading = true;
                    this.adzanPlayed = false;
                    await this.ambilJadwal();
                },

                /* ===================================================== AMBIL JADWAL ===================================================== */
                async ambilJadwal() {
                    this.loading = true;
                    try {
                        const tanggal = new Date();
                        const year = tanggal.getFullYear();
                        const month = String(tanggal.getMonth() + 1).padStart(2, '0');
                        const day = String(tanggal.getDate()).padStart(2, '0');

                        const url =
                            `/api/jadwal-sholat?city=${encodeURIComponent(this.kota)}&date=${year}-${month}-${day}&_=${Date.now()}`;

                        const response = await fetch(url, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'Cache-Control': 'no-cache'
                            }
                        });

                        const data = await response.json();

                        if (!response.ok) throw new Error(data.detail || data.error || 'Gagal');

                        if (data.code === 200 && data.data && data.data.timings) {
                            this.jadwalSholat = data.data.timings;
                            if (data.data.date?.hijri) {
                                this.tanggalHijriah =
                                    `${data.data.date.hijri.day} ${data.data.date.hijri.month.en} ${data.data.date.hijri.year} H`;
                            }
                            if (data.data.date?.readable) {
                                this.tanggalMasehi = data.data.date.readable;
                            }
                            this.updateCountdown();
                            this.showToastMessage(`✅ Jadwal ${this.kota} dimuat`);
                        } else if (data.timings) {
                            this.jadwalSholat = data.timings;
                            this.updateCountdown();
                        } else {
                            throw new Error('Format tidak dikenali');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.showToastMessage(`❌ Gagal: ${error.message}. Jadwal default ditampilkan.`);
                    } finally {
                        this.loading = false;
                    }
                },

                /* ===================================================== FUNGSI BANTUAN ===================================================== */
                formatWaktu(waktu24) {
                    if (!waktu24) return '--:--';
                    return waktu24.toString().split(' ')[0].substring(0, 5);
                },

                isNextPrayer(nama) {
                    return this.sholatBerikutnyaNama === nama;
                },

                startCountdown() {
                    if (this.countdownInterval) clearInterval(this.countdownInterval);
                    this.countdownInterval = setInterval(() => this.updateCountdown(), 1000);
                },

                updateCountdown() {
                    if (!this.jadwalSholat || Object.keys(this.jadwalSholat).length === 0) {
                        this.countdown = '00:00:00';
                        return;
                    }

                    const now = new Date();
                    const prayers = ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
                    let nextPrayerFound = false;

                    for (const nama of prayers) {
                        const waktuStr = this.jadwalSholat[nama];
                        if (!waktuStr) continue;

                        const waktu = this.formatWaktu(waktuStr);
                        const parts = waktu.split(':');
                        if (parts.length < 2) continue;

                        const prayerTime = new Date();
                        prayerTime.setHours(parseInt(parts[0], 10), parseInt(parts[1], 10), 0, 0);

                        if (prayerTime > now) {
                            this.sholatBerikutnyaNama = nama;
                            nextPrayerFound = true;

                            const diff = prayerTime.getTime() - now.getTime();
                            const hours = Math.floor(diff / (1000 * 60 * 60));
                            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                            this.countdown =
                                `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                            if (diff <= 1000 && diff >= 0 && !this.adzanPlayed) {
                                this.putarAdzan();
                                this.adzanPlayed = true;
                                setTimeout(() => {
                                    this.adzanPlayed = false;
                                }, 300000);
                            }
                            break;
                        }
                    }

                    if (!nextPrayerFound) {
                        const waktuStr = this.jadwalSholat.Fajr;
                        if (!waktuStr) {
                            this.countdown = '00:00:00';
                            return;
                        }
                        const waktu = this.formatWaktu(waktuStr);
                        const [jam, menit] = waktu.split(':').map(Number);

                        const prayerTimeBesok = new Date();
                        prayerTimeBesok.setDate(prayerTimeBesok.getDate() + 1);
                        prayerTimeBesok.setHours(jam, menit, 0, 0);

                        const diff = prayerTimeBesok.getTime() - now.getTime();
                        this.sholatBerikutnyaNama = 'Fajr';

                        const hours = Math.floor(diff / (1000 * 60 * 60));
                        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                        this.countdown =
                            `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                    }
                },

                updateAudioSource() {
                    const audio = this.$refs.audioAdzan;
                    if (!audio) return;
                    const source = this.adzanSources[this.selectedAdzan];
                    if (!source) return;
                    audio.src = source;
                    audio.load();
                },

                putarAdzan() {
                    const audio = this.$refs.audioAdzan;
                    if (!audio) return;
                    audio.currentTime = 0;
                    audio.loop = false;
                    audio.play().then(() => {
                        this.isPlaying = true;
                        this.showToastMessage(`🕌 Waktunya ${this.translateNama(this.sholatBerikutnyaNama)}`);
                    }).catch(error => {
                        this.showToastMessage('⏰ Waktunya sholat! Klik Tes Adzan.');
                    });
                },

                toggleAdzan() {
                    const audio = this.$refs.audioAdzan;
                    if (!audio) return;

                    if (this.isPlaying) {
                        audio.pause();
                        audio.currentTime = 0;
                        this.isPlaying = false;
                        this.showToastMessage('⏹️ Adzan dihentikan');
                    } else {
                        audio.loop = true;
                        audio.play().then(() => {
                            this.isPlaying = true;
                            this.showToastMessage('▶️ Adzan diputar...');
                        }).catch(error => {
                            this.showToastMessage('❌ Gagal memutar adzan');
                        });
                    }
                },

                toggleMute() {
                    const audio = this.$refs.audioAdzan;
                    if (!audio) return;
                    this.isMuted = !this.isMuted;
                    audio.muted = this.isMuted;
                    this.showToastMessage(this.isMuted ? '🔇 Muted' : '🔊 Unmuted');
                },

                gantiAdzan() {
                    const wasPlaying = this.isPlaying;
                    if (wasPlaying) {
                        const audio = this.$refs.audioAdzan;
                        if (audio) {
                            audio.pause();
                            audio.currentTime = 0;
                        }
                        this.isPlaying = false;
                    }

                    localStorage.setItem('selected_adzan', this.selectedAdzan);
                    this.updateAudioSource();

                    if (wasPlaying) {
                        setTimeout(() => this.toggleAdzan(), 300);
                    }

                    this.showToastMessage(`✅ Suara adzan disimpan: ${this.selectedAdzan}`);
                },

                translateNama(nama) {
                    const map = {
                        Fajr: 'Subuh',
                        Dhuhr: 'Dzuhur',
                        Asr: 'Ashar',
                        Maghrib: 'Maghrib',
                        Isha: 'Isya'
                    };
                    return map[nama] || nama;
                },

                showToastMessage(message) {
                    this.toastMessage = message;
                    this.showToast = true;
                    if (this.toastTimeout) clearTimeout(this.toastTimeout);
                    this.toastTimeout = setTimeout(() => {
                        this.showToast = false;
                    }, 3000);
                }
            };
        }
    </script>
@endpush
