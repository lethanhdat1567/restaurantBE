<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['name','thumbnail','content','deleted'];

    public $timestamps = true;

    public function scopeDeleted($query) {
        return $query->whereNull('deleted');
    }
}
