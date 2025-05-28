<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AddToCart;

class Products extends Model
{
    use HasFactory;
        protected $fillable = [
        'name',
        'price',
        'image'
    ];

    // Accessor
    public function getNameAttribute($value){
        return ucfirst($value);
    }
    
    public function cart(){
        return $this->hasMany(AddToCart::class,'product_id');
    }
}
