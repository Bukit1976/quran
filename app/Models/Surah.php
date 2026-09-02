<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor',
        'nama',
        'nama_arab',
        'jumlah_ayat',
    ];

    public function ayats()
    {
        return $this->hasMany(Ayat::class);
    }
}
