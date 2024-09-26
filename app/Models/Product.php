<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'title','price','discount','thumbnail','description','category_id','total','content'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'id');
    }
    public $timestamps = true;

    public function scopeDeleted($query) {
        return $query->whereNull('deleted');
    }
}
