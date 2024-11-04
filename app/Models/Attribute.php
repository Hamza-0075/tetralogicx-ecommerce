<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeValue;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function variations()
{
    return $this->belongsToMany(ProductVariation::class, 'product_variation_attributes');
}
}
