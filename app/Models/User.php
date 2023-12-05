<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Roles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
 
class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'users';
    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'username',
        'password',
        'alamat',
        'hp',
        'role_id'
    ];

    public function role()
    {
        return $this->belongsTo(Roles::class,'role_id');
    }

     public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }


}