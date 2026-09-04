<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UpdateJuzCommand extends Command
{
    protected $signature = 'quran:update-juz';
    protected $description = 'Mengisi kolom juz pada tabel ayats dengan nomor juz yang benar';

    public function handle()
    {
        $this->info('🔄 Memulai pengisian kolom juz...');

        $totalUpdated = 0;

        for ($surahNum = 1; $surahNum <= 114; $surahNum++) {
            $this->info("⏳ Memproses Surah {$surahNum}...");

            // ✅ PERBAIKAN: Tambahkan withoutVerifying() agar tidak error SSL di localhost
            $response = Http::withoutVerifying()->get("https://api.alquran.cloud/v1/surah/{$surahNum}");

            if (!$response->successful()) {
                $this->error("❌ Gagal mengambil data Surah {$surahNum}");
                continue;
            }

            $data = $response->json()['data'];

            foreach ($data['ayahs'] as $ayah) {
                $nomorAyat = $ayah['numberInSurah'];
                $nomorJuz = $ayah['juz']; // API alquran.cloud menyediakan key 'juz'

                // Update kolom juz di tabel ayats
                $updated = DB::table('ayats')
                    ->where('surah_id', $surahNum)
                    ->where('nomor_ayat', $nomorAyat)
                    ->update(['juz' => $nomorJuz]);

                if ($updated) {
                    $totalUpdated++;
                }
            }

            $this->info("✅ Surah {$surahNum} selesai");
        }

        $this->info("\n🎉 SELESAI!");
        $this->info("📊 Total ayat yang berhasil diupdate: {$totalUpdated}");

        return Command::SUCCESS;
    }
}
