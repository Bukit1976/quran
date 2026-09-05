{{-- Modal Tema --}}
<div id="modal-tema" class="fixed inset-0 z-50 hidden">
    <div class="flex min-h-screen items-center justify-center p-4" onclick="closeModal('modal-tema')">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-900"
            onclick="event.stopPropagation()">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tema Aplikasi</h3>
                <button onclick="closeModal('modal-tema')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="space-y-2">
                @foreach (['mengikuti_perangkat' => 'Mengikuti Perangkat', 'gelap' => 'Gelap', 'terang' => 'Terang'] as $key => $label)
                    <button
                        onclick="selectOption('tema_aplikasi', '{{ $key }}', 'label-tema', '{{ $label }}', 'modal-tema')"
                        class="option-button {{ ($settings->tema_aplikasi ?? 'mengikuti_perangkat') === $key ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} w-full rounded-xl px-4 py-3 text-left transition-colors"
                        data-value="{{ $key }}">
                        <div class="flex items-center justify-between"><span>{{ $label }}</span>
                            @if (($settings->tema_aplikasi ?? 'mengikuti_perangkat') === $key)
                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </div>
                    </button>
                @endforeach
            </div>
            <div class="mt-6 flex gap-3"><button onclick="closeModal('modal-tema')"
                    class="flex-1 rounded-xl bg-gray-200 py-3 font-medium text-gray-700 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Batal</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Mode Baca --}}
<div id="modal-mode" class="fixed inset-0 z-50 hidden">
    <div class="flex min-h-screen items-center justify-center p-4" onclick="closeModal('modal-mode')">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-900"
            onclick="event.stopPropagation()">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Mode Baca Qur'an</h3>
                <button onclick="closeModal('modal-mode')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="space-y-2">
                @foreach (['selalu_tanya' => 'Selalu Tanya', 'otomatis_madani' => 'Otomatis (Madani)', 'otomatis_indopak' => 'Otomatis (IndoPak)'] as $key => $label)
                    <button
                        onclick="selectOption('mode_baca_quran', '{{ $key }}', 'label-mode', '{{ $label }}', 'modal-mode')"
                        class="option-button {{ ($settings->mode_baca_quran ?? 'selalu_tanya') === $key ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} w-full rounded-xl px-4 py-3 text-left transition-colors"
                        data-value="{{ $key }}">
                        <div class="flex items-center justify-between"><span>{{ $label }}</span>
                            @if (($settings->mode_baca_quran ?? 'selalu_tanya') === $key)
                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </div>
                    </button>
                @endforeach
            </div>
            <div class="mt-6 flex gap-3"><button onclick="closeModal('modal-mode')"
                    class="flex-1 rounded-xl bg-gray-200 py-3 font-medium text-gray-700 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Batal</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Jenis Penulisan --}}
<div id="modal-jenis" class="fixed inset-0 z-50 hidden">
    <div class="flex min-h-screen items-center justify-center p-4" onclick="closeModal('modal-jenis')">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-900"
            onclick="event.stopPropagation()">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Jenis Penulisan Arabic</h3>
                <button onclick="closeModal('modal-jenis')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="space-y-2">
                @foreach (['indopak' => 'IndoPak (Asia)', 'utsmani' => 'Utsmani (Mushaf Madinah)', 'standar' => 'Standar'] as $key => $label)
                    <button
                        onclick="selectOption('jenis_penulisan_arabic', '{{ $key }}', 'label-jenis', '{{ $label }}', 'modal-jenis')"
                        class="option-button {{ ($settings->jenis_penulisan_arabic ?? 'indopak') === $key ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} w-full rounded-xl px-4 py-3 text-left transition-colors"
                        data-value="{{ $key }}">
                        <div class="flex items-center justify-between"><span>{{ $label }}</span>
                            @if (($settings->jenis_penulisan_arabic ?? 'indopak') === $key)
                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </div>
                    </button>
                @endforeach
            </div>
            <div class="mt-6 flex gap-3"><button onclick="closeModal('modal-jenis')"
                    class="flex-1 rounded-xl bg-gray-200 py-3 font-medium text-gray-700 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Batal</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Font Size --}}
<div id="modal-font" class="fixed inset-0 z-50 hidden">
    <div class="flex min-h-screen items-center justify-center p-4" onclick="closeModal('modal-font')">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-900"
            onclick="event.stopPropagation()">
            <div class="mb-2 text-center">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Ukuran Font</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400" id="font-modal-subtitle">Pilih ukuran font</p>
            </div>
            <div class="my-6 flex items-center justify-center gap-6">
                <button onclick="adjustFontSize(-1)"
                    class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-200 text-2xl font-bold text-gray-700 transition-colors hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">−</button>
                <span class="w-20 text-center text-3xl font-bold text-gray-900 dark:text-white"
                    id="font-size-display">18</span>
                <button onclick="adjustFontSize(1)"
                    class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-200 text-2xl font-bold text-gray-700 transition-colors hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">+</button>
            </div>
            <div class="flex gap-3">
                <button onclick="closeModal('modal-font')"
                    class="flex-1 rounded-xl bg-gray-200 py-3 font-medium text-gray-700 transition-colors hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Batal</button>
                <button onclick="saveFontSize()"
                    class="flex-1 rounded-xl bg-emerald-500 py-3 font-medium text-white transition-colors hover:bg-emerald-600">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Penerjemah --}}
