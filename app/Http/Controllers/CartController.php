<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariation;
use Session;

class CartController extends Controller
{
    public function addCart(Request $request)
    {

        $request->validate([
            'qty' => 'required|numeric|min:1',
        ]);
        // dd($request->input('variation_id'));
        //  dd($request->all());
        $variation = ProductVariation::find($request->variation_id);
        $variationId=$variation->id;
        $quantity = $request->input('qty');
        $variantDetails = $request->variantDetails;

        if($quantity > $variation->stock)
        {
            return back()->withErrors(['stock' => 'The quantity exceeds the available stock of ' . $variation->stock . ' units.']);
        }

        if ($variation->variation_name == 'default' && $variation->product->images->isNotEmpty()) {
            $imagePath=$variation->product->images->first()->image_path;
        }elseif ($variation->images->isNotEmpty()) {
            $imagePath=$variation->images->first()->image_path;

        }else
        {
            $imagePath='frontend/images/no_image.png';
        }
            $cartItem = [
                'id' => $variation->id,
                'name' => $variation->product->name,
                'price' => $variation->price,
                'quantity' => $quantity,
                'image' => $imagePath,
                'variation' => $variation->variation_name,
                'variantDetails' => $variantDetails,
            ];

            $cart = session()->get('cart');

            if (isset($cart[$variationId])) {

                $cart[$variationId]['quantity'] +=$quantity;
            }
            else
            {
                $cart[$variationId] = $cartItem;
            }

            session(['cart'=>$cart]);
            // dd(session()->get('cart'));
        return redirect()->route('shop.products');
    }


    public function destroy(Request $request)
    {
        $variationId = $request->id;
        $cart = session()->get('cart');
        if(isset($cart[$variationId]))
        {
            unset($cart[$variationId]);
            session()->put('cart', $cart);
            return response()->json(['success' => true, 'message' => 'Item deleted successfully.'], 200);
        }
        return response()->json(['success' => false, 'message' => 'Item not found.'], 404);

    }

    public function cartDetail(){
        return view('frontend.cart.cartDetail');
    }
}
