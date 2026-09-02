<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
{
    use HasFactory;

    protected $table = 'user_settings';

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
        'kata_demi_kata',
        'qori_murattal',
        'aksi_popup_ayat',
        'biarkan_layar_menyala',
        'layar_penuh',
    ];

    protected $casts = [
        'tajwid_berwarna' => 'boolean',
        'aktifkan_latin' => 'boolean',
        'aktifkan_terjemahan' => 'boolean',
        'kata_demi_kata' => 'boolean',
        'biarkan_layar_menyala' => 'boolean',
        'layar_penuh' => 'boolean',
        'ukuran_font_arabic' => 'integer',
        'ukuran_font_latin' => 'integer',
        'ukuran_font_terjemahan' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Helper: Get default settings
    public static function getDefaultSettings(): array
    {
        return [
            'tema_aplikasi' => 'mengikuti_perangkat',
            'mode_baca_quran' => 'selalu_tanya',
            'jenis_penulisan_arabic' => 'indopak',
            'tajwid_berwarna' => true,
            'ukuran_font_arabic' => 18,
            'aktifkan_latin' => true,
            'ukuran_font_latin' => 16,
            'aktifkan_terjemahan' => true,
            'penerjemah' => 'kemenag-ri',
            'ukuran_font_terjemahan' => 16,
            'kata_demi_kata' => false,
            'qori_murattal' => 'mishary_rashid',
            'aksi_popup_ayat' => 'diklik',
            'biarkan_layar_menyala' => true,
            'layar_penuh' => false,
        ];
    }

    // Get or create settings for user
    public static function getOrCreate(int $userId): self
    {
        return self::firstOrCreate(
            ['user_id' => $userId],
            self::getDefaultSettings()
        );
    }

    // Label helpers
    public function getTemaLabel(): string
    {
        return match ($this->tema_aplikasi) {
            'mengikuti_perangkat' => 'Mengikuti Perangkat',
            'gelap' => 'Gelap',
            'terang' => 'Terang',
            default => 'Mengikuti Perangkat',
        };
    }

    public function getModeBacaLabel(): string
    {
        return match ($this->mode_baca_quran) {
            'selalu_tanya' => 'Selalu Tanya',
            'otomatis_mushaf' => 'Otomatis Mushaf',
            'otomatis_hafalan' => 'Otomatis Hafalan',
            default => 'Selalu Tanya',
        };
    }

    public function getJenisPenulisanLabel(): string
    {
        return match ($this->jenis_penulisan_arabic) {
            'indopak' => 'IndoPak (Asia)',
            'utsmani' => 'Utsmani (Arab Saudi)',
            'imlaei' => 'Imlaei (Mesir)',
            default => 'IndoPak (Asia)',
        };
    }

    public function getPenerjemahLabel(): string
    {
        return match ($this->penerjemah) {
            'kemenag-ri' => 'Kemenag-RI',
            'quraish-shihab' => 'Quraish Shihab',
            'buya-hamka' => 'Buya Hamka',
            'jalaluddin' => 'Jalaluddin',
            default => 'Kemenag-RI',
        };
    }

    public function getQoriLabel(): string
    {
        $qoris = [
            'mishary_rashid' => 'Mishary Rashid',
            'abdul_basit' => 'Abdul Basit',
            'maher_muaiqly' => 'Maher Al Muaiqly',
            'saad_ghamdi' => 'Saad Al Ghamdi',
            'ahmed_ajamy' => 'Ahmed Al Ajamy',
            'yasser_dosari' => 'Yasser Al Dosari',
        ];
        return $qoris[$this->qori_murattal] ?? 'Mishary Rashid';
    }

    public function getAksiPopupLabel(): string
    {
        return match ($this->aksi_popup_ayat) {
            'diklik' => 'Diklik',
            'ditahan' => 'Ditahan (Long Press)',
            default => 'Diklik',
        };
    }
}
