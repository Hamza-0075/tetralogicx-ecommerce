<?php

namespace App\Services;

class CODPaymentGateway implements PaymentMethodInterface
{
    /**
     * Create a new class instance.
     */
    public function processPayment($order)
    {
        return [
            'status' => 'success',
            'message' => 'Order placed successfully. Payment will be collected upon delivery.',
            'charge_id' => null,
        ];
    }
}
