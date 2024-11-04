@extends('layouts.main')

@section('content')
<div class="wrapper">
    <div class="container">
        <h1 class="text-center mb-4">Order Details</h1>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <div class="text-start">
                    <h5>Order #{{ $order->id }}</h5>
                </div>
                <div class="text-end">
                    Date: {{ $order->created_at->format('d/m/y h:i A') }}
                </div>
            </div>
            <div class="card-body">
                <h5>Customer Information</h5>
                <p><strong>Name:</strong> {{ $order->customer->full_name }}</p>
                <p><strong>Email:</strong> {{ $order->customer->email }}</p>
                <p><strong>Phone:</strong> {{ $order->customer->phone }}</p>
                <p><strong>Shipping Address:</strong>
                    @foreach (json_decode($order->shipping_address) as $value)
                        {{ $value }}
                    @endforeach
                </p>
                <p><strong>Order Status:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                <p><strong>Payment Method:</strong> {{ $order->payment ? ucfirst($order->payment->payment_method) : 'Not Paid' }}</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Order Items</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Variant</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->variation->product->name ?? '' }}</td>
                            <td>
                                @foreach (json_decode($item->variant_details) as $key => $value)
                                   {{ $value }}<br>
                                @endforeach
                            </td>                                                        <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Payment Details</h5>
            </div>
            <div class="card-body">
                @if($order->payment)
                <p><strong>Payment ID:</strong> {{ $order->payment->id }}</p>
                <p><strong>Payment Amount:</strong> ${{ number_format($order->payment->amount, 2) }}</p>
                <p><strong>Payment Status:</strong> {{ ucfirst($order->payment->status) }}</p>
                <p><strong>Transaction ID:</strong> {{$order->payment->charge_id ?? 'Not available (Cash amount)' }}</p>
                @else
                <p>No payment details available.</p>
                @endif
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('orders') }}" class="btn btn-primary">Back to Orders</a>
        </div>
    </div>
</div>
@endsection
