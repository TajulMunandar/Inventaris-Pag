<?php

namespace App\Models;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function kategoris()
    {
        return $this->belongsTo(Kategori::class, "kategoriId");
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function peminjamen()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
