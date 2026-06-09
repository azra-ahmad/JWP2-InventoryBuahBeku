<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuahBeku extends Model
{
    protected $table = 'buah_beku';

    protected $fillable = [
        'kategori_id',
        'kode_produk',
        'nama_produk',
        'stok',
        'satuan',
        'harga',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
        ];
    }

    public function category()
    {
        return $this->belongsTo(KategoriBuahBeku::class, 'kategori_id');
    }

    public function stockIns()
    {
        return $this->hasMany(BuahBekuMasuk::class, 'buah_beku_id');
    }

    public function stockOuts()
    {
        return $this->hasMany(BuahBekuKeluar::class, 'buah_beku_id');
    }

    public function getStatusAttribute(): string
    {
        if ($this->stok <= 0) {
            return 'Habis';
        }

        if ($this->stok < 10) {
            return 'Stok Rendah';
        }

        return 'Tersedia';
    }

}
