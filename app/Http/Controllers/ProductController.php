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

    public static function middleware(): array
    {
        return [
            new Middleware('permission:products list', only: ['index']),
            new Middleware('permission:add product', only: ['addForm']),
            new Middleware('permission:add product', only: ['store']),
            new Middleware('permission:edit product', only: ['edit']),
            new Middleware('permission:edit product', only: ['update']),
            new Middleware('permission:delete product', only: ['destroy']),

        ];
    }

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
            'variants' => 'nullable|json',
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
        $variants = json_decode($request->variants, true);

        // Handle variations if variants are provided
        if ($variants) {
            foreach ($variants as $index => $variant) {

                $productVariation = ProductVariation::create([
                    'product_id' => $product->id,
                    'variation_name' =>  $variant['variationName'],
                    'sku' => $variant['sku'] ?? null,
                    'price' => $variant['price'] ?? null,
                    'stock' => $variant['stock'],
                    'compare_price' => $variant['compare_price'] ?? null,
                ]);

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

                // Handle variant images if any exist
                if ($request->hasFile("variant_images.{$index}")) {
                    $this->handleImages($request->file("variant_images.{$index}"), $productVariation, 'variation');
                } else {
                    Log::warning("No files detected for variant {$index}.");
                }
            }
        } else {
            $productVariation = ProductVariation::create([
                'product_id' => $product->id,
                'variation_name' => 'default',
                'price' => $request->price ?? null,
                'sku' => $request->sku  ?? null,
                'compare_price' => $request->compare_price  ?? null,
                'stock' => $request->stock ? $request->stock : 0,
            ]);
        }

        // Handle product images if any exist
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
        // dd($product);
        $categories = Category::all();

         return view('backend.products.edit',compact('product','categories'));
    }



    public function update(Request $request, $id)
    {
        Log::info("Updating product with ID: $id");
        Log::info($request->all());
// dd();
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
            'variants' => 'nullable|json',
            'options' => 'nullable|json',
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
        if ($request->hasFile('files')) {
            $this->handleImages($request->file('files'), $product, 'product');
        }

        // Decode the variants JSON if provided
        $variants = json_decode($request->variants, true);

        // Handle variations if variants are provided
        if ($variants) {
            // Delete the default variation, as we are adding new variants
            ProductVariation::where('product_id', $product->id)
                ->where('variation_name', 'default')
                ->delete();

            // Collect IDs of existing variants to retain
            $variantIdsToKeep = array_filter($variationIds);

            // Delete existing variants not in the request
            ProductVariation::where('product_id', $product->id)
                ->whereNotIn('id', $variantIdsToKeep)
                ->delete();

            foreach ($variants as $key => $variant) {
                // Find or create the product variation
                $productVariation = ProductVariation::updateOrCreate(
                    ['id' => $variationIds[$key] ?? null, 'product_id' => $product->id],
                    [
                        'variation_name' => $variant['variationName'],
                        'sku' => $variant['sku'] ?? null,
                        'price' => $variant['price'] ?? null,
                        'stock' => $variant['stock'] ?? null,
                        'compare_price' => $variant['compare_price'] ?? null,
                    ]
                );

                // Handle variant attributes if options exist
                if (isset($request->options)) {
                    $options = json_decode($request->options, true);
                    $existingAttributeValues = [];

                    foreach ($options as $option) {
                        if (!empty($option['name']) && !empty($option['values'])) {
                            $attributeModel = Attribute::firstOrCreate(['name' => $option['name']]);

                            foreach ($option['values'] as $value) {
                                if (in_array($value, $existingAttributeValues)) {
                                    continue;
                                }

                                $attributeValue = AttributeValue::firstOrCreate([
                                    'attribute_id' => $attributeModel->id,
                                    'value' => $value,
                                ]);

                                ProductVariationAttribute::firstOrCreate([
                                    'product_variation_id' => $productVariation->id,
                                    'attribute_value_id' => $attributeValue->id,
                                ]);

                                $existingAttributeValues[] = $value;
                            }
                        }
                    }
                } else {
                    // If no options are provided, retain the existing attributes
                    $existingAttributes = $productVariation->variationAttributes;
                    foreach ($existingAttributes as $existingAttribute) {
                        ProductVariationAttribute::firstOrCreate([
                            'product_variation_id' => $productVariation->id,
                            'attribute_value_id' => $existingAttribute->attribute_value_id,
                        ]);
                    }
                }

                // Handle variant images if any exist
                if ($request->hasFile("variant_images.{$key}")) {
                    $this->handleImages($request->file("variant_images.{$key}"), $productVariation, 'variation');
                }
            }
        } else {
            // Delete all variants except the default one if no variants provided
            ProductVariation::where('product_id', $product->id)
                ->where('variation_name', '!=', 'default')
                ->delete();

            // Create or update the default variation
            ProductVariation::updateOrCreate(
                ['product_id' => $product->id, 'variation_name' => 'default'],
                [
                    'price' => $request->price ?? null,
                    'sku' => $request->sku ?? null,
                    'compare_price' => $request->compare_price ?? null,
                    'stock' => $request->stock ?? 0,
                ]
            );
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
