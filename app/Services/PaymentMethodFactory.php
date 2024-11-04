<?php

namespace App\Services;

class PaymentMethodFactory
{
    /**
     * Create a new class instance.
     */
        public static function create($gatewayType)
        {
            switch ($gatewayType) {
                case 'stripe':
                    return new StripePaymentGateway;
                    break;
                case 'cod':
                    return new CodPaymentGateway;
                    break;
                case 'paypal':
                    return new PayPalPaymentGateway;
                default:
                    throw new \Exception("Unsupported payment gateway: $gatewayType");
                    break;
            }
        }
}
