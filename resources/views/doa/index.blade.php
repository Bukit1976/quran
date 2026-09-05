@extends('layouts.app')

@section('title', 'Kumpulan Doa')

@section('header')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white">Kumpulan Doa-Doa Pilihan</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Doa harian, doa khusus, dan doa-doa mustajab.</p>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .doa-arabic {
            font-family: 'Amiri', 'Traditional Arabic', serif !important;
            font-size: 28px !important;
            line-height: 2.8 !important;
            text-align: right !important;
            direction: rtl !important;
            color: #1f2937 !important;
            padding: 16px 0 !important;
        }

        .dark .doa-arabic {
            color: #f3f4f6 !important;
        }

        .doa-latin {
            font-size: 15px !important;
            line-height: 1.8 !important;
            font-style: italic !important;
            color: #059669 !important;
            padding: 12px 0 !important;
        }

        .dark .doa-latin {
            color: #34d399 !important;
        }

        .doa-arti {
            font-size: 14px !important;
            line-height: 1.8 !important;
            color: #374151 !important;
        }

        .dark .doa-arti {
            color: #d1d5db !important;
        }

        @media (max-width: 640px) {
            .doa-arabic {
                font-size: 24px !important;
                line-height: 2.4 !important;
            }
        }

        .doa-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out;
        }

        .doa-content.open {
            max-height: 2000px;
            transition: max-height 0.6s ease-in;
        }

        .icon-chevron {
            transition: transform 0.3s ease;
        }

        .icon-chevron.rotate {
            transform: rotate(180deg);
        }

        .doa-header:hover {
            background-color: rgba(16, 185, 129, 0.05);
        }

        .dark .doa-header:hover {
            background-color: rgba(16, 185, 129, 0.1);
        }

        .doa-item.active {
            border-color: #10b981 !important;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.15) !important;
        }

        .btn-dengarkan {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
        }

        .btn-dengarkan:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.4);
        }

        .btn-dengarkan.speaking {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4);
            }

            50% {
                box-shadow: 0 0 0 8px rgba(239, 68, 68, 0);
            }
        }

        .voice-selector {
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            background: white;
            font-size: 0.875rem;
            color: #374151;
            cursor: pointer;
            width: 100%;
        }

        .dark .voice-selector {
            background: #374151;
            border-color: #4b5563;
            color: #f3f4f6;
        }

        .info-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid #f59e0b;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .dark .info-box {
            background: linear-gradient(135deg, #78350f 0%, #92400e 100%);
            border-left-color: #fbbf24;
        }
    </style>
@endpush

