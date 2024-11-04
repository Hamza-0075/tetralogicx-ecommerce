<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Charge;
use Session;

class StripePaymentGateway implements PaymentMethodInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function processPayment($order)
    {
        try {
            $charge = Charge::create([
                "amount" => $order->total_amount * 100,
                "currency" => "usd",
                "source" => $order->stripeToken,
                "description" => "Payment for order ID: {$order->id}.",
            ]);

            return [
                'status' => 'success',
                'message' => 'Payment processed successfully with Stripe.',
                'charge_id' => $charge->id,
            ];

        } catch (\Throwable $e) {
            \Log::error('Stripe Payment Error:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'order_id' => $order->id,
            ]);

            return [
                'status' => 'error',
                'message' => 'Payment failed: ' . $e->getMessage(),
            ];
        }
    }
}
