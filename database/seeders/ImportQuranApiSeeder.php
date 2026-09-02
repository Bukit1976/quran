<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Surah;
use App\Models\Ayat;
use Illuminate\Support\Facades\Http;

class ImportQuranApiSeeder extends Seeder
{
    public function run(): void
    {
        echo "🔄 Memulai import ayat dari API...\n";

        // 1. Ambil semua surah yang SUDAH ADA di database (dari seeder sebelumnya)
        $surahs = Surah::orderBy('nomor')->get();

        foreach ($surahs as $surah) {
            echo "⏳ Memproses: {$surah->nama} ({$surah->jumlah_ayat} ayat)...\n";

            // 2. Ambil detail ayat (Teks Arab + Terjemahan Indonesia)
            $response = Http::timeout(30)->withoutVerifying()->get("https://api.alquran.cloud/v1/surah/{$surah->nomor}/editions/quran-uthmani,id.indonesian");

            if ($response->ok()) {
                $data = $response->json()['data'];

                $arabicAyahs = $data[0]['ayahs'] ?? [];
                $translationAyahs = $data[1]['ayahs'] ?? [];

                foreach ($arabicAyahs as $index => $arabicAyah) {
                    // Skip Bismillah di awal surah (kecuali Al-Fatihah) agar tidak dobel
                    if ($surah->nomor != 1 && $arabicAyah['numberInSurah'] == 1 && str_contains($arabicAyah['text'], 'بِسْمِ')) {
                        continue;
                    }

                    $translation = $translationAyahs[$index]['text'] ?? 'Terjemahan tidak tersedia';

                    // Generate URL Audio dari everyayah.com (Syaikh Mishary Alafasy)
                    $surahFormatted = str_pad($surah->nomor, 3, '0', STR_PAD_LEFT);
                    $ayatFormatted = str_pad($arabicAyah['numberInSurah'], 3, '0', STR_PAD_LEFT);
                    $audioUrl = "https://everyayah.com/data/Alafasy_128kbps/{$surahFormatted}{$ayatFormatted}.mp3";

                    Ayat::updateOrCreate(
                        [
                            'surah_id' => $surah->id,
                            'nomor_ayat' => $arabicAyah['numberInSurah'],
                        ],
                        [
                            'teks_arab' => $arabicAyah['text'],
                            'transliterasi' => null,
                            'terjemahan' => $translation,
                            'audio_url' => $audioUrl,
                        ]
                    );
                }
            } else {
                echo "❌ Gagal mengambil data untuk Surah {$surah->nama}. Status: " . $response->status() . "\n";
            }
        }

        echo "\n✅ SELESAI! Semua Ayat berhasil diimport.\n";
    }
}