@section('content')
    <div x-data="{ search: '', openId: null }" class="mx-auto max-w-3xl space-y-6">

        {{-- Info Box --}}
        <div class="info-box">
            <div class="flex items-start gap-3">
                <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-amber-600 dark:text-amber-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-amber-900 dark:text-amber-100">💡 Tips Suara Jernih</p>
                    <p class="mt-1 text-xs text-amber-800 dark:text-amber-200">
                        Pilih suara <strong>🇮🇩 Indonesia</strong> untuk arti dan <strong>🕋 Laki-laki/Perempuan</strong>
                        untuk bacaan Arab. Pilihan suara tergantung paket bahasa yang terinstal di perangkat Anda.
                    </p>
                </div>
            </div>
        </div>

        {{-- Voice Selector untuk Arti (Indonesia) --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">🔊 Suara Arti (Bahasa
                Indonesia)</label>
            <select id="voiceSelect" class="voice-selector">
                <option value="">Memuat daftar suara...</option>
            </select>
        </div>

        {{-- Voice Selector untuk Arab --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">🕋 Suara Bacaan Arab</label>
            <select id="voiceSelectArab" class="voice-selector">
                <option value="">Memuat daftar suara...</option>
            </select>
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                💡 <em>Tidak ada pilihan Laki-laki/Perempuan?</em> Tambahkan paket suara Arab di pengaturan perangkat Anda.
            </p>
        </div>

        {{-- Search Bar --}}
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input x-model="search" type="text" placeholder="Cari nama doa, latin, atau arti..."
                class="block w-full rounded-xl border-gray-300 bg-white py-3 pl-10 pr-4 text-gray-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
        </div>

        {{-- Info --}}
        <div class="flex items-center justify-between px-1">
            <p class="text-sm text-gray-600 dark:text-gray-400"><span
                    class="font-semibold text-emerald-600">{{ count($doas) }}</span> doa tersedia</p>
            <button x-show="openId !== null" @click="openId = null"
                class="text-sm font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-400">Tutup
                Semua</button>
        </div>

        {{-- Daftar Doa --}}
        <div class="space-y-4">
            @foreach ($doas as $doa)
                <div class="doa-item overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition-all duration-300 dark:border-gray-700 dark:bg-gray-800"
                    :class="{ 'active': openId === {{ $doa['id'] }} }"
                    x-show="'{{ strtolower($doa['judul']) }}'.includes(search.toLowerCase()) || search === ''">

                    <button @click="openId = openId === {{ $doa['id'] }} ? null : {{ $doa['id'] }}"
                        class="doa-header flex w-full items-center justify-between px-5 py-4 text-left">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 text-sm font-bold text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300">
                                {{ $doa['id'] }}</div>
                            <span class="text-base font-semibold text-gray-900 dark:text-white">{{ $doa['judul'] }}</span>
                        </div>
                        <svg class="icon-chevron h-5 w-5 flex-shrink-0 text-emerald-600 dark:text-emerald-400"
                            :class="{ 'rotate': openId === {{ $doa['id'] }} }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div class="doa-content border-t border-gray-100 dark:border-gray-700"
                        :class="{ 'open': openId === {{ $doa['id'] }} }">
                        <div class="space-y-5 px-5 py-5">
                            <div
                                class="rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50 p-5 dark:from-emerald-900/20 dark:to-teal-900/20">
                                <p class="doa-arabic">{{ $doa['arab'] }}</p>
                            </div>
                            <div>
                                <p class="doa-latin">{{ $doa['latin'] }}</p>
                            </div>
                            <div class="rounded-xl bg-gray-50 p-4 dark:bg-gray-900/50">
                                <div class="flex items-start gap-2">
                                    <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-emerald-600 dark:text-emerald-400"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="flex-1">
                                        <p
                                            class="mb-1 text-xs font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                                            Artinya</p>
                                        <p class="doa-arti">{{ $doa['arti'] }}</p>

                                        {{-- TOMBOL GANDA: ARAB & INDONESIA --}}
                                        <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                                            <button type="button" class="btn-dengarkan doa-audio-btn-arab flex-1"
                                                style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);"
                                                data-arab="{{ htmlspecialchars($doa['arab'], ENT_QUOTES, 'UTF-8') }}">
                                                <svg class="btn-icon-play h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                                                </svg>
                                                <svg class="btn-icon-stop hidden h-4 w-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                                                </svg>
                                                <span class="btn-text">🕋 Dengarkan Arab</span>
                                            </button>

                                            <button type="button" class="btn-dengarkan doa-audio-btn flex-1"
                                                data-arti="{{ addslashes($doa['arti']) }}">
                                                <svg class="btn-icon-play h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                                                </svg>
                                                <svg class="btn-icon-stop hidden h-4 w-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                                                </svg>
                                                <span class="btn-text">🔊 Dengarkan Arti</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentBtn = null;
            let isSpeaking = false;
            let resumeInterval = null;
            let selectedVoiceIndo = null;
            let selectedVoiceArab = null;
            const voiceSelect = document.getElementById('voiceSelect');
            const voiceSelectArab = document.getElementById('voiceSelectArab');

            if (!('speechSynthesis' in window)) {
                alert('Browser Anda tidak mendukung fitur Text-to-Speech.');
                return;
            }

            // ===== FUNGSI DETEKSI GENDER DARI NAMA VOICE =====
            function detectGender(voiceName) {
                const name = voiceName.toLowerCase();
                // Daftar nama yang mengindikasikan LAKI-LAKI
                const maleKeywords = ['male', 'man ', 'pria', 'laki', 'naayf', 'naif', 'hamed', 'maged', 'rami',
                    'salim', 'tariq', 'husam', 'omar', 'khaled', 'ahmad', 'mohammad', 'google us english',
                    'daniel', 'david', 'mark', 'alex', 'fred', 'jorge', 'diego', 'paul', 'luca', 'thomas',
                    'yuri'
                ];
                // Daftar nama yang mengindikasikan PEREMPUAN
                const femaleKeywords = ['female', 'woman', 'wanita', 'perempuan', 'cewek', 'hoda', 'zira', 'hazel',
                    'susan', 'linda', 'heera', 'sarah', 'mary', 'anna', 'samantha', 'victoria', 'karen',
                    'moira', 'tessa', 'fiona', 'veena', 'lekha', 'google uk english female', 'monica',
                    'paulina', 'alice', 'elsa', 'katja', 'petra'
                ];

                for (let k of maleKeywords) {
                    if (name.includes(k)) return 'male';
                }
                for (let k of femaleKeywords) {
                    if (name.includes(k)) return 'female';
                }
                return 'unknown';
            }

            // ===== LOAD DAFTAR VOICE =====
            function loadVoices() {
                const voices = window.speechSynthesis.getVoices();
                if (voices.length === 0) return;

                // ===== DROPDOWN INDONESIA =====
                voiceSelect.innerHTML = '';
                const indoMalayVoices = voices.filter(v =>
                    v.lang.includes('id') || v.lang.includes('ms') ||
                    v.name.toLowerCase().includes('indonesia') || v.name.toLowerCase().includes('indonesian') ||
                    v.name.toLowerCase().includes('melayu') || v.name.toLowerCase().includes('malay')
                );

                const defaultIndoOption = document.createElement('option');
                defaultIndoOption.value = 'default-id';
                defaultIndoOption.textContent = '🇮🇩 Bahasa Indonesia (Default Sistem)';
                voiceSelect.appendChild(defaultIndoOption);

                if (indoMalayVoices.length > 0) {
                    const group = document.createElement('optgroup');
                    group.label = '🇮🇩🇲🇾 Suara Indonesia / Melayu Tersedia';
                    indoMalayVoices.forEach((voice) => {
                        const option = document.createElement('option');
                        option.value = voices.indexOf(voice);
                        option.textContent = `${voice.name} (${voice.lang})`;
                        group.appendChild(option);
                    });
                    voiceSelect.appendChild(group);
                }

                const savedIndo = localStorage.getItem('selectedDoaVoiceIndo');
                if (savedIndo === 'default-id') {
                    voiceSelect.value = 'default-id';
                    selectedVoiceIndo = null;
                } else if (savedIndo && voices[savedIndo]) {
                    voiceSelect.value = savedIndo;
                    selectedVoiceIndo = voices[savedIndo];
                } else if (indoMalayVoices.length > 0) {
                    let defaultVoice = indoMalayVoices.find(v => v.lang.includes('id'));
                    if (!defaultVoice) defaultVoice = indoMalayVoices[0];
                    const defaultIdx = voices.indexOf(defaultVoice);
                    voiceSelect.value = defaultIdx;
                    selectedVoiceIndo = defaultVoice;
                    localStorage.setItem('selectedDoaVoiceIndo', defaultIdx);
                } else {
                    voiceSelect.value = 'default-id';
                    selectedVoiceIndo = null;
                }

                // ===== DROPDOWN ARAB =====
                voiceSelectArab.innerHTML = '';
                const arabicVoices = voices.filter(v => v.lang.includes('ar'));

                if (arabicVoices.length === 0) {
                    const noOption = document.createElement('option');
                    noOption.value = 'default-ar';
                    noOption.textContent = '🕋 Suara Arab Default (Sistem)';
                    voiceSelectArab.appendChild(noOption);
                    selectedVoiceArab = null;
                } else {
                    // Kelompokkan berdasarkan gender
                    const maleVoices = arabicVoices.filter(v => detectGender(v.name) === 'male');
                    const femaleVoices = arabicVoices.filter(v => detectGender(v.name) === 'female');
                    const unknownVoices = arabicVoices.filter(v => detectGender(v.name) === 'unknown');

                    // Opsi default
                    const defaultArOption = document.createElement('option');
                    defaultArOption.value = 'default-ar';
                    defaultArOption.textContent = '🕋 Arab (Otomatis Sistem)';
                    voiceSelectArab.appendChild(defaultArOption);

                    // Grup Laki-laki
                    if (maleVoices.length > 0) {
                        const group = document.createElement('optgroup');
                        group.label = '👨 Laki-laki (Disarankan untuk Doa)';
                        maleVoices.forEach((voice) => {
                            const option = document.createElement('option');
                            option.value = voices.indexOf(voice);
                            option.textContent = `${voice.name} (${voice.lang})`;
                            group.appendChild(option);
                        });
                        voiceSelectArab.appendChild(group);
                    }

                    // Grup Perempuan
                    if (femaleVoices.length > 0) {
                        const group = document.createElement('optgroup');
                        group.label = '👩 Perempuan';
                        femaleVoices.forEach((voice) => {
                            const option = document.createElement('option');
                            option.value = voices.indexOf(voice);
                            option.textContent = `${voice.name} (${voice.lang})`;
                            group.appendChild(option);
                        });
                        voiceSelectArab.appendChild(group);
                    }

                    // Grup Tidak Terdeteksi
                    if (unknownVoices.length > 0) {
                        const group = document.createElement('optgroup');
                        group.label = '🎙️ Suara Arab Lainnya';
                        unknownVoices.forEach((voice) => {
                            const option = document.createElement('option');
                            option.value = voices.indexOf(voice);
                            option.textContent = `${voice.name} (${voice.lang})`;
                            group.appendChild(option);
                        });
                        voiceSelectArab.appendChild(group);
                    }

                    // Auto-pilih: Prioritas Laki-laki (karena lebih cocok untuk doa)
                    const savedArab = localStorage.getItem('selectedDoaVoiceArab');
                    if (savedArab === 'default-ar') {
                        voiceSelectArab.value = 'default-ar';
                        selectedVoiceArab = null;
                    } else if (savedArab && voices[savedArab]) {
                        voiceSelectArab.value = savedArab;
                        selectedVoiceArab = voices[savedArab];
                    } else if (maleVoices.length > 0) {
                        const idx = voices.indexOf(maleVoices[0]);
                        voiceSelectArab.value = idx;
                        selectedVoiceArab = maleVoices[0];
                        localStorage.setItem('selectedDoaVoiceArab', idx);
                    } else {
                        voiceSelectArab.value = 'default-ar';
                        selectedVoiceArab = null;
                    }
                }
            }

            if (speechSynthesis.onvoiceschanged !== undefined) {
                speechSynthesis.onvoiceschanged = loadVoices;
            }
            loadVoices();

            // Event: Pilih suara Indonesia
            voiceSelect.addEventListener('change', function() {
                const voices = window.speechSynthesis.getVoices();
                const val = this.value;
                if (val === 'default-id') {
                    selectedVoiceIndo = null;
                    localStorage.setItem('selectedDoaVoiceIndo', val);
                } else {
                    const idx = parseInt(val);
                    if (voices[idx]) {
                        selectedVoiceIndo = voices[idx];
                        localStorage.setItem('selectedDoaVoiceIndo', idx);
                    }
                }
            });

            // Event: Pilih suara Arab
            voiceSelectArab.addEventListener('change', function() {
                const voices = window.speechSynthesis.getVoices();
                const val = this.value;
                if (val === 'default-ar') {
                    selectedVoiceArab = null;
                    localStorage.setItem('selectedDoaVoiceArab', val);
                } else {
                    const idx = parseInt(val);
                    if (voices[idx]) {
                        selectedVoiceArab = voices[idx];
                        localStorage.setItem('selectedDoaVoiceArab', idx);
                    }
                }
            });

            // ===== FUNGSI UTAMA BERBICARA =====
            function speakText(text, langCode, button) {
                window.speechSynthesis.cancel();
                if (resumeInterval) {
                    clearInterval(resumeInterval);
                    resumeInterval = null;
                }

                const utterance = new SpeechSynthesisUtterance(text);

                if (langCode === 'ar-SA') {
                    utterance.lang = 'ar-SA';
                    utterance.rate = 0.8;
                    if (selectedVoiceArab) {
                        utterance.voice = selectedVoiceArab;
                    } else {
                        // Fallback: cari suara Arab otomatis
                        const voices = window.speechSynthesis.getVoices();
                        const arabicVoice = voices.find(v => v.lang.includes('ar'));
                        if (arabicVoice) utterance.voice = arabicVoice;
                    }
                } else {
                    utterance.lang = 'id-ID';
                    utterance.rate = 0.9;
                    if (selectedVoiceIndo) utterance.voice = selectedVoiceIndo;
                }

                utterance.pitch = 1.0;
                utterance.volume = 1.0;

                utterance.onstart = function() {
                    isSpeaking = true;
                    currentBtn = button;
                    button.classList.add('speaking');
                    button.querySelector('.btn-icon-play').classList.add('hidden');
                    button.querySelector('.btn-icon-stop').classList.remove('hidden');
                    button.querySelector('.btn-text').textContent = 'Berhenti';
                };

                utterance.onend = function() {
                    resetButton();
                };
                utterance.onerror = function(e) {
                    console.error('TTS Error:', e);
                    resetButton();
                };

                window.speechSynthesis.speak(utterance);

                resumeInterval = setInterval(() => {
                    if (window.speechSynthesis.speaking && !window.speechSynthesis.paused) {
                        window.speechSynthesis.resume();
                    }
                }, 10000);
            }

            function resetButton() {
                isSpeaking = false;
                if (resumeInterval) {
                    clearInterval(resumeInterval);
                    resumeInterval = null;
                }
                if (currentBtn) {
                    currentBtn.classList.remove('speaking');
                    currentBtn.querySelector('.btn-icon-play').classList.remove('hidden');
                    currentBtn.querySelector('.btn-icon-stop').classList.add('hidden');

                    if (currentBtn.classList.contains('doa-audio-btn-arab')) {
                        currentBtn.querySelector('.btn-text').textContent = '🕋 Dengarkan Arab';
                    } else {
                        currentBtn.querySelector('.btn-text').textContent = '🔊 Dengarkan Arti';
                    }
                    currentBtn = null;
                }
            }

            // Event: Tombol Arti (Indonesia)
            document.querySelectorAll('.doa-audio-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (isSpeaking && currentBtn === this) {
                        window.speechSynthesis.cancel();
                        resetButton();
                        return;
                    }
                    if (currentBtn) {
                        window.speechSynthesis.cancel();
                        resetButton();
                    }
                    speakText(this.getAttribute('data-arti'), 'id-ID', this);
                });
            });

            // Event: Tombol Arab
            document.querySelectorAll('.doa-audio-btn-arab').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (isSpeaking && currentBtn === this) {
                        window.speechSynthesis.cancel();
                        resetButton();
                        return;
                    }
                    if (currentBtn) {
                        window.speechSynthesis.cancel();
                        resetButton();
                    }
                    const arabText = this.getAttribute('data-arab');
                    speakText(arabText, 'ar-SA', this);
                });
            });

            window.addEventListener('beforeunload', function() {
                window.speechSynthesis.cancel();
            });
        });
    </script>
@endpush
