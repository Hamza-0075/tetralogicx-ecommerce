<?php

namespace App\Services;

interface PaymentMethodInterface
{
    /**
     * Create a new class instance.
     * @param
     * @return
     */

    public function processPayment($order);
}
