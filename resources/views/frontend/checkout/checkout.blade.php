@push('checkoutCss')
    <style>
        body {
            margin-top: 20px;
            background-color: #f1f3f7;
        }

        .card {
            margin-bottom: 24px;
            -webkit-box-shadow: 0 2px 3px #e4e8f0;
            box-shadow: 0 2px 3px #e4e8f0;
        }

        .card {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid #eff0f2;
            border-radius: 1rem;
        }

        .activity-checkout {
            list-style: none
        }

        .activity-checkout .checkout-icon {
            position: absolute;
            top: -4px;
            left: -24px
        }

        .activity-checkout .checkout-item {
            position: relative;
            padding-bottom: 24px;
            padding-left: 35px;
            border-left: 2px solid #f5f6f8
        }

        .activity-checkout .checkout-item:first-child {
            border-color: #3b76e1
        }

        .activity-checkout .checkout-item:first-child:after {
            background-color: #3b76e1
        }

        .activity-checkout .checkout-item:last-child {
            border-color: transparent
        }

        .activity-checkout .checkout-item.crypto-activity {
            margin-left: 50px
        }

        .activity-checkout .checkout-item .crypto-date {
            position: absolute;
            top: 3px;
            left: -65px
        }



        .avatar-xs {
            height: 1rem;
            width: 1rem
        }

        .avatar-sm {
            height: 2rem;
            width: 2rem
        }

        .avatar {
            height: 3rem;
            width: 3rem
        }

        .avatar-md {
            height: 4rem;
            width: 4rem
        }

        .avatar-lg {
            height: 5rem;
            width: 5rem
        }

        .avatar-xl {
            height: 6rem;
            width: 6rem
        }

        .avatar-title {
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            background-color: #3b76e1;
            color: #fff;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            font-weight: 500;
            height: 100%;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            width: 100%
        }

        .avatar-group {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            padding-left: 8px
        }

        .avatar-group .avatar-group-item {
            margin-left: -8px;
            border: 2px solid #fff;
            border-radius: 50%;
            -webkit-transition: all .2s;
            transition: all .2s
        }

        .avatar-group .avatar-group-item:hover {
            position: relative;
            -webkit-transform: translateY(-2px);
            transform: translateY(-2px)
        }

        .card-radio {
            background-color: #fff;
            border: 2px solid #eff0f2;
            border-radius: .75rem;
            padding: .5rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block
        }

        .card-radio:hover {
            cursor: pointer
        }

        .card-radio-label {
            display: block
        }

        .edit-btn {
            width: 35px;
            height: 35px;
            line-height: 40px;
            text-align: center;
            position: absolute;
            right: 25px;
            margin-top: -50px
        }

        .card-radio-input {
            display: none
        }

        .card-radio-input:checked+.card-radio {
            border-color: #3b76e1 !important
        }


        .font-size-16 {
            font-size: 16px !important;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        a {
            text-decoration: none !important;
        }


        .form-control {
            display: block;
            width: 100%;
            padding: 0.47rem 0.75rem;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
            color: #545965;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #e2e5e8;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.75rem;
            -webkit-transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        }

        .edit-btn {
            width: 35px;
            height: 35px;
            line-height: 40px;
            text-align: center;
            position: absolute;
            right: 25px;
            margin-top: -50px;
        }

        .ribbon {
            position: absolute;
            right: -26px;
            top: 20px;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
            color: #fff;
            font-size: 13px;
            font-weight: 500;
            padding: 1px 22px;
            font-size: 13px;
            font-weight: 500
        }

        <style>

        /* Styles for the payment card container */
        #paymentCard {
            border: 1px solid #ced4da;
            /* Light gray border */
            border-radius: 8px;
            /* Rounded corners */
            padding: 20px;
            /* Space inside the card */
            margin-top: 10px;
            /* Space above the payment card */
            background-color: #f8f9fa;
            /* Light background color */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Soft shadow for depth */
        }

        /* Styles for Stripe Elements */
        .StripeElement {
            border: 1px solid #ced4da;
            /* Default border */
            border-radius: 4px;
            /* Rounded corners */
            padding: 12px;
            /* Padding for the inputs */
            font-size: 16px;
            /* Font size for the text */
            transition: border-color 0.2s;
            /* Smooth transition for border color */
            width: 100%;
            /* Full width */
            box-sizing: border-box;
            /* Include padding and border in width */
        }

        /* Focus state for Stripe Elements */
        .StripeElement:focus {
            outline: none;
            /* Remove default outline */
            border-color: #007bff;
            /* Blue border on focus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            /* Blue shadow on focus */
        }

        /* Styles for invalid state */
        .has-error .StripeElement {
            border: 1px solid #fa755a;
            /* Red border for invalid input */
        }

        /* Error message styling */
        .error {
            display: none;
            /* Initially hidden */
            color: #fa755a;
            /* Red color for error messages */
            margin-top: 10px;
            /* Space above error messages */
        }

        .error.show {
            display: block;
            /* Show error message when applicable */
        }

        /* Button styling */
        .btn {
            background-color: #007bff;
            /* Blue background */
            color: #fff;
            /* White text */
            padding: 10px 20px;
            /* Padding for button */
            border: none;
            /* No border */
            border-radius: 4px;
            /* Rounded corners */
            cursor: pointer;
            /* Pointer cursor on hover */
            transition: background-color 0.3s;
            /* Smooth transition for background */
        }

        .btn:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
        }

        /* Add this CSS to your stylesheet or within a <style> tag in your HTML */
        #billingCountry {
            width: 100%;
            /* Set the width to 100% or any specific value */
            max-height: 200px;
            /* Set a maximum height for the dropdown */
            overflow-y: auto;
            /* Enable vertical scrolling */
            overflow-x: hidden;
            /* Hide horizontal scrolling */
        }
    </style>

    </style>
