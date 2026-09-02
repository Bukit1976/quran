<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetHafalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'target_ayat_per_hari',
        'target_surah',
        'tanggal_mulai',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
