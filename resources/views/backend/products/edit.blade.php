<style>
    .image-upload {
        position: relative;
        display: inline-block;
    }

    .image-upload-label {
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    .image-upload-label i {
        font-size: 24px;
        /* Size of the upload icon */
        margin-right: 5px;
        /* Space between icon and label */
    }

    .image-preview {
        width: 50px;
        height: auto;
        margin-top: 5px;
        display: block;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>
@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Add Product</h1>
        </div>
        <div id="response-message" class="mt-3"></div>
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div>
                    {{ Session::get('success') }}
                </div>
            </div>
        @endif

        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data"
            id="add-product-form">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product Information</h3>
                        </div>
                        <div class="card-body">
                            <!-- Product Name -->
                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" placeholder="Enter product name" value="{{ $product->name }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea id="summernote" class="form-control @error('description') is-invalid @enderror" name="description"
                                    rows="4" placeholder="Enter product description">{{ $product->description }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Base Price -->
                            <div id="priceSection">
                                @if ($product->variations && $product->variations->isNotEmpty())
                                    @foreach ($product->variations as $variation)
                                        @if ($variation->variation_name == 'default')
                                            <div class="mb-3">
                                                <input type="hidden" name="variation_id[]"  value="{{ $variation->id }}">
                                                <label class="form-label">Base Price</label>
                                                <input type="number"
                                                    class="form-control base-data @error('price') is-invalid @enderror"
                                                    name="price" step="0.01" placeholder="Enter base price"
                                                    value="{{ $variation->price ?? '' }}">
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Compare Price</label>
                                                <input type="number"
                                                    class="form-control base-data @error('compare_price') is-invalid @enderror"
                                                    name="compare_price" step="0.01" placeholder="Enter compare price"
                                                    value="{{ $variation->compare_price ?? '' }}">
                                                @error('compare_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Base SKU</label>
                                                <input type="text"
                                                    class="form-control base-data @error('sku') is-invalid @enderror"
                                                    name="sku" placeholder="Enter base SKU"
                                                    value="{{ $variation->sku ?? '' }}">
                                                @error('sku')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="mb-3">
                                        <label class="form-label">Base Price</label>
                                        <input type="number"
                                            class="form-control base-data @error('price') is-invalid @enderror"
                                            name="price" step="0.01" placeholder="Enter base price" value="">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Compare Price</label>
                                        <input type="number"
                                            class="form-control base-data @error('compare_price') is-invalid @enderror"
                                            name="compare_price" step="0.01" placeholder="Enter compare price"
                                            value="">
                                        @error('compare_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Base SKU</label>
                                        <input type="text"
                                            class="form-control base-data @error('sku') is-invalid @enderror" name="sku"
                                            placeholder="Enter base SKU" value="">
                                        @error('sku')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                            </div>



                            <!-- Product Images Section -->
                            <div class="wrapper">
                                <div class="drop">
                                    <div class="cont">
                                        <i class="fa fa-cloud-upload"></i>
                                        <div class="tit">Drag & Drop</div>
                                        <div class="desc">your files to Assets, or</div>
                                        <div class="browse">click here to browse</div>
                                    </div>
                                    <output id="list"></output>
                                    <input id="files" multiple="true" name="files[]" type="file" accept="image/*" />
                                </div>

                                <!-- Display existing images -->
                                <div class="existing-images">
                                    @foreach ($product->images as $image)
                                        <div class="image-thumbnail" data-image-id="{{ $image->id }}">
                                            <img src="{{ asset($image->image_path) }}" alt="Image" width="150"
                                                height="150">
                                            <div class="remove-icon" title="Remove Image"
                                                onclick="removeProductImage({{ $image->id }})">Remove</div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <!-- Variations Section -->
                            <div class="accordion mt-3" id="variationsAccordion">
                                <div class="accordion-item bg-white">
                                    <h2 class="accordion-header" id="headingVariations">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseVariations" aria-expanded="false"
                                            aria-controls="collapseVariations">
                                            Product Variations <span><small> (optional)</small></span>
                                        </button>
                                    </h2>
                                    <div id="collapseVariations" class="accordion-collapse collapse"
                                        aria-labelledby="headingVariations" data-bs-parent="#variationsAccordion">
                                        <div class="accordion-body bg-white">
                                            <div id="option-fields">
                                                @php
                                                    // Initialize the grouped variations array
                                                    $groupedVariations = [];
                                                    foreach ($product->variations as $variation) {
                                                        foreach ($variation->attributes as $attributeValue) {
                                                            // Avoid duplicating attribute values
                                                            $groupedVariations[$attributeValue->attribute->name][
                                                                $attributeValue->value
                                                            ] = $attributeValue->value;
                                                        }
                                                    }

                                                    $variationsitem = $product->variations;
                                                @endphp
                                                @foreach ($groupedVariations as $optionName => $values)
                                                    <div class="option-row mb-3">
                                                        <label class="form-label">Option Name</label>
                                                        <input type="text" class="form-control option-name"
                                                            placeholder="e.g., Size" value="{{ $optionName }}"
                                                            required>
                                                        <label class="form-label mt-2">Values</label>
                                                        <div class="value-rows">
                                                            @foreach ($values as $value)
                                                                <input type="text"
                                                                    class="form-control value-input mb-2"
                                                                    placeholder="e.g., {{ $value }}"
                                                                    value="{{ $value }}" required>
                                                            @endforeach
                                                        </div>
                                                        <button type="button" class="btn btn-secondary add-value">Add
                                                            Value</button>
                                                        <button type="button"
                                                            class="btn btn-danger remove-option mt-2">Remove
                                                            Option</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-primary mt-3" id="add-option">Add
                                                Option</button>
                                            <hr>
                                            <!-- Generated Variants Table -->
                                            <h4>Generated Variants</h4>
                                            <div id="variant-list" class="mt-3">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Variant</th>
                                                            <th></th>
                                                            <th>Image</th>
                                                            <th>Price</th>
                                                            <th>Stock</th>
                                                            <th>Compare Price</th>
                                                            <th>SKU</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="variant-table-body">
                                                        @if ($product->variations->isNotEmpty())
                                                            @foreach ($product->variations as $variation)
                                                                @if ($variation->variation_name !== 'default')
                                                                    <tr>
                                                                        <td>
                                                                            {{$variation->variation_name}}
                                                                        </td>
                                                                        <td>
                                                                            @if ($variation->id)
                                                                            <input type="hidden" name="variation_id[]" value="{{$variation->id}} ">
                                                                            @endif
                                                                            <input type="hidden" class="variation-name" name="variation-name" value="{{$variation->variation_name}}">
                                                                        </td>
                                                                        <td>
                                                                            <div class="image-upload"
                                                                                style="display: flex; align-items: center;">
                                                                                @php
                                                                                    $image = $variation->images->first();
                                                                                @endphp
                                                                                <img id="image-preview-{{ $variation->id }}"
                                                                                    class="image-preview"
                                                                                    src="{{ $image ? asset($image->image_path) : '' }}"
                                                                                    alt="No Image"
                                                                                    style="{{ $image ? '' : 'display: none;' }} width: 50px; height: 50px; object-fit: cover; margin-right: 10px;" />

                                                                                <label
                                                                                    for="variant-image-{{ $variation->id }}"
                                                                                    class="image-upload-label"
                                                                                    style="cursor: pointer;">
                                                                                    <i class="fa fa-upload"
                                                                                        id="upload-icon-{{ $variation->id }}"></i>
                                                                                </label>

                                                                                <input type="file"
                                                                                    id="variant-image-{{ $variation->id }}"
                                                                                    class="form-control variant-image"
                                                                                    accept="image/*"
                                                                                    style="display: none;"
                                                                                    onchange="previewImage(event, {{ $variation->id }})">
                                                                            </div>

                                                                        </td>
                                                                        <td>
                                                                            <input type="number"
                                                                                class="form-control variant-price"
                                                                                step="0.01" placeholder="Price"
                                                                                value="{{ $variation->price }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="number"
                                                                                class="form-control variant-stock"
                                                                                step="1" placeholder="Stock"
                                                                                value="{{ $variation->stock }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="number"
                                                                                class="form-control variant-compare-price"
                                                                                step="0.01" placeholder="Compare Price"
                                                                                value="{{ $variation->compare_price }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text"
                                                                                class="form-control variant-sku"
                                                                                value="{{ $variation->sku }}"
                                                                                placeholder="SKU">
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </tbody>


                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Product Status -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product Status</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status">
                                    <option value="1" {{ $product->is_active == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $product->is_active == 0 ? 'selected' : '' }}>Draft</option>
                                </select>

                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Categories</h3>
                        </div>
                        <div class="card-body">
                            @foreach ($categories as $category)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="categories[]"
                                        value="{{ $category->id }}" id="category_{{ $category->id }}"
                                        {{ $product->categories->contains($category->id) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="category_{{ $category->id }}">{{ $category->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

    <script>
        function toggleBaseDataDivs(values = []) {
            if (values.length > 0) {
                $('.base-data').closest('.mb-3').remove();
            } else {
                if ($('.base-data').length === 0) {
                    // Check if variationData is defined and set default values if it's not
                    const basePrice = typeof variationData !== 'undefined' && variationData.price ? variationData.price : '';
                    const comparePrice = typeof variationData !== 'undefined' && variationData.compare_price ? variationData
                        .compare_price : '';
                    const sku = typeof variationData !== 'undefined' && variationData.sku ? variationData.sku : '';
                    const id = typeof variationData !== 'undefined' && variationData.id;

                    const baseDataHtml = `
                <div class="mb-3">
                    <input type="hidden" name="variation_id[]" value="${id}">
                    <label class="form-label">Base Price</label>
                    <input type="number" class="form-control base-data" name="price" value="${basePrice}" step="0.01" placeholder="Enter base price">
                </div>
                <div class="mb-3">
                    <label class="form-label">Compare Price</label>
                    <input type="number" class="form-control base-data" name="compare_price" value="${comparePrice}" step="0.01" placeholder="Enter compare price">
                </div>
                <div class="mb-3">
                    <label class="form-label">Base SKU</label>
                    <input type="text" class="form-control base-data" name="sku" value="${sku}" placeholder="Enter base SKU">
                </div>
            `;

                    $('#priceSection').append(baseDataHtml);
                }
            }
        }



        function previewImage(event, variationId) {
            var input = event.target;
            var preview = document.getElementById('image-preview-' + variationId);

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Show the preview
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }

        function removeExistingImage(imageId) {
            // Send an AJAX request to the server to delete the image
            fetch(`/images/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Remove the image from the DOM
                        document.querySelector(`[data-image-id="${imageId}"]`).remove();
                    } else {
                        alert("Failed to delete the image.");
                    }
                })
                .catch(error => {
                    console.error("Error removing image:", error);
                });
        }
        $(document).ready(function() {
            function previewImage(event, variationId) {
                var input = event.target;
                var preview = document.getElementById('image-preview-' + variationId);

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block'; // Show the preview
                    };

                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.src = '';
                    preview.style.display = 'none'; // Hide the preview if no file selected
                }
            }

            var variationsdata = {{ Js::from($variationsitem) }}
            // console.log(variationsdata)
            variationsdata.forEach(function(entry) {
                var variationenty = entry.variation
                // console.log(entry.sku);
            });
            $('#add-product-form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Create a FormData object
                var formData = new FormData(this); // 'this' refers to the form element

                // Collect variation data
                const variants = [];
                $('#variant-table-body tr').each(function(index) {
                    const variant = {
                        variation_id: $(this).data('variation_id'),
                        variationName: $(this).find('.variation-name').val(),
                        price: $(this).find('.variant-price').val(),
                        stock: $(this).find('.variant-stock').val(),
                        compare_price: $(this).find('.variant-compare-price').val(),
                        sku: $(this).find('.variant-sku').val(),
                    };

                    // Validate the variant fields before adding to the array
                    // if (variant.price === '' || variant.stock === '' || variant.sku === '') {
                    //     alert('Please fill out all required fields for each variant.');
                    //     return false;
                    // }
                    variants.push(variant);
                    const variantImage = $(this).find('.variant-image')[0]?.files[0];
                    if (variantImage) {
                        // Append the image file to the FormData with a unique key
                        formData.append(`variant_images[${index}]`,
                            variantImage); // 'index' is now defined correctly
                    }

                    // Log each variant to the console
                    // console.log(variant);
                });


                // Log the full variants array
                console.log('Variants:', variants);

                // Append variants data to FormData
                if (variants.length > 0) {

                    formData.append('variants', JSON.stringify(variants));
                }

                // Collect options and values
                const options = [];
                $('.option-row').each(function() {
                    const optionName = $(this).find('.option-name').val().trim();
                    const values = $(this).find('.value-input').map(function() {
                        return $(this).val().trim();
                    }).get().filter(value => value !== '');

                    if (optionName !== '' && values.length > 0) {
                        options.push({
                            name: optionName,
                            values
                        });
                    }
                });

                // Append options data to FormData


                    formData.append('options', JSON.stringify(options));


                // Handle file uploads
                // const files = $('#files')[0].files;
                // for (let i = 0; i < files.length; i++) {
                //     formData.append('files[]', files[i]);
                // }

                // AJAX request to submit the form
                $.ajax({
                    url: $(this).attr('action'), // The URL to submit to
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        // $('#response-message').html('<div class="alert alert-success">' +
                        //     response.message + '</div>');
                        // $('#add-product-form')[0].reset();
                        // $('#variant-table-body').empty();
                        window.location.href = "{{ route('product.list') }}";

                    },
                    error: function(xhr) {
                        // Handle error response
                        $('#response-message').html('<div class="alert alert-danger">' + xhr
                            .responseJSON.message + '</div>');
                    }
                });
            });
            // Remove image functionality (keep this)
            $(document).on('click', '.remove-icon', function() {
                $(this).closest('.image-thumbnail').remove();
            });
            // generateVariants()
            // Handle file selection for drag and drop
            // Handle file selection for new uploads
            function handleFileSelect(evt) {
                var files = evt.target.files;

                for (var i = 0, f; f = files[i]; i++) {
                    if (!f.type.match('image.*')) {
                        continue;
                    }

                    var reader = new FileReader();

                    reader.onload = (function(theFile) {
                        return function(e) {
                            var span = document.createElement('span');
                            span.classList.add('image-thumbnail');
                            span.innerHTML = [
                                '<img class="thumb" src="', e.target.result,
                                '" title="', escape(theFile.name), '"/>',
                                '<div class="remove-icon" title="Remove Image" style="cursor: pointer;">',
                                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">',
                                '<path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm0 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14z"/>',
                                '<path d="M4.293 4.293a1 1 0 0 1 1.414 0L8 7.586l2.293-2.293a1 1 0 0 1 1.414 1.414L9.414 9l2.293 2.293a1 1 0 0 1-1.414 1.414L8 10.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L6.586 9 4.293 6.707a1 1 0 0 1 0-1.414z"/>',
                                '</svg></div>'
                            ].join('');
                            document.getElementById('list').insertBefore(span, null);
                        };
                    })(f);

                    reader.readAsDataURL(f);
                }
            }

            // Handle removal of existing images

            // Add event listener for file input
            // document.getElementById('files').addEventListener('change', handleFileSelect, false);


            // Bind file input change event
            $('#files').change(handleFileSelect);

            // Hide error messages on initial load
            $('.option-error, .value-error').hide();

            // Add new option field
            $('#add-option').on('click', function() {
                toggleBaseDataDivs();

                // Get all the option rows
                const optionRows = $('.option-row');
                console.log("options: ", optionRows);

                // Check if there are any option rows
                if (optionRows.length > 0) {
                    // Get the value of the last option name
                    const lastOptionName = optionRows.last().find('.option-name').val();

                    if (!lastOptionName || lastOptionName.trim() === '') {
                        // Add error styling and display the error message
                        optionRows.last().find('.option-name').addClass('is-invalid');
                        optionRows.last().find('.option-error').show();
                        return;
                    }
                }
                addNewOptionRow();
            });

            function addNewOptionRow() {
                let optionRow = `
            <div class="option-row mb-3">
                <label class="form-label">Option Name</label>
                <input type="text" class="form-control option-name" placeholder="e.g., Size">
                <span class="text-danger option-error" style="display:none;">Option name is required.</span>
                <label class="form-label mt-2">Values</label>
                <div class="value-rows">
                    <input type="text" class="form-control value-input mb-2" placeholder="e.g., Small">
                    <span class="text-danger value-error" style="display:none;">Value is required.</span>
                </div>
                <button type="button" class="btn btn-secondary add-value">Add Value</button>
                <button type="button" class="btn btn-danger remove-option mt-2">Remove Option</button>
            </div>`;
                $('#option-fields').append(optionRow);
            }

            // Add value field for option
            $(document).on('click', '.add-value', function() {
                const lastValueInput = $(this).siblings('.value-rows').find('.value-input').last();
                if (lastValueInput.val().trim() === '') {
                    lastValueInput.addClass('is-invalid');
                    $(this).siblings('.value-error').show();
                    return;
                }
                lastValueInput.removeClass('is-invalid');
                $(this).siblings('.value-error').hide();

                // Add a new value input
                $(this).siblings('.value-rows').append(
                    '<input type="text" class="form-control value-input mb-2" placeholder="e.g., Medium">'
                );
            });

            // Remove option field
            $(document).on('click', '.remove-option', function() {

                $(this).closest('.option-row').remove();
                generateVariants()
                toggleBaseDataDivs();


                // Re-generate variants after removing an option

                // If there are no option rows left, allow adding a new option
                if ($('.option-row').length === 0) {
                    displayVariants();
                    toggleBaseDataDivs(values = 0)
                }
            });


            // Generate variants
            function generateVariants() {

                const optionRows = $('.option-row');
                // console.log(optionRows)
                let allValues = [];

                optionRows.each(function() {
                    const optionName = $(this).find('.option-name').val().trim();
                    const values = $(this).find('.value-input').map(function() {
                        return $(this).val().trim();
                    }).get().filter(value => value !== '');
                    toggleBaseDataDivs(values);
                    // Validate option name and values for duplicates
                    if (optionName === '' || allValues.some(v => v.name === optionName)) {
                        $(this).find('.option-name').addClass('is-invalid');
                        $(this).find('.option-error').show();
                        return;
                    } else {
                        $(this).find('.option-name').removeClass('is-invalid');
                        $(this).find('.option-error').hide();
                    }

                    // Check for duplicate values
                    const valueSet = new Set();
                    for (const value of values) {
                        if (valueSet.has(value)) {
                            $(this).find('.value-input').addClass('is-invalid');
                            $(this).find('.value-error').show();
                            return;
                        }
                        valueSet.add(value);
                    }

                    // Store option values
                    if (values.length > 0) {
                        allValues.push({
                            name: optionName,
                            values
                        });
                    }
                });

                // Generate combinations
                let variants = generateCombinations(allValues);
                displayVariants(variants);
            }

            // Function to generate combinations
            function generateCombinations(allValues) {
                const combinations = [];

                function combine(current, index) {
                    if (index === allValues.length) {
                        combinations.push(current);
                        return;
                    }
                    const {
                        name,
                        values
                    } = allValues[index];
                    values.forEach(value => {
                        combine([...current, {
                            [name]: value
                        }], index + 1);
                    });
                }
                combine([], 0);
                return combinations.map(variant => {
                    return Object.assign({}, ...variant);
                });
            }

            function displayVariants(variants = []) {
                const variantTableBody = $('#variant-table-body');
                variantTableBody.empty();

                if (variants.length === 0) {
                    variantTableBody.append(
                        '<tr><td colspan="6" class="text-center">No variants available.</td></tr>');
                    return;
                }

                variants.forEach(variant => {
                    const variantName = Object.entries(variant).map(([key, value]) => `${value}`).join('/');
                    // console.log(variantName)
                    if (variantName !== '') {
                        // console.log(variantName)
                        const row = $('<tr></tr>');
                        row.append(`<td>${variantName}</td>`);
                        row.append(`
                     <td class="hidden">
                    <input type="hidden" class="form-control variation-name" value="${variantName}">
                    </td>
                <td>
                    <input type="file" class="form-control variant-image"   accept="image/*">
                </td>
                <td>
                    <input type="number" class="form-control variant-price" value="" step="0.01" placeholder="Price">
                </td>
                <td>
                    <input type="number" class="form-control variant-stock" placeholder="Stock">
                </td>
                <td>
                    <input type="number" class="form-control variant-compare-price" step="0.01" placeholder="Compare Price">
                </td>
                <td>

                    <input type="text" class="form-control variant-sku"  placeholder="SKU">
                </td>
            `);
                        variantTableBody.append(row);
                    }
                });

                // Event listener for the first price input to fill others
                $('.variant-price').first().on('input', function() {
                    const firstPrice = $(this).val();
                    $('.variant-price').val(firstPrice);
                });

                // Event listener for stock and compare price to fill others
                $('.variant-stock').first().on('input', function() {
                    const firstStock = $(this).val();
                    $('.variant-stock').val(firstStock);
                });

                $('.variant-compare-price').first().on('input', function() {
                    const firstComparePrice = $(this).val();
                    $('.variant-compare-price').val(firstComparePrice);
                });
            }

            // Trigger variant generation when options are changed
            $(document).on('input', '.option-name, .value-input', function() {

                generateVariants();
            });


            // Handle drag and drop for the image upload area
            var dropArea = $(".drop");

            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.on(eventName, preventDefaults, false);
                $(document).on(eventName, preventDefaults, false); // Add to document
            });

            // Highlight drop area when file is dragged over it
            dropArea.on('dragenter', function() {
                $(this).css({
                    "border": "4px dashed #09f",
                    "background": "rgba(0, 153, 255, .05)"
                });
                $(".cont").css({
                    "color": "#09f"
                });
            }).on('dragleave dragend drop', function() {
                $(this).css({
                    "border": "3px dashed #DADFE3",
                    "background": "transparent"
                });
                $(".cont").css({
                    "color": "#8E9BA2"
                });
            });

            // Handle dropped files
            dropArea.on('drop', function(e) {
                var files = e.originalEvent.dataTransfer.files;
                handleFileSelect({
                    target: {
                        files: files
                    }
                }); // Reuse the existing file handling function
            });

            // Remove image functionality
            $(document).on('click', '.remove-image', function() {
                $(this).closest('.image-thumbnail').remove();
            });

            // Prevent default behavior (Prevent file from being opened)
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

        });


        function removeProductImage(id){
            var imageId = id;
            $.ajax({
                url: "{{ route('image.delete', ':id') }}".replace(':id', imageId),
                type: 'delete',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response){
                    console.log(response.message)
                },
                error: function(xhr, status, error){
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@endsection
