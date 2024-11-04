<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\ProductVariation;
class OrderItem extends Model
{
    protected  $fillable = [
        'order_id',
        'variant_details',
        'product_variation_id',
        'quantity',
        'price',

    ];
    use HasFactory;

    public function order(){
        return $this->belongsTo(Order::class,"order_id");
    }

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class,"product_variation_id");
    }

}
