<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'tema_aplikasi',
        'mode_baca_quran',
        'jenis_penulisan_arabic',
        'tajwid_berwarna',
        'ukuran_font_arabic',
        'aktifkan_latin',
        'ukuran_font_latin',
        'aktifkan_terjemahan',
        'penerjemah',
        'ukuran_font_terjemahan',
        'qori_murattal',
        'aksi_popup_ayat',
        'biarkan_layar_menyala',
        'layar_penuh',
        'kata_demi_kata',
    ];

    public static function getOrCreate(int $userId)
    {
        return self::firstOrCreate(
            ['user_id' => $userId],
            [
                'tema_aplikasi' => 'mengikuti_perangkat',
                'mode_baca_quran' => 'selalu_tanya',
                'jenis_penulisan_arabic' => 'indopak',
                'tajwid_berwarna' => true,
                'ukuran_font_arabic' => 18,
                'aktifkan_latin' => false,
                'ukuran_font_latin' => 16,
                'aktifkan_terjemahan' => true,
                'penerjemah' => 'kemenag-ri',
                'ukuran_font_terjemahan' => 16,
                'qori_murattal' => 'mishary_rashid',
                'aksi_popup_ayat' => 'diklik',
                'biarkan_layar_menyala' => false,
                'layar_penuh' => false,
                'kata_demi_kata' => false,
            ]
        );
    }

    public function getTemaLabel()
    {
        return match ($this->tema_aplikasi) {
            'gelap' => 'Gelap',
            'terang' => 'Terang',
            default => 'Mengikuti Perangkat'
        };
    }

    public function getModeBacaLabel()
    {
        return match ($this->mode_baca_quran) {
            'otomatis_madani' => 'Otomatis (Madani)',
            'otomatis_indopak' => 'Otomatis (IndoPak)',
            default => 'Selalu Tanya'
        };
    }

    public function getJenisPenulisanLabel()
    {
        return match ($this->jenis_penulisan_arabic) {
            'utsmani' => 'Utsmani (Mushaf Madinah)',
            'standar' => 'Standar',
            default => 'IndoPak (Asia)'
        };
    }

    public function getPenerjemahLabel()
    {
        return match ($this->penerjemah) {
            'quraish-shihab' => 'Quraish Shihab',
            'buya-hamka' => 'Buya Hamka',
            'jalalain' => 'Jalalain',
            default => 'Kemenag-RI'
        };
    }

    public function getQoriLabel()
    {
        return match (trim($this->qori_murattal)) {
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
            default => 'Mishary Rashid Alafasy'
        };
    }

    public function getAksiPopupLabel()
    {
        return match ($this->aksi_popup_ayat) {
            'ditekan_lama' => 'Ditekan Lama',
            default => 'Diklik'
        };
    }

    public function getQoriBaseUrl()
    {
        $qori = trim($this->qori_murattal);
        return match ($qori) {
            // ️ PERHATIAN: Nama folder HARUS persis seperti di everyayah.com
            'mishary_rashid' => 'https://everyayah.com/data/Alafasy_128kbps/',
            'abdul_basit_murattal' => 'https://everyayah.com/data/Abdul_Basit_Murattal_128kbps/',
            'abdul_basit_mujawwad' => 'https://everyayah.com/data/Abdul_Basit_Mujawwad_128kbps/',
            'maher_almuaiqly' => 'https://everyayah.com/data/Maher_AlMuaiqly_64kbps/',
            'saad_ghamdi' => 'https://everyayah.com/data/Saad_Al-Ghamadi_128kbps/',
            'ahmad_alajamy' => 'https://everyayah.com/data/Ahmad_ibn_Ali_al-Ajamy_128kbps/',
            'husary' => 'https://everyayah.com/data/Husary_128kbps/',
            'minshawi_murattal' => 'https://everyayah.com/data/Minshawy_128kbps/',
            'minshawi_mujawwad' => 'https://everyayah.com/data/Minshawy_Mujawwad_128kbps/',
            'muhammad_ayyoub' => 'https://everyayah.com/data/Muhammad_Ayyoub_128kbps/',
            'muhammad_jibreel' => 'https://everyayah.com/data/Muhammad_Jibreel_128kbps/',
            'sudais' => 'https://everyayah.com/data/Abdurrahmaan_As-Sudais_192kbps/',
            'abu_bakr_ash_shaatree' => 'https://everyayah.com/data/Abu_Bakr_Ash-Shaatree_128kbps/',
            'hani_ar_rifai' => 'https://everyayah.com/data/Hani_Ar-Rifai_192kbps/',
            'mahmood_ali_albanna' => 'https://everyayah.com/data/Mahmood_Ali_AlBanna_128kbps/',
            'muhammad_saleh_almunajjid' => 'https://everyayah.com/data/Muhammad_Saleh_AlMunajjid_128kbps/',
            'saud_ash_shuraim' => 'https://everyayah.com/data/Saud_Ash-Shuraim_128kbps/',
            'nasser_alqatami' => 'https://everyayah.com/data/Nasser_Alqatami_128kbps/',
            'yasser_ad_dossari' => 'https://everyayah.com/data/Yasser_Ad-Dossari_128kbps/',
            'khalid_aljileel' => 'https://everyayah.com/data/Khalid_AlJileel_128kbps/',
            'bandar_baleela' => 'https://everyayah.com/data/Bandar_Baleela_128kbps/',
            'ali_alhudhaifi' => 'https://everyayah.com/data/Ali_AlHudhaifi_128kbps/',
            'fares_abbad' => 'https://everyayah.com/data/Fares_Abbad_128kbps/',
            'salah_bukhatir' => 'https://everyayah.com/data/Salah_Bukhatir_128kbps/',
            'ibrahim_akhdar' => 'https://everyayah.com/data/Ibrahim_Akhdar_32kbps/',
            'ahmed_neana' => 'https://everyayah.com/data/Ahmed_Neana_128kbps/',
            default => 'https://everyayah.com/data/Alafasy_128kbps/',
        };
    }
}
