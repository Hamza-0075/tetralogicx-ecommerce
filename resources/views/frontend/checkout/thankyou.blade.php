@push('checkoutCss')
<style>
    .thank-you-page {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 50px 20px;
        color: #333;
        background: #f9f9f9;
        animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .thank-you-page .icon {
        font-size: 80px;
        color: #4caf50;
        animation: bounceIn 1s ease-out;
    }

    @keyframes bounceIn {
        0% { transform: scale(0.8); opacity: 0; }
        60% { transform: scale(1.1); opacity: 1; }
        100% { transform: scale(1); }
    }

    .thank-you-page h1 {
        font-size: 36px;
        font-weight: bold;
        margin-top: 20px;
        color: #4caf50;
        animation: slideInTop 1.2s ease-out;
    }

    @keyframes slideInTop {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .thank-you-page p {
        font-size: 18px;
        color: #555;
        max-width: 600px;
        animation: fadeIn 1.4s ease-out;
    }

    .thank-you-page .order-summary {
        width: 100%;
        max-width: 700px;
        margin-top: 40px;
        padding: 30px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
        animation: slideInBottom 1.5s ease-out;
    }

    @keyframes slideInBottom {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .order-summary h2 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .order-summary .details {
        font-size: 16px;
        color: #555;
    }

    .order-summary .details .label {
        font-weight: bold;
    }

    .social-icons {
        margin-top: 30px;
        animation: fadeIn 1.6s ease-out;
    }

    .social-icons a {
        color: #555;
        font-size: 24px;
        margin: 0 10px;
        transition: color 0.3s, transform 0.3s;
    }

    .social-icons a:hover {
        color: #4caf50;
        transform: translateY(-5px);
    }
</style>
@endpush

@extends('frontend.layouts.main')
@section('content')

    <div class="thank-you-page" style="min-height: 100%;">
        <div class="icon">
            <i class="fa fa-check-circle"></i>
        </div>
        <h1>Thank You for Your Order!</h1>
        <p>Your order has been successfully placed. We’re processing it and will send you an update once it’s on the way!</p>

        {{-- <div class="order-summary">
            <h2>Order Summary</h2>
            <div class="details">
                <p><span class="label">Order Number:</span> #</p>
                <p><span class="label">Order Date:</span> </p>
                <p><span class="label">Estimated Delivery:</span> </p>
                <p><span class="label">Shipping To:</span> </p>
            </div>
        </div> --}}

        <div class="social-icons">
            <p>Stay connected with us:</p>
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
        </div>
    </div>

@endsection
