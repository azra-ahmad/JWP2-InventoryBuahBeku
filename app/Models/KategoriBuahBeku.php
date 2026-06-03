<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBuahBeku extends Model
{
    protected $table = 'kategori_buah_beku';

    protected $fillable = [
        'nama_kategori',
    ];

    public function products()
    {
        return $this->hasMany(BuahBeku::class, 'kategori_id');
    }
}
