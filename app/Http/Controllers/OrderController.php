<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MOdels\Order;
use App\Models\OrderItem;
use App\Models\ProductVariation;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate('10');
        return view('backend.order.index',compact('orders'));
    }

    public function ordersDetail($id)
    {
        $order = Order::where('id',$id)->with(['orderItems.variation.product'])->first();
        return view('backend.order.ordersDetail',compact('order'));
    }
}
