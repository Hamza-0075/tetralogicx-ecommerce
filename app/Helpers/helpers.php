<?php
use App\Models\Category;
use App\Models\Product;

if(!function_exists('cartdata')){
    function cartdata()
    {
        $cart=session()->get('cart');
        if ($cart) {
            return array_values($cart);
        }
        else{
            return [];
        }
    }
}

if(!function_exists('categories')){
    function categories()
    {
        $categories = Category::limit(5)->get();
        return $categories ?  $categories : [];
    }
}

if(!function_exists('products'))
{
    function products()
    {
        $products = Product::where('is_active', 1)->with('categories')->get();
        return $products  ? $products : [];
    }

}

if(!function_exists('totalAmount')){
    function totalAmount()
    {
        $cart=session()->get('cart');
        if ($cart) {
            $totalAmount=0;
            foreach ($cart as $key => $item) {
                $totalAmount += $item['quantity'] * $item['price'];
            }
            return $totalAmount;
        }
        else{
            return 0;
        }
    }
}

if(!function_exists('cartdataObject')){
    function cartdataObject()
    {
        $cart=session()->get('cart');
        if ($cart) {
            return array_values($cart);
        }
        else{
            return [];
        }
    }

}


if(!function_exists('getCountryName')){
    function getCountryName($countryId)
    {
        $countryName = DB::table('countries')->where('id', $countryId)->pluck('name')->first();
        return $countryName;
    }

}

if(!function_exists('getStateName')){
    function getStateName($stateId)
    {
        $StateName = DB::table('states')->where('id', $stateId)->pluck('name')->first();
        return $StateName;
    }

}

if(!function_exists('getCityName')){
    function getCityName($cityId)
    {
        $cityName = DB::table('cities')->where('id', $cityId)->pluck('name')->first();
        return $cityName;
    }

}
