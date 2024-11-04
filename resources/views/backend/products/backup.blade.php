@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Add Product</h1>
        </div>
        <div id="response-message" class="mt-3"></div>
        {{-- @if (Session::has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div>
                    {{ Session::get('message') }}
                </div>
            </div>
        @endif --}}

        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" id="add-product-form">
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
                                    name="name" placeholder="Enter product name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="summernote"  rows="4"
                                    placeholder="Enter product description">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Base Price -->
                            <div id="priceSection">
                            <div class="mb-3 ">
                                <label class="form-label ">Base Price</label>
                                <input type="number" class="form-control base-data @error('price') is-invalid @enderror"
                                    name="price" step="0.01" placeholder="Enter base price"
                                    value="{{ old('price') }}">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Compare Price</label>
                                <input type="number" class="form-control base-data @error('compare_price') is-invalid @enderror"
                                    name="compare_price" step="0.01" placeholder="Enter compare price"
                                    value="{{ old('compare_price') }}">
                                @error('compare_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Base SKU -->
                            <div class="mb-3 base-data">
                                <label class="form-label">Base SKU</label>
                                <input type="text" class="form-control base-data @error('sku') is-invalid @enderror" name="sku"
                                    placeholder="Enter base SKU" value="{{ old('sku') }}">
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
                                            <!-- Options fileds -->

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
                                                        <!-- Variants will be generated here -->
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
                                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Draft</option>
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
                                        {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
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
                <button type="submit" class="btn btn-primary">Save Product</button>
            </div>
        </form>
    </div>

    <script>
        function toggleBaseDataDivs(values = [])
        {
            if (values.length > 0) {
            $('.base-data').closest('.mb-3').remove();
        }
        else
        {
            if ($('.base-data').length === 0) {

                const baseDataHtml = `
                 <div class="mb-3">
                    <label class="form-label">Base Price</label>
                    <input type="number" class="form-control base-data" name="price" step="0.01" placeholder="Enter base price">
                </div>
                <div class="mb-3">
                    <label class="form-label">Compare Price</label>
                    <input type="number" class="form-control base-data" name="compare_price" step="0.01" placeholder="Enter compare price">
                </div>
                <div class="mb-3">
                    <label class="form-label">Base SKU</label>
                    <input type="text" class="form-control base-data" name="sku" placeholder="Enter base SKU">
                </div>
                `;

                $('#priceSection').append(baseDataHtml);
            }
        }
        }
        $(document).ready(function() {


            $('#add-product-form').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                // Collect variation data
                const variants = [];
                $('#variant-table-body tr').each(function(index) {

                    const variant = {
                        variationName: $(this).find('.variation-name').val(),
                        price: $(this).find('.variant-price').val(),
                        stock: $(this).find('.variant-stock').val(),
                        compare_price: $(this).find('.variant-compare-price').val(),
                        sku: $(this).find('.variant-sku').val(),
                        image: $(this).find('.variant-image')[0]?.files[0]
                    };

                    // Validate the variant fields before adding to the array
                    //  if (variant.price === '' || variant.stock === '' || variant.sku === '') {
                    //     return;
                    //  }
                     variants.push(variant);
                        // alert('Please fill out all required fields for each variant.');



                });

                // Append variants data to FormData
                if (variants.length>0) {
                    formData.append('variants', variants);
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
                //console.log(options);
                if (options.length>0) {

                    formData.append('options', JSON.stringify(options));
                }
                //Append options data to FormData
                for (var pair of formData.entries()) {
    console.log(pair[0]+ ', ' + pair[1]);
}
//return;
//                 Handle file uploads
//                 const files = $('#files')[0].files;
//                 for (let i = 0; i < files.length; i++) {
//                     formData.append('files[]', files[i]);
//                 }
//                 console.log(formData); return;
//                 for (var pair of formData.entries()) {
//     console.log(pair[0]+ ', ' + pair[1]);
// }
                // AJAX request to submit the form
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                   headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    success: function(response) {

                        window.location.href = "{{ route('product.list')}}";

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

            // Handle file selection for drag and drop
            function handleFileSelect(evt) {
                var files = evt.target.files; // FileList object

                // Loop through the FileList and render image files as thumbnails.
                for (var i = 0, f; f = files[i]; i++) {

                    // Only process image files.
                    if (!f.type.match('image.*')) {
                        continue;
                    }

                    var reader = new FileReader();

                    // Closure to capture the file information.
                    reader.onload = (function(theFile) {
                        return function(e) {
                            // Render thumbnail with remove button
                            var span = document.createElement('span');
                            span.classList.add('image-thumbnail'); // Add class for styling
                            span.innerHTML = [
                                '<img class="thumb" src="', e.target.result,
                                '" title="', escape(theFile.name), '"/>',
                                '<div class="remove-icon" title="Remove Image" style="cursor: pointer;">',
                                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">',
                                '<path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm0 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14z"/><path d="M4.293 4.293a1 1 0 0 1 1.414 0L8 7.586l2.293-2.293a1 1 0 0 1 1.414 1.414L9.414 9l2.293 2.293a1 1 0 0 1-1.414 1.414L8 10.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L6.586 9 4.293 6.707a1 1 0 0 1 0-1.414z"/>',
                                '</svg></div>'
                            ].join('');
                            document.getElementById('list').insertBefore(span, null);
                        };
                    })(f);

                    // Read in the image file as a data URL.
                    reader.readAsDataURL(f);
                }
            }

            // Bind file input change event
            $('#files').change(handleFileSelect);

            // Hide error messages on initial load
            // $('.option-error, .value-error').hide();

            // Add new option field
            $('#add-option').on('click', function() {
                toggleBaseDataDivs();
                const optionRows = $('.option-row');
                if(optionRows.length!=0){

                    const lastOptionName = optionRows.last().find('.option-name').val().trim();

                    // Check if the last option name is empty
                    if (optionRows.length > 0 && lastOptionName === '') {
                        optionRows.last().find('.option-name').addClass('is-invalid');
                        optionRows.last().find('.option-error').show();
                        return;
                    }
                }

                // Add a new option row
                addNewOptionRow();
            });

            // Function to add a new option row
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
                    toggleBaseDataDivs(values=0)
                }
            });

            // Generate variants
            function generateVariants() {
                const optionRows = $('.option-row');
                let allValues = [];

                optionRows.each(function() {
                    const optionName = $(this).find('.option-name').val().trim();
                    const values = $(this).find('.value-input').map(function() {
                        return $(this).val().trim();
                    }).get().filter(value => value !== '');

                    toggleBaseDataDivs(values);
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
                    variantTableBody.append('<tr><td colspan="6" class="text-center">No variants available.</td></tr>');
                    return;
                }

                variants.forEach(variant => {
                    const variantName = Object.entries(variant).map(([key, value]) => `${value}`).join('/');

                    const row = $('<tr></tr>');
                    row.append(`<td>${variantName}</td>`);
                    row.append(`
                    <td class="hidden">
                    <input type="hidden" class="form-control variation-name" value="${variantName}">
                    </td>
                <td>
                    <input type="file" class="form-control variant-image" accept="image/*">
                </td>
                <td>
                    <input type="number" class="form-control variant-price" step="0.01" placeholder="Price">
                </td>
                <td>
                    <input type="number" class="form-control variant-stock" placeholder="Stock">
                </td>
                <td>
                    <input type="number" class="form-control variant-compare-price" step="0.01" placeholder="Compare Price">
                </td>
                <td>
                    <input type="text" class="form-control variant-sku" placeholder="SKU">
                </td>
            `);
                    variantTableBody.append(row);
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

            // Initial variant generation
            // generateVariants(variants=[]);

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
    </script>
@endsection



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductVariation;
use App\Models\ProductVariationAttribute;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;


class ProductController extends Controller
{
    public function  index()
    {
        $products = Product::paginate(20);
        return view('backend.products.index');
    }

    public function products(Request $request)
{
    try {
        $products = Product::with('categories')->paginate(10);
        return response()->json($products);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error fetching products: ' . $e->getMessage()], 500);
    }
}

    public Function addForm()
    {
        $categories = Category::all();
        return view('backend.products.add',compact('categories'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        // Debugging - dump the request data
        Log::info("Add Products here");
        Log::info($request->all());

        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'compare_price' => 'nullable|numeric',
            'sku' => 'nullable|string|max:255|unique:product_variations',
            'status' => 'boolean',
            'categories' => 'required|array|min:1',
            'categories.*' => 'required|exists:categories,id',
            'files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants' => 'nullable',
            'options' => 'nullable|json',
        ]);

        // Create the product
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->status,
        ]);

        // Attach categories
        $product->categories()->attach($request->categories);

        // Decode the variants JSON if provided
        $variants = $request->variants;
        dd($variants);
        return;

        // Handle variations if variants are provided
        if ($variants) {
            foreach ($variants as $variant) {
                $productVariation = ProductVariation::create([
                    'product_id' => $product->id,
                    'variation_name' =>  $variant['variationName'],
                    'sku' => $variant['sku'] ?? null,
                    'price' => $variant['price'] ?? null,
                    'stock' => $variant['stock'],
                    'compare_price' => $variant['compare_price'] ?? null,
                ]);

                // Handle variant images if any exist
                if ($variant['image']) {
                    $this->handleImages($variant['image'], $productVariation, 'variation');
                } else {
                    Log::warning("No files detected in the request.");
                }

                // Handle variant attributes if they exist
                if (isset($request->options)) {
                    $options = json_decode($request->options, true);
                    foreach ($options as $option) {
                        if (!empty($option['name']) && !empty($option['values'])) {
                            // Check if attribute already exists to prevent duplicate
                            $attributeModel = Attribute::firstOrCreate(['name' => $option['name']]);

                            // Array to keep track of attribute values that have already been created
                            $existingAttributeValues = [];

                            foreach ($option['values'] as $value) {
                                // If the value has already been added to the list, skip it
                                if (in_array($value, $existingAttributeValues)) {
                                    continue; // Skip if value already exists
                                }

                                // First or create the attribute value
                                $attributeValue = AttributeValue::firstOrCreate([
                                    'attribute_id' => $attributeModel->id,
                                    'value' => $value,
                                ]);

                                // Create the relationship in ProductVariationAttribute
                                ProductVariationAttribute::firstOrCreate([
                                    'product_variation_id' => $productVariation->id,
                                    'attribute_value_id' => $attributeValue->id,
                                ]);

                                // Add value to the existing array to prevent duplicates
                                $existingAttributeValues[] = $value;
                            }
                        }
                    }
                }
            }
        }
        else{
            $productVariation = ProductVariation::create([
                'product_id' => $product->id,
                'variation_name' => 'default',
                'price' => $request->price ?? null,
                'sku' => $request->sku  ?? null,
                'compare_price' => $request->compare_price  ?? null,
                'stock' => $request->stock ? $request->stock : 0,
            ]);


        }
        if ($request->hasFile('files')) {

            $this->handleImages($request->file('files'), $product, 'product');
        }

        return response()->json(['success' => 'Product added successfully'], 201);

    }





    public function edit($id)
    {
        $product = Product::with([
            'categories',
            'images',
            'variations.attributes.attribute', // Load the attribute relationship
        ])->findOrFail($id);
        $categories = Category::all();

         return view('backend.products.edit',compact('product','categories'));
    }



    public function update(Request $request, $id)
    {
        Log::info("Updating product with ID: $id");
        Log::info($request->all());

        $product = Product::findOrFail($id);
        $variationIds = $request->input('variation_id', []);

        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants' => 'nullable|json', // Optional variants
            'options' => 'nullable|json', // Optional options
        ]);

        // Update the product
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->status,
        ]);

        // Sync categories
        $product->categories()->sync($request->categories);

        // Handle product images
        $this->handleImages($request->file('files'), $product, 'product');

        // Decode the variants JSON if provided
        $variants = json_decode($request->variants, true);

        // Handle variations if variants are provided
        if ($variants) {
            foreach ($variants as $key => $variant) {

                // Find or create the product variation
                $productVariation = ProductVariation::updateOrCreate(
                    ['id' => $request['variation_id'][$key], 'product_id' => $product->id],
                    [
                        'variation_name' => $variant['variationName'],
                        'sku' => $variant['sku'] ?? null,
                        'price' => $variant['price'] ?? null,
                        'stock' => $variant['stock'] ?? null,
                        'compare_price' => $variant['compare_price'] ?? null,
                    ]
                );

                // Handle variant attributes if they exist
                if (isset($request->options)) {
                    $options = json_decode($request->options, true);
                    foreach ($options as $option) {
                        if (!empty($option['name']) && !empty($option['values'])) {
                            // Check if attribute already exists to prevent duplicate
                            $attributeModel = Attribute::firstOrCreate(['name' => $option['name']]);

                            // Array to keep track of attribute values that have already been created
                            $existingAttributeValues = [];

                            foreach ($option['values'] as $value) {
                                // If the value has already been added to the list, skip it
                                if (in_array($value, $existingAttributeValues)) {
                                    continue; // Skip if value already exists
                                }

                                // First or create the attribute value
                                $attributeValue = AttributeValue::firstOrCreate([
                                    'attribute_id' => $attributeModel->id,
                                    'value' => $value,
                                ]);

                                // Create or update the relationship in ProductVariationAttribute
                                ProductVariationAttribute::updateOrCreate(
                                    [
                                        'product_variation_id' => $productVariation->id,
                                        'attribute_value_id' => $attributeValue->id,
                                    ]
                                );

                                // Add value to the existing array to prevent duplicates
                                $existingAttributeValues[] = $value;
                            }
                        }
                    }
                }

                // Handle variant images if any exist
                if ($request->hasFile('variant_images')) {
                    // $this->handleImages($request->file('variant_images'), $productVariation, 'variation');


                }
            }
        } else {
            // Create default variation if no variants provided
            $productVariation = ProductVariation::updateOrCreate([
                'product_id' => $product->id,
                'variation_name' => 'default',
                'price' => $request->price ?? null,
                'sku' => $request->sku ?? null,
                'compare_price' => $request->compare_price ?? null,
                'stock' => $request->stock ? $request->stock : 0,
            ]);
        }

        if ($request->hasFile('files')) {
            $this->handleImages($request->file('files'), $product, 'product');
        }

        return response()->json(['message' => 'Product updated successfully'], 200);
    }






    public function destroy(Request $request){
        try {
            $id = $request->id;
        $product = Product::find($id);
        if ($product) {
            $product->delete();
        Log::info($product->images);
            return response()->json(['success' => 'Product deleted successfully'], 200);
        }
        else{
            return response()->json(['error' => 'Product not found'], 404);
        }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Failed to delete product'], 500);
        }

    }



    // Function to handle image uploads
    private function handleImages($images, $model, $type)
    {
        log::info($images);
        if (!$images) {

            Log::warning("No images provided for upload.");
            return;
        }
        Log::info($images);

        // Ensure $images is an array
        $images = is_array($images) ? $images : [$images];
            $destinationPath = public_path("backend/images/{$type}s");
            foreach ($images as $image) {
                if ($image instanceof \Illuminate\Http\UploadedFile && $image->isValid()) {
                    $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();

                    $image->move($destinationPath, $filename);

                    if ($type === 'product') {
                        $model->images()->create([
                            'image_path' => "backend/images/{$type}s/{$filename}",
                            'product_id' => $model->id,
                        ]);
                    } elseif ($type === 'variation') {
                        $model->images()->create([
                            'image_path' => "backend/images/{$type}s/{$filename}",
                            'product_variation_id' => $model->id,
                        ]);
                    }
                } else {
                    Log::warning("Invalid image or file not found.", [
                        'image' => $image,
                        'type' => $type,
                    ]);
                }
            }
        }




}
