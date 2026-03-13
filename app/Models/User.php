<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'nomor_telepon',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function rumah()
    {
        return $this->hasOne(Rumah::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isWarga()
    {
        return $this->role === 'warga';
    }
}