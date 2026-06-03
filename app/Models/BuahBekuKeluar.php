<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuahBekuKeluar extends Model
{
    protected $table = 'buah_beku_keluar';

    protected $fillable = [
        'buah_beku_id',
        'jumlah',
        'tanggal_keluar',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_keluar' => 'date',
        ];
    }

    public function product()
    {
        return $this->belongsTo(BuahBeku::class, 'buah_beku_id');
    }
}
