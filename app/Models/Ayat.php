<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ayat extends Model
{
    use HasFactory;

    protected $table = 'ayats';

    protected $fillable = [
        'surah_id',
        'juz',
        'nomor_ayat',
        'teks_arab',
        'transliterasi',
        'terjemahan',
        'audio_url',
    ];

    public function surah()
    {
        return $this->belongsTo(Surah::class, 'surah_id', 'id');
    }

    public function hafalans()
    {
        return $this->hasMany(Hafalan::class);
    }
}
