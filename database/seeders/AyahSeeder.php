<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ayah;

class AyahSeeder extends Seeder
{
    public function run(): void
    {
        $ayahs = [
            [
                'surah_id' => 1,
                'nomor_ayat' => 1,
                'arab' => 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ',
                'latin' => 'Bismillahirrahmanirrahim',
                'terjemahan' => 'Dengan nama Allah Yang Maha Pengasih lagi Maha Penyayang.',
                'audio_url' => null,
            ],
            [
                'surah_id' => 1,
                'nomor_ayat' => 2,
                'arab' => 'الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ',
                'latin' => 'Alhamdu lillahi rabbil \'alamin',
                'terjemahan' => 'Segala puji bagi Allah, Tuhan seluruh alam.',
                'audio_url' => null,
            ],
            [
                'surah_id' => 1,
                'nomor_ayat' => 3,
                'arab' => 'الرَّحْمَٰنِ الرَّحِيمِ',
                'latin' => 'Ar-Rahmanir-Rahim',
                'terjemahan' => 'Yang Maha Pengasih lagi Maha Penyayang.',
                'audio_url' => null,
            ],
            [
                'surah_id' => 1,
                'nomor_ayat' => 4,
                'arab' => 'مَالِكِ يَوْمِ الدِّينِ',
                'latin' => 'Maliki yawmid-din',
                'terjemahan' => 'Pemilik hari pembalasan.',
                'audio_url' => null,
            ],
            [
                'surah_id' => 1,
                'nomor_ayat' => 5,
                'arab' => 'إِيَّاكَ نَعْبُدُ وَإِيَّاكَ نَسْتَعِينُ',
                'latin' => 'Iyyaka na\'budu wa iyyaka nasta\'in',
                'terjemahan' => 'Hanya kepada Engkaulah kami menyembah dan hanya kepada Engkaulah kami mohon pertolongan.',
                'audio_url' => null,
            ],
            [
                'surah_id' => 1,
                'nomor_ayat' => 6,
                'arab' => 'اهْدِنَا الصِّرَاطَ الْمُسْتَقِيمَ',
                'latin' => 'Ihdinas-siratal-mustaqim',
                'terjemahan' => 'Tunjukilah kami jalan yang lurus.',
                'audio_url' => null,
            ],
            [
                'surah_id' => 1,
                'nomor_ayat' => 7,
                'arab' => 'صِرَاطَ الَّذِينَ أَنْعَمْتَ عَلَيْهِمْ غَيْرِ الْمَغْضُوبِ عَلَيْهِمْ وَلَا الضَّالِّينَ',
                'latin' => 'Siratal-ladzina an\'amta \'alaihim ghairil-maghdubi \'alaihim wa lad-dhallin',
                'terjemahan' => '(Yaitu) jalan orang-orang yang telah Engkau beri nikmat kepada mereka; bukan (jalan) mereka yang dimurkai, dan bukan (pula jalan) mereka yang sesat.',
                'audio_url' => null,
            ],
        ];

        foreach ($ayahs as $ayah) {
            Ayah::create($ayah);
        }
    }
}
