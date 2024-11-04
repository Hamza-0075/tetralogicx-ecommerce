<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariation;
use App\Models\Image;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'sku',
        'stock',
        'is_active',
        'compare_price'
    ];

    public function  variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

}
