<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Surah;

class SurahSeeder extends Seeder
{
    public function run(): void
    {
        $surahs = [
            ['nomor' => 1, 'nama' => 'Al-Fatihah', 'nama_arab' => 'الفاتحة', 'jumlah_ayat' => 7],
            ['nomor' => 2, 'nama' => 'Al-Baqarah', 'nama_arab' => 'البقرة', 'jumlah_ayat' => 286],
            ['nomor' => 3, 'nama' => 'Ali Imran', 'nama_arab' => 'آل عمران', 'jumlah_ayat' => 200],
            ['nomor' => 114, 'nama' => 'An-Nas', 'nama_arab' => 'الناس', 'jumlah_ayat' => 6],
        ];

        foreach ($surahs as $surah) {
            Surah::create($surah);
        }
    }
}