<div id="modal-penerjemah" class="fixed inset-0 z-50 hidden">
    <div class="flex min-h-screen items-center justify-center p-4" onclick="closeModal('modal-penerjemah')">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-900"
            onclick="event.stopPropagation()">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Penerjemah</h3>
                <button onclick="closeModal('modal-penerjemah')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="space-y-2">
                @foreach (['kemenag-ri' => 'Kemenag-RI', 'quraish-shihab' => 'Quraish Shihab', 'buya-hamka' => 'Buya Hamka', 'jalalain' => 'Jalalain'] as $key => $label)
                    <button
                        onclick="selectOption('penerjemah', '{{ $key }}', 'label-penerjemah', '{{ $label }}', 'modal-penerjemah')"
                        class="option-button {{ ($settings->penerjemah ?? 'kemenag-ri') === $key ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} w-full rounded-xl px-4 py-3 text-left transition-colors"
                        data-value="{{ $key }}">
                        <div class="flex items-center justify-between"><span>{{ $label }}</span>
                            @if (($settings->penerjemah ?? 'kemenag-ri') === $key)
                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </div>
                    </button>
                @endforeach
            </div>
            <div class="mt-6 flex gap-3"><button onclick="closeModal('modal-penerjemah')"
                    class="flex-1 rounded-xl bg-gray-200 py-3 font-medium text-gray-700 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Batal</button>
            </div>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- Modal Qori - 26 QORI LENGKAP & BENAR --}}
{{-- ============================================ --}}
<div id="modal-qori" class="fixed inset-0 z-50 hidden">
    <div class="flex min-h-screen items-center justify-center p-4" onclick="closeModal('modal-qori')">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-900"
            onclick="event.stopPropagation()">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Qori Murattal</h3>
                <button onclick="closeModal('modal-qori')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="max-h-96 space-y-2 overflow-y-auto pr-2">
                @php
                    $daftarQori = [
                        'mishary_rashid' => 'Mishary Rashid Alafasy',
                        'abdul_basit_murattal' => 'Abdul Basit (Murattal)',
                        'abdul_basit_mujawwad' => 'Abdul Basit (Mujawwad)',
                        'maher_almuaiqly' => 'Maher Al Muaiqly',
                        'saad_ghamdi' => 'Saad Al-Ghamadi',
                        'ahmad_alajamy' => 'Ahmad Al-Ajamy',
                        'husary' => 'Mahmoud Khalil Al-Husary',
                        'minshawi_murattal' => 'Mohamed Siddiq El-Minshawi (Murattal)',
                        'minshawi_mujawwad' => 'Mohamed Siddiq El-Minshawi (Mujawwad)',
                        'muhammad_ayyoub' => 'Muhammad Ayyoub',
                        'muhammad_jibreel' => 'Muhammad Jibreel',
                        'sudais' => 'Abdurrahman As-Sudais',
                        'abu_bakr_ash_shaatree' => 'Abu Bakr Ash-Shaatree',
                        'hani_ar_rifai' => 'Hani Ar-Rifai',
                        'mahmood_ali_albanna' => 'Mahmood Ali Al-Banna',
                        'muhammad_saleh_almunajjid' => 'Muhammad Saleh Al-Munajjid',
                        'saud_ash_shuraim' => 'Saud Ash-Shuraim',
                        'nasser_alqatami' => 'Nasser Al-Qatami',
                        'yasser_ad_dossari' => 'Yasser Ad-Dossari',
                        'khalid_aljileel' => 'Khalid Al-Jileel',
                        'bandar_baleela' => 'Bandar Baleela',
                        'ali_alhudhaifi' => 'Ali Al-Hudhaifi',
                        'fares_abbad' => 'Fares Abbad',
                        'salah_bukhatir' => 'Salah Bukhatir',
                        'ibrahim_akhdar' => 'Ibrahim Al-Akhdar',
                        'ahmed_neana' => 'Ahmed Neana',
                    ];
                @endphp
                @foreach ($daftarQori as $key => $label)
                    <button
                        onclick="selectOption('qori_murattal', '{{ $key }}', 'label-qori', '{{ $label }}', 'modal-qori')"
                        class="option-button {{ ($settings->qori_murattal ?? 'mishary_rashid') === $key ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} w-full rounded-xl px-4 py-3 text-left transition-colors"
                        data-value="{{ $key }}">
                        <div class="flex items-center justify-between">
                            <span>{{ $label }}</span>
                            @if (($settings->qori_murattal ?? 'mishary_rashid') === $key)
                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </div>
                    </button>
                @endforeach
            </div>
            <div class="mt-6 flex gap-3">
                <button onclick="closeModal('modal-qori')"
                    class="flex-1 rounded-xl bg-gray-200 py-3 font-medium text-gray-700 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Batal</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Aksi Popup --}}
<div id="modal-popup" class="fixed inset-0 z-50 hidden">
    <div class="flex min-h-screen items-center justify-center p-4" onclick="closeModal('modal-popup')">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-900"
            onclick="event.stopPropagation()">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Aksi Popup Ayat</h3>
                <button onclick="closeModal('modal-popup')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="space-y-2">
                @foreach (['diklik' => 'Diklik', 'ditekan_lama' => 'Ditekan Lama'] as $key => $label)
                    <button
                        onclick="selectOption('aksi_popup_ayat', '{{ $key }}', 'label-popup', '{{ $label }}', 'modal-popup')"
                        class="option-button {{ ($settings->aksi_popup_ayat ?? 'diklik') === $key ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} w-full rounded-xl px-4 py-3 text-left transition-colors"
                        data-value="{{ $key }}">
                        <div class="flex items-center justify-between"><span>{{ $label }}</span>
                            @if (($settings->aksi_popup_ayat ?? 'diklik') === $key)
                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </div>
                    </button>
                @endforeach
            </div>
            <div class="mt-6 flex gap-3"><button onclick="closeModal('modal-popup')"
                    class="flex-1 rounded-xl bg-gray-200 py-3 font-medium text-gray-700 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Batal</button>
            </div>
        </div>
    </div>
</div>
