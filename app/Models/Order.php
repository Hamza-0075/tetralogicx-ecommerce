<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\orderItems;
use App\Models\Customer;
use App\Models\Payment;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'total_amount',
        'status',
        'shipping_address',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    use HasFactory;
}
