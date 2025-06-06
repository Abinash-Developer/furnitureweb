<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class AddToCart extends Model
{
    use HasFactory;
     protected $table = 'carts';
     protected $fillable = [
        'user_id',
        'product_id',
    ];
    public function product(){
        return $this->belongsTo(Products::class,'product_id');
    }
}
