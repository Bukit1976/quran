<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHafalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ayah_id',
        'status',
        'tingkat_kelancaran',
        'tanggal_mulai',
        'tanggal_hafal',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_hafal' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ayah()
    {
        return $this->belongsTo(Ayah::class);
    }
}
