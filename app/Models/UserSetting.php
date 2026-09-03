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

    public static function getOrCreate($userId)
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

    // Helper untuk label tampilan
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
        return match ($this->qori_murattal) {
            'abdul_basit' => 'Abdul Basit',
            'maher_almuaiqly' => 'Maher Al Muaiqly',
            'saad_ghamdi' => 'Saad Al Ghamdi',
            'ahmad_alajamy' => 'Ahmad Al Ajamy',
            default => 'Mishary Rashid'
        };
    }

    public function getAksiPopupLabel()
    {
        return match ($this->aksi_popup_ayat) {
            'ditekan_lama' => 'Ditekan Lama',
            default => 'Diklik'
        };
    }
}
