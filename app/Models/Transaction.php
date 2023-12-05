<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    
    use HasFactory;

    //  protected $table = '';
    protected $guarded = [
        'id'
    ];
       protected $fillable = [
        'berat_sampah',
        'alamat_jemput',
        'status',
        'poin',
        'total_berat',
        'tanggal_jemput',
        'user_id',
        'kategori_id',
    ];

    //user
     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    //kategori
     public function categories(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}