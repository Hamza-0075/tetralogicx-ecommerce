<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
            <span class="mtext-103 cl2">
                Your Cart

            </span>

            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>
        @php
            $cart = cartdata();
        @endphp
        <div class="header-cart-content flex-w js-pscroll">
            <ul class="header-cart-wrapitem w-full">
                {{-- Cart script --}}
            </ul>

            <div class="w-full">
                <div class="header-cart-total w-full p-tb-40">
                    Total: $0.00
                </div>

                <div class="header-cart-buttons flex-w w-full">
                    <a href="{{route('cart.detail')}}"
                        class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                        View Cart
                    </a>

                    <a href="{{route('checkout')}}"
                        class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                        Check Out
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

    @push('script')
<script>
    var cartData = @json($cart);

    $(document).ready(function() {
        showCart();
        showCartDetail();
    });

    function deleteCartItem(id) {
        $.ajax({
            url: "{{ route('deleteCart') }}",
            method: 'POST',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    cartData = cartData.filter(item => item.id !== id);
                    updateCartDisplay();
                } else {
                    console.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    function updateCartDisplay() {
        showCart();
        showCartDetail();
        updateCartTotal();
    }

    function showCart() {
        $('.header-cart-wrapitem').empty();
        var countItem = 0;
        if (cartData && cartData.length > 0) {
            countItem = cartData.length;
            $.each(cartData, function(index, item) {
                var cartItemHTML = `
                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img" onclick="deleteCartItem(${item.id})">
                            <img src="{{asset('${item.image}')}}" alt="IMG">
                        </div>
                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                ${item.name}
                                ${item.variation}
                            </a>
                            <span class="header-cart-item-info">
                                ${item.quantity} x $${item.price}
                            </span>
                        </div>
                    </li>
                `;
                $('.header-cart-wrapitem').append(cartItemHTML);
            });
            $('.countItem').attr('data-notify', countItem);
        } else {
            $('.header-cart-wrapitem').append('<li>No items in cart</li>');
            $('.countItem').attr('data-notify', countItem);

        }
    }

    function showCartDetail() {
        $('.cartDetail').empty();
        if (cartData && cartData.length > 0) {
            var cartDetailHTML = '';
            $.each(cartData, function(index, item) {
                cartDetailHTML += `
                    <tr class="table_row">
                        <td class="column-1">
                            <div class="how-itemcart1" onclick="deleteCartItem(${item.id})">
                                <img src="{{asset('${item.image}')}}" alt="IMG" >
                            </div>
                        </td>
                        <td class="column-2">${item.name} ${item.variation}</td>
                        <td class="column-3">$${item.price}</td>
                        <td class="column-4">
                            <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" onclick="changeQuantity(${item.id}, -1)">
                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                </div>
                                <input class="mtext-104 cl3 txt-center num-product" type="number" value="${item.quantity}" onchange="updateQuantity(${item.id}, this.value)">
                                <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" onclick="changeQuantity(${item.id}, 1)">
                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                </div>
                            </div>
                        </td>
                        <td class="column-5">$${(item.quantity * item.price).toFixed(2)}</td>
                    </tr>`;
            });
            $('.cartDetail').append(cartDetailHTML);
            updateCartTotal();
        } else {
            $('.cartDetail').append('<tr><td colspan="5" class="text-center">No items in cart</td></tr>');

        }
    }

    function updateCartTotal() {
        var total = 0;
        $.each(cartData, function(index, item) {
            total += item.quantity * item.price;
        });
        $('.header-cart-total').text('Total: $' + total.toFixed(2));
        $('.subtotal').text('$' + total.toFixed(2));
    }

    function changeQuantity(id, delta) {
        var item = cartData.find(i => i.id === id);
        if (item) {
            item.quantity = Math.max(1, item.quantity + delta);
            updateCartDisplay();
        }
    }

    function updateQuantity(id, newQuantity) {
        var item = cartData.find(i => i.id === id);
        if (item) {
            item.quantity = Math.max(1, parseInt(newQuantity) || 1);
            updateCartDisplay();
        }
    }
</script>
@endpush


