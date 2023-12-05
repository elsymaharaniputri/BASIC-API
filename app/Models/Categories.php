<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model
{
    use HasFactory;
      protected $fillable = [
        'kategori_sampah','harga_sampah'
    ];

     //transaksi
     public function transactions(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}