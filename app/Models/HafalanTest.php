<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HafalanTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ayat_id',
        'jenis_tes',
        'skor',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ayat()
    {
        return $this->belongsTo(Ayat::class);
    }
}
