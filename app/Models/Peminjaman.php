<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, "userId");
    }

    public function barangs()
    {
        return $this->belongsTo(Barang::class, "barangId");
    }
}
