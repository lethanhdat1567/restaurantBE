<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['fullname','address','user_id','phone_number','email','quantity','time','date'];

    public $timestamps = false;

    public function scopeDeleted($query)
    {
        return $query->whereNull('deleted');
    }
}