@endpush
@extends('frontend.layouts.main')
@section('content')
    <div class="container mt-5">
        @if (Session::has('error'))
            <div class="alert alert-danger text-center">

                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>

                <p>{{ Session::get('error') }}</p>

            </div>
        @endif

        <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"
            data-cc-on-file="false"
            data-stripe-publishable-key="pk_test_51QDmRlJdpy3ojdUlQLA0sr2qqRgg2NYzoOgjqtgFZohLSGnHHg76HRhlUASK8n2gITsrlbksvTqQ7KGBwEEpY2Sw00KhWu3b5M"
            id="payment-form">
            @csrf
            <div class="row">
                <div class="col-xl-7">

                </div>
                <div class="col-xl-7">
                    <div class="card">

                        <div class="card-body">
                            Personal Info
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="billing-name">Full Name</label>
                                        <input name="full_name" type="text" class="form-control" id="billing-name"
                                            placeholder="Enter name">
                                            @error('full_name')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="billing-email-address">Email
                                            Address</label>
                                        <input type="email" name="email" class="form-control" id="billing-email-address"
                                            placeholder="Enter email">
                                            @error('email')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="billing-phone">Phone</label>
                                        <input name="phone" type="text" class="form-control" id="billing-phone"
                                            placeholder="Enter Phone no." />
                                            @error('phone')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            <ol class="activity-checkout mb-0 px-4 mt-3">
                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-receipt text-white font-size-20"></i>
                                        </div>
                                    </div>

                                    <div class="feed-item-list">
                                        <div>
                                            <h5 class="font-size-16 mb-1">Billing Info</h5>
                                            {{-- <p class="text-muted text-truncate mb-4">Sed ut perspiciatis unde omnis iste</p> --}}
                                            <div class="mb-3">

                                                {{-- <div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="billing-address">Address</label>
                                                            <textarea name="billingAdress" class="form-control" id="billing-address" rows="3" placeholder="Enter full address"></textarea>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="mb-4 mb-lg-0">
                                                                    <label class="form-label">Country</label>
                                                                    <select name="billingCountry" class="form-control form-select"
                                                                        title="Country">
                                                                        <option value="0">Select Country</option>
                                                                        <option value="AF">Afghanistan</option>
                                                                        <option value="AL">Albania</option>
                                                                        <option value="DZ">Algeria</option>
                                                                        <option value="AS">American Samoa</option>
                                                                        <option value="AD">Andorra</option>
                                                                        <option value="AO">Angola</option>
                                                                        <option value="AI">Anguilla</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <div class="mb-4 mb-lg-0">
                                                                    <label class="form-label"
                                                                        for="billing-city">City</label>
                                                                    <input name="billingCity" type="text" class="form-control"
                                                                        id="billing-city" placeholder="Enter City">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <div class="mb-0">
                                                                    <label class="form-label" for="zip-code">Zip / Postal
                                                                        code</label>
                                                                    <input  name="billingZipCode" type="text" class="form-control"
                                                                        id="zip-code" placeholder="Enter Postal code">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                <div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="billing-address">Address</label>
                                                        <textarea name="billingAdress" class="form-control" id="billing-address" rows="3"
                                                            placeholder="Enter full address"></textarea>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="mb-4 mb-lg-0">
                                                                <label class="form-label"
                                                                    for="billingCountry">Country</label>
                                                                <select name="billingCountry" id="billingCountry"
                                                                    class="form-control form-select text-dark"
                                                                    title="Country">
                                                                    <option value="0">Select Country</option>
                                                                    <!-- Options will be populated dynamically via AJAX -->
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="mb-4 mb-lg-0">
                                                                <label class="form-label" for="billingState">State</label>
                                                                <select name="billingState" id="billingState"
                                                                    class="form-control form-select" title="State">
                                                                    <option value="0">Select State</option>
                                                                    <!-- Options will be populated dynamically via AJAX -->
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="mb-4 mb-lg-0">
                                                                <label class="form-label" for="billingCity">City</label>
                                                                <select name="billingCity" id="billingCity"
                                                                    class="form-control form-select" title="City">
                                                                    <option value="0">Select City</option>
                                                                    <!-- Options will be populated dynamically via AJAX -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-lg-12">
                                                            <div class="mb-0">
                                                                <label class="form-label" for="billingZipCode">Zip /
                                                                    Postal
                                                                    code</label>
                                                                <input type="text" class="form-control"
                                                                    name="billingZipCode" id="billingZipCode"
                                                                    placeholder="Enter Postal code">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-truck text-white font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="feed-item-list">
                                        <div>
                                            <h5 class="font-size-16 mb-1">Shipping Info</h5>
                                            {{-- <p class="text-muted text-truncate mb-4">Neque porro quisquam est</p> --}}
                                            <div class="mb-3">
                                                <div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="shippingAdress">Address</label>
                                                        <textarea name="shippingAdress" class="form-control" id="shippingAdress" rows="3"
                                                            placeholder="Enter full address"></textarea>
                                                            @error('shippingAdress')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="mb-4 mb-lg-0">
                                                                <label class="form-label" for="shippingCountry">Country</label>
                                                                <select name="shippingCountry" id="shippingCountry"
                                                                    class="form-control form-select text-dark"
                                                                    title="Country">
                                                                    <option value="" disabled selected>Select Country</option>
                                                                    <!-- Options will be populated dynamically via AJAX -->
                                                                </select>
                                                                @error('shippingCountry')
                                                                <span class="text-danger">Select the country.</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="mb-4 mb-lg-0">
                                                                <label class="form-label" for="shippingState">State</label>
                                                                <select name="shippingState" id="shippingState"
                                                                    class="form-control form-select" title="State">
                                                                    <option value="" disabled selected>Select State</option>
                                                                    <!-- Options will be populated dynamically via AJAX -->
                                                                </select>
                                                                @error('shippingState')
                                                                <span class="text-danger">Select the state.</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="mb-4 mb-lg-0">
                                                                <label class="form-label" for="shippingCity">City</label>
                                                                <select name="shippingCity" id="shippingCity"
                                                                    class="form-control form-select" title="State">
                                                                    <option value="" disabled selected>Select State</option>
                                                                    <!-- Options will be populated dynamically via AJAX -->
                                                                </select>
                                                                @error('shippingCity')
                                                                <span class="text-danger">Select the city.</span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        {{-- <div class="col-lg-4">
                                                            <div class="mb-0">
                                                                <label class="form-label" for="shippingZipCode">Zip /
                                                                    Postal
                                                                    code</label>
                                                                <input type="text" class="form-control"
                                                                    name="shippingZipCode" id="shippingZipCode"
                                                                    placeholder="Enter Postal code">
                                                                    @error('shippingZipCode')
                                                                        <span class="text-danger">Zip /
                                                                            Postal
                                                                            code filed is required.</span>
                                                                    @enderror
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-lg-12">
                                                            <div class="mb-0">
                                                                <label class="form-label" for="shippingZipCodee">Zip /
                                                                    Postal
                                                                    code</label>
                                                                <input type="text" class="form-control"
                                                                    name="shippingZipCode" id="shippingZipCode"
                                                                    placeholder="Enter Postal code">
                                                                    @error('shippingZipCode')
                                                                    <span class="text-danger">Zip /
                                                                        Postal
                                                                        code filed is required.</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-wallet-alt text-white font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="feed-item-list">
                                        <div>
                                            <h5 class="font-size-16 mb-1">Payment Info</h5>
                                            <p class="text-muted text-truncate mb-4">Select your payment method.</p>
                                        </div>
                                        <div>
                                            <h5 class="font-size-14 mb-3">Payment method :</h5>
                                            <div class="row">
                                                <div class="col-lg-3 col-sm-6">
                                                    <div data-bs-toggle="collapse">
                                                        <label class="card-radio-label">
                                                            <input type="radio" name="pay_method" value="stripe"
                                                                id="stripe" class="card-radio-input">
                                                            <span class="card-radio py-3 text-center text-truncate">
                                                                <i class="bx bx-credit-card d-block h2 mb-3"></i>
                                                                Stripe
                                                            </span>
                                                        </label>
                                                        @error('pay_method')
                                                            <span class="text-danger">Please select your payment method.</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-sm-6">
                                                    <div>
                                                        <label class="card-radio-label">
                                                            <input type="radio" name="pay_method" id="paypal"
                                                                value="paypal" class="card-radio-input">
                                                            <span class="card-radio py-3 text-center text-truncate">
                                                                <i class="bx bxl-paypal d-block h2 mb-3"></i>
                                                                Paypal
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-sm-6">
                                                    <div>
                                                        <label class="card-radio-label">
                                                            <input type="radio" name="pay_method" id="cod"
                                                                class="card-radio-input" checked="" value="cod">

                                                            <span class="card-radio py-3 text-center text-truncate">
                                                                <i class="bx bx-money d-block h2 mb-3"></i>
                                                                <span>Cash on Delivery</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div id="paymentCard">

                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col">
                            <a href="ecommerce-products.html" class="btn btn-link text-muted">
                                <i class="mdi mdi-arrow-left me-1"></i> Continue Shopping </a>
                        </div> <!-- end col -->
                        <div class="col-4" id="codBtn">
                            <div class="text-end mt-2 mt-sm-0">
                                <button type="submit" class="btn btn-dark">Proceed</button>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row-->
                </div>
                <div class="col-xl-5">
                    <div class="card checkout-order-summary">
                        <div class="card-body">
                            <div class="p-3 bg-light mb-3">
                                <h5 class="font-size-16 mb-0">Order Summary <span class="float-end ms-2">#MN0124</span>
                                </h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 table-nowrap">
                                    <thead>

                                        <tr>
                                            <th class="border-top-0" style="width: 110px;" scope="col">Product</th>
                                            <th class="border-top-0" scope="col">Product Desc</th>
                                            <th class="border-top-0" scope="col">Price</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @php
                                            $subTotal = 0;
                                        @endphp
                                        @foreach ($cartItems as $cartItem)
                                            @php
                                                $Itemtotal = $cartItem['price'] * $cartItem['quantity'];
                                                $subTotal += $Itemtotal;
                                            @endphp
                                            <tr>
                                                <th scope="row"><img
                                                        src="{{ $cartItem['image'] ? asset($cartItem['image']) : 'https://www.bootdey.com/image/280x280/FF00FF/000000' }}"
                                                        alt="product-img" title="product-img" class="avatar-lg rounded">
                                                </th>
                                                <td>
                                                    <h5 class="font-size-16 text-truncate"><a href="#"
                                                            class="text-dark">{{ $cartItem['name'] }}</a></h5>
                                                    <p class="text-muted mb-0">
                                                        <i class="bx bxs-star text-warning"></i>
                                                        <i class="bx bxs-star text-warning"></i>
                                                        <i class="bx bxs-star text-warning"></i>
                                                        <i class="bx bxs-star text-warning"></i>
                                                    </p>
                                                    <p class="text-muted mb-0 mt-1">$ {{ $cartItem['price'] }} x
                                                        {{ $cartItem['quantity'] }}</p>
                                                </td>
                                                <td>$ {{ $Itemtotal }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2">
                                                <h5 class="font-size-14 m-0">Sub Total :</h5>
                                            </td>
                                            <td>
                                                $ {{ $subTotal }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <h5 class="font-size-14 m-0">Discount :</h5>
                                            </td>
                                            <td>
                                                - $ 0
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2">
                                                <h5 class="font-size-14 m-0">Shipping Charge :</h5>
                                            </td>
                                            <td>
                                                $ 0
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <h5 class="font-size-14 m-0">Estimated Tax :</h5>
                                            </td>
                                            <td>
                                                $ 0
                                            </td>
                                        </tr>

                                        <tr class="bg-light">
                                            <td colspan="2">
                                                <h5 class="font-size-14 m-0">Total:</h5>
                                            </td>
                                            <td>
                                                $ {{ $subTotal }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript"></script>
<script>
    $(document).ready(function() {
        const stripe = Stripe(
            'pk_test_51QDmRlJdpy3ojdUlQLA0sr2qqRgg2NYzoOgjqtgFZohLSGnHHg76HRhlUASK8n2gITsrlbksvTqQ7KGBwEEpY2Sw00KhWu3b5M'
            );
        const elements = stripe.elements();
        let card;

        // Handle payment method selection
        $(document).on('click', 'input[name="pay_method"]', function() {
            if (card) {
                card.destroy();
                card = null;
            }

            if ($(this).attr('id') === 'stripe') {
                // Create and mount the card element
                card = elements.create('card', {
                    style: {
                        base: {
                            color: "#32325d",
                            fontFamily: "'Helvetica Neue', Helvetica, sans-serif",
                            fontSize: "16px",
                            "::placeholder": {
                                color: "#AAAAAA"
                            },
                        },
                        invalid: {
                            color: "#fa755a",
                            iconColor: "#fa755a"
                        }
                    }
                });
                card.mount('#paymentCard');
            } else {
                $('#paymentCard').empty();
            }
        });

        // Form submission handling
        $('form.require-validation').on('submit', function(e) {
            e.preventDefault();
            const $form = $(this);
            const selectedMethod = $('input[name="pay_method"]:checked').val();

            // Handle Stripe payment token creation
            if (selectedMethod === 'stripe') {
                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        // Display error to the user
                        $('.error').removeClass('hide').find('.alert').text(result.error
                            .message);
                    } else {
                        // Append token to form and submit
                        $form.append("<input type='hidden' name='stripeToken' value='" + result
                            .token.id + "'/>");
                        $form.get(0).submit();
                    }
                });
            } else if (selectedMethod === 'cod') {
                $form.get(0).submit();
            } else if (selectedMethod === 'paypal') {
                $form.get(0).submit();
            }
        });
        $.ajax({
            url: `/api/get-countries`,
            success: function(countries) {
                $('#billingCountry').empty().append(new Option('Select Country', '')).find("option:first").attr('disabled', true);
                $('#shippingCountry').empty().append(new Option('Select Country', '')).find("option:first").attr('disabled', true);
                countries.forEach(country => {
                    $('#billingCountry').append(new Option(country.name, country.id));
                    $('#shippingCountry').append(new Option(country.name, country.id));
                });
            },
            error: function() {
                alert("Could not load countries.");
            }
        });
        $('#billingCountry').on('change', function() {
            let countryId = $(this).val();
            console.log(countryId);
            $.ajax({
                url: `/api/get-states/${countryId}`,
                success: function(states) {
                    $('#billingState').empty().append(new Option('Select State', '')).find("option:first").attr('disabled', true);
                    states.forEach(state => {
                        $('#billingState').append(new Option(state.name, state.id));
                    });
                }
            });
        });

        $('#billingState').on('change', function() {
            let stateId = $(this).val();
            $.ajax({
                url: `/api/get-cities/${stateId}`,
                success: function(cities) {
                    $('#billingCity').empty().append(new Option('Select City', '')).find("option:first").attr('disabled', true);
                    cities.forEach(city => {
                        $('#billingCity').append(new Option(city.name, city.id));
                    });
                }
            });
        });


        $('#shippingCountry').on('change', function() {
            let countryId = $(this).val();
            console.log(countryId);
            $.ajax({
                url: `/api/get-states/${countryId}`,
                success: function(states) {
                    $('#shippingState').empty().append(new Option('Select State', '0'));
                    states.forEach(state => {
                        $('#shippingState').append(new Option(state.name, state.id));
                    });
                }
            });
        });


        $('#shippingState').on('change', function() {
            let stateId = $(this).val();
            $.ajax({
                url: `/api/get-cities/${stateId}`,
                success: function(cities) {
                    $('#shippingCity').empty().append(new Option('Select City', '0'));
                    cities.forEach(city => {
                        $('#shippingCity').append(new Option(city.name, city.id));
                    });
                }
            });
        });

    });
</script>
