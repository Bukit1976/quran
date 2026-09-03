<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    use HasFactory;

    protected $table = 'surahs';

    protected $fillable = [
        'nomor',
        'nama',
        'nama_arab',
        'jumlah_ayat',
    ];

    public function ayats()
    {
        return $this->hasMany(Ayat::class, 'surah_id', 'id')->orderBy('nomor_ayat', 'asc');
    }
}
