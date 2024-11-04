<?php

namespace App\Services;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class PayPalPaymentGateway implements PaymentMethodInterface
{
    public function __construct()
    {
        // PayPal service initialization if needed
    }

    public function processPayment($order)
    {

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.success'),
                "cancel_url" => route('paypal.payment.cancel'),
            ],
            "purchase_units" => [
                [
                    "reference_id" => $order->id,
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $order->total_amount
                    ]
                ]
            ]
        ]);

        if (isset($response['id'])) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return [
                        'status' => 'success',
                        'redirect_url' => $link['href'],
                    ];
                }
            }
        }

        return [
            'status' => 'failed',
            'message' => $response['message'] ?? 'Payment creation failed.',
        ];
    }

    public function paymentSuccess($token)
{
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $provider->getAccessToken();

    $result = $provider->capturePaymentOrder($token);
    Log::info("paypalResponse" . json_encode($result));
    if (isset($result['status']) && $result['status'] === 'COMPLETED') {
        $referenceId = $result['purchase_units'][0]['reference_id'] ?? null;
        $paypalId = $result['id'] ?? null;

        if ($referenceId) {
            $order = Order::where('id', $referenceId)->first();
            if ($order) {
                $order->update(['status' => 'pending']);
            }
        }
        return ['status'=>'COMPLETED','id' => $paypalId];
    }

    return false;
}

}


