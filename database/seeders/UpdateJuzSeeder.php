<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ayat;
use Illuminate\Support\Facades\Http;

class UpdateJuzSeeder extends Seeder
{
    public function run(): void
    {
        echo "🔄 Mengupdate data Juz untuk semua ayat...\n";

        // Ambil semua ayat dari API dengan info juz
        $response = Http::timeout(60)->withoutVerifying()->get('https://api.alquran.cloud/v1/quran/quran-uthmani');

        if ($response->ok()) {
            $data = $response->json()['data']['surahs'];

            foreach ($data as $surahData) {
                $surah = \App\Models\Surah::where('nomor', $surahData['number'])->first();

                if (!$surah) continue;

                foreach ($surahData['ayahs'] as $ayahData) {
                    Ayat::where('surah_id', $surah->id)
                        ->where('nomor_ayat', $ayahData['numberInSurah'])
                        ->update(['juz' => $ayahData['juz']]);
                }

                echo "✅ Surah {$surah->nama} - Juz diupdate\n";
            }

            echo "\n✅ SELESAI! Semua ayat sudah memiliki data Juz.\n";
        } else {
            echo " Gagal mengambil data dari API\n";
        }
    }
}
