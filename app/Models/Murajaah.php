<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murajaah extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ayat_id',              // ← SUDAH DIPERBAIKI
        'tanggal_murajaah',
        'status',
    ];

    protected $casts = [
        'tanggal_murajaah' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ayat()          // ← SUDAH DIPERBAIKI
    {
        return $this->belongsTo(Ayat::class);  // ← SUDAH DIPERBAIKI
    }
}
