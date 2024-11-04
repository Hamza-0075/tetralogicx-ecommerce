<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Image;
use App\Models\AttributeValue;
use App\Models\OrderItem;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'sku', 'price', 'stock', 'compare_price','variation_name'];

    public function product()
    {
       return $this->belongsTo(Product::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(AttributeValue::class,'product_variation_attributes');
    }


    public function images()
    {
        return $this->hasMany(Image::class, 'product_variation_id');
    }

    public function variationAttributes()
{
    return $this->hasMany(ProductVariationAttribute::class);
}


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


}
