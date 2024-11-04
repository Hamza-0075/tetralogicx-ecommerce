<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\MOdels\Order;
use App\MOdels\Customer;

class Payment extends Model
{
    protected $fillable = [
       'order_id',
       'customer_id',
       'charge_id',
       'amount',
       'payment_method',
       'status',
       'comment',
    ];
    use HasFactory;


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTO(Customer::class);
    }
}
