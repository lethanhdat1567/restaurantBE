<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory,HasApiTokens;

    protected $table = 'users';
    protected $fillable = [
        'fullname','email','phone_number','address','password','role_id','avatar',
    ];

    public $timestamps = true;
}
