<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'tb_user';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'alamat',
        'tanggal_lahir',
        'foto', // <-- ini penting agar update berhasil
    ];
}
