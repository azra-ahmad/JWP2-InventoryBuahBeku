<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuahBekuMasuk extends Model
{
    protected $table = 'buah_beku_masuk';

    protected $fillable = [
        'buah_beku_id',
        'jumlah',
        'tanggal_masuk',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_masuk' => 'date',
        ];
    }

    public function product()
    {
        return $this->belongsTo(BuahBeku::class, 'buah_beku_id');
    }
}
