@extends('frontend.layouts.main')
@section('content')
    <div class="container" style="margin-top: 5em;">
        <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">
                            <div class="wrap-slick3-dots"></div>
                            <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>
                            <div class="slick3 gallery-lb">
                                @if ($product->images)
                                    @foreach ($product->images as $image)
                                        <div class="item-slick3" data-thumb="{{ asset($image->image_path) }}">
                                            <div class="wrap-pic-w pos-relative">
                                                <img src="{{ asset($image->image_path) }}" alt="IMG-PRODUCT">

                                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                    href="{{ asset($image->image_path) }}">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                @if ($product->variations)
                                    @foreach ($product->variations as $variation)
                                        @if ($variation->images)
                                            @foreach ($variation->images as $image)
                                                <div class="item-slick3" data-thumb="{{ asset($image->image_path) }}">
                                                    <div class="wrap-pic-w pos-relative">
                                                        <img src="{{ asset($image->image_path) }}" alt="IMG-PRODUCT">

                                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                            href="{{ asset($image->image_path) }}">
                                                            <i class="fa fa-expand"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </div>


                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                            {{ $product->name }}
                        </h4>

                        <span class="mtext-106 cl2" id="variant-price">
                            ${{ $product->variations[0]->price }}
                        </span>

                        <p class="stext-102 cl3 p-t-23">
                            {!! $product->description !!}
                        </p>
                        <form action="{{ route('addCart') }}" method="POST">
                            @csrf
                            <div class="p-t-33">
                                @php
                                    $uniqueAttributes = [];
                                    $selectedOptions = [];
                                @endphp

                                @foreach ($product->variations as $variation)
                                    @foreach ($variation->attributes as $attributeValue)
                                        @if (!in_array($attributeValue->attribute->name, $uniqueAttributes))
                                            <div class="flex-w flex-r-m p-b-10">
                                                <div class="size-203 flex-c-m respon6">
                                                    {{ $attributeValue->attribute->name }}
                                                </div>
                                                <div class="size-204 respon6-next">
                                                    <div class="rs1-select2 bor8 bg0">
                                                        <select class="js-select2 variant-select" name="attribute[]" data-attribute-name="{{ $attributeValue->attribute->name }}">
                                                            @foreach ($variation->attributes as $value)
                                                                @if ($value->attribute->name == $attributeValue->attribute->name)
                                                                    <option value="{{ $value->id }}"
                                                                        data-price="{{ $variation->price }}"
                                                                        data-variant-name="{{ $variation->variation_name }}">
                                                                        {{ $value->value }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <div class="dropDownSelect2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $uniqueAttributes[] = $attributeValue->attribute->name;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @endforeach
                                    <input id="variationId" type="hidden" name="variation_id"
                                        value="{{ $variation->id }}">

                                <div id="variantDetailsContainer"></div>
                                <label for=""></label>
                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="size-204 flex-w flex-m respon6-next">
                                        <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                            <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                            </div>

                                            <input class="mtext-104 cl3 txt-center num-product" id="num-product"
                                                type="number" name="qty" value="1" max="">

                                            <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                            </div>
                                        </div>
                                        <div style="display: flex; flex-direction: column;">
                                            <div>
                                                <span class="text-success unit-left">(8 units left)</span>
                                            </div>
                                            <div>
                                                <span class="text-danger max-order hidden"></span>
                                                @error('stock')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                            Add to cart
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                            <div class="flex-m bor9 p-r-10 m-r-11">
                                <a href="#"
                                    class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
                                    data-tooltip="Add to Wishlist">
                                    <i class="zmdi zmdi-favorite"></i>
                                </a>
                            </div>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Twitter">
                                <i class="fa fa-twitter"></i>
                            </a>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Google Plus">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const variations = @json($product->variations);

            function updateVariantDetails() {
                const variantDetailsContainer = $('#variantDetailsContainer');
                variantDetailsContainer.empty();

                const selectedOptions = $('.variant-select').map(function() {
                    return $(this).find(':selected').text().trim();
                }).get().join('/');

                const matchingVariation = variations.find(variation => variation.variation_name === selectedOptions);

                if (matchingVariation) {
                    // console.log(matchingVariation)
                    console.log(matchingVariation.id)
                    $('#variant-price').text('$' + matchingVariation.price);
                    $('#num-product').attr('max', matchingVariation.stock);
                    $('.unit-left').text('(' + matchingVariation.stock +  ' in stock'  + ')');
                    $('#variationId').val(matchingVariation.id);

                    // Create hidden inputs for each selected attribute
                    $('.variant-select').each(function() {
                        const attributeName = $(this).data('attribute-name');
                        const selectedValue = $(this).find(':selected').text().trim();


                        if (selectedValue) {
                            const hiddenInput = $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', 'variantDetails[]')
                                .val(attributeName + ':' + selectedValue);


                            variantDetailsContainer.append(hiddenInput);
                        }
                    });
                } else {
                    // Reset to default values if no match is found
                    $('#variant-price').text('Not available');
                    $('#num-product').removeAttr('max');
                    $('#variationId').val('');
                    console.warn('No matching variation found for:', selectedOptions);
                }

                // Log for debugging
                // console.log('Selected Options:', selectedOptions);
                // console.log('Matching Variation:', matchingVariation);
            }


            updateVariantDetails();


            $('.variant-select').on('change', function() {
                updateVariantDetails();
            });
        });
    </script>



@endsection
