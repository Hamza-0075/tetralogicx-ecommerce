<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Customer extends Model
{
    protected  $fillable = [
        'full_name',
        'email',
        'phone',
        'address',
        'postal_code',
        'country',
        'state',
        'city',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    use HasFactory;
}
