<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentMethodFactory;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\Charge;
use Session;
use stdClass;
use DB;
use Exception;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cartItems = cartData();
        // dd($cartItems);
        return view('frontend.checkout.checkout',compact('cartItems'));
    }


    public function payment(Request $request) {
        // dd($request->all());
        $request->validate([
            'full_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'shippingCountry' => 'required',
            'shippingState' => 'required',
            'shippingCity' => 'required',
            'shippingZipCode' => 'required',
            'pay_method' =>  'required',
            'shippingAdress' => 'required',

        ]);

        $paymentMethod = $request->pay_method;
        $gateway = PaymentMethodFactory::create($paymentMethod);
        // DB::beginTransaction();
        try {

            $order = $this->createOrder($request);
            $result = $gateway->processPayment($order);

            if ($paymentMethod  == 'paypal' && isset($result['redirect_url']))
            {
                session()->put('pending_order_id' , $order->id);
                $sessionOrderid = session()->get('pending_order_id');
                // Log::info("session: $sessionOrderid");
                return redirect($result['redirect_url']);
            }

            $this->finalizeOrder($order, $result, $paymentMethod);
            return redirect()->route('checkout.thankyou');

        } catch (\Throwable $th) {
            $order->delete();
            return response()->json(["message" => "Payment failed: " . $th->getMessage()], 500);
        }
    }


    //Order create function
    private function createOrder($request) {
        $customer = Customer::updateOrCreate(
            ['email' => $request->email],
            [
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' =>  $request->billingAdress,
                'country' => getCountryName($request->billingCountry),
                'state'=> getStateName($request->billingState),
                'city' => getCityName($request->billingCity),
                'postal_code' => $request->billingZipCode,
            ]
        );

        $order = Order::create([
            'customer_id' => $customer->id,
            'total_amount' => totalAmount(),
            'status' => 'pending',
            'shipping_address' => json_encode([
                'address' => $request->shippingAdress,
                'country' => getCountryName($request->shippingCountry),
                'state'=> getStateName($request->shippingState),
                'city' => getCityName($request->shippingCity),
                'zip' => $request->shippingZipCode,
            ]),
        ]);

        $cartItems  = cartData();
        // dd($cartItems);
        $cartItems = cartData();
        if (!is_array($cartItems)) {
            throw new \Exception('Cart data must be an array.');
        }
        foreach ($cartItems as $item) {
            if (is_array($item) && isset($item['quantity'], $item['price'], $item['id'], $item['variantDetails']))
            {
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'product_variation_id'=>$item['id'],
                'variant_details' => json_encode($item['variantDetails']),
            ]);
        }
        // else{
        //     throw new \Exception('Cart item data is not in the expected format.');
        // }
        }
        $order['stripeToken'] = $request->stripeToken;
        return $order;
    }

    //finalize the order
    public function finalizeOrder($order, $result, $paymentMethod){

        // Log::info("result: " . json_encode($result));
        $orderId = $order->id;
        $customerId = $order->customer_id;
        $chargeID = null;
        $status = $paymentMethod === 'cod' ? 'pending' : 'paid';
        $amount = $order->total_amount;
        // dd($result['status']);
        if (isset($result['status']) &&  ($result['status'] === 'success' || $result['status'] === 'COMPLETED')) {
            // dd('In if of status');
            session()->forget('cart');
            if ($paymentMethod === 'paypal') {
                $chargeID = $result['id'] ?? null;
            } elseif ($paymentMethod === 'stripe') {
                $chargeID = $result['charge_id'] ?? null;
            }
            // save the payment details
            $this->savePayments($chargeID, $orderId, $paymentMethod, $amount, $customerId, $status);
            return redirect()->route('checkout.thankyou');

        } else {
            throw new Exception('Payment failed: ' . ($result['message'] ?? 'Unknown error'));
        }
    }

    //save the payment record in payment record
    public function savePayments($chargeID,$orderId,$paymentMethod,$amount,$customerId,$status)
    {
        $payment = Payment::create([
            'order_id' => $orderId,
            'customer_id' => $customerId,
            'charge_id' => $chargeID,
            'payment_method' => $paymentMethod,
            'amount' => $amount,
            'status' => $status,
        ]);

        // if ($payment ) {
        //     $this->sendOrderConrirmMail($orderId);
        // }
        // Mail::to($payment->customer->email)->send(new OrderConfirmationMail($order));

    }

    //Paypal payment success funtion
    public function paymentSuccess(Request $request)
    {
        $token = $request->token;
        $gateway = PaymentMethodFactory::create('paypal');
        $result = $gateway->paymentSuccess($token);
        // Log::info("paypalResponseinCon" . json_encode($result));
        // dd($result);
        $orderid = session()->get('pending_order_id');
        // Log::info("orderid: $orderid");
        if ($result && $orderid) {
                $order = Order::findOrFail($orderid);
                // Log::info("result: " . json_encode($result));
                try {
                    $this->finalizeOrder($order, $result, 'paypal');  // Pass 'id' here
                    session()->forget(['cart', 'pending_order_id']);
                return redirect()->route('checkout.thankyou');

            } catch (\Throwable $th) {
                $order->delete();
                return redirect()->route('checkout')->with('error', 'Payment confirmation failed. ' . $th->getMessage());
            }
        }else{

            return redirect()->route('checkout')->with('error', 'Payment could not be completed.');
        }

    }


    //paypal payment cancel function
    public function paypalCancel()
    {
        $orderid = session()->get('pending_order_id');

        if ($orderid) {
            $order = Order::find($orderid);
            if ($order) {
                $order->delete();
            }
            session()->forget('pending_order_id');
        }

        return redirect()->route('checkout')->with('error', 'Payment was cancelled.');
    }

    public function thankyou(){
        return view('frontend.checkout.thankyou');
    }
}
