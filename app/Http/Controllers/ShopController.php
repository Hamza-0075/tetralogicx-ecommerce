<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        return view('frontend.products.products');
    }

    public function productDetail($id)
    {
        $product = Product::with([
            'images',
            'variations.attributes.attribute',
            'variations.attributes'
        ])->findOrFail($id);



            $data = [];
            $data2 = [];
        // foreach ($product->variations as $key => $variation) {
        //     foreach ($variation->variationAttributes as $variationAttribute) {

        //         $data = $variationAttribute;
        //     }

        // }
        // dd($data);

        // $groupedVariations = [];
        // foreach ($product->variations as $variation) {
        //     foreach ($variation->attributes as $attributeValue) {
        //         // Avoid duplicating attribute values
        //         $groupedVariations[$attributeValue->attribute->name][
        //             $attributeValue->value
        //         ] = $attributeValue->value;
        //     }
        // }
        // dd($groupedVariations);
        // foreach ($product->variations as $key => $variation) {
        //         foreach ($variation->variationAttributes as $variationAttribute) {
        //             foreach ($variationAttribute as $value) {
        //                 $data2=$value;
        //             }
        //             $data = $variationAttribute->attributeValue;
        //         }
        //     }
        // dd($data);
        return view('frontend.products.productDetail', compact('product'));
    }


}
