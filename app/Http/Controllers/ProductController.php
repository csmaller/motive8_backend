<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        // Convert string booleans to actual booleans
        if ($request->has('in_stock')) {
            $request->merge([
                'in_stock' => filter_var($request->in_stock, FILTER_VALIDATE_BOOLEAN)
            ]);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'category' => 'required|string',
            'images' => 'nullable',
            'image_files' => 'nullable',
            'in_stock' => 'nullable|boolean',
            'stock_quantity' => 'nullable|integer|min:0',
            'sizes' => 'nullable',
            'colors' => 'nullable',
            'rating' => 'nullable|numeric|min:0|max:5',
            'review_count' => 'nullable|integer|min:0',
            'features' => 'nullable',
            'brand' => 'nullable|string',
            'payment_link' => 'nullable|string'
        ]);

        // Parse JSON strings if needed
        foreach (['sizes', 'colors', 'features', 'images'] as $field) {
            if (isset($validated[$field]) && is_string($validated[$field])) {
                $validated[$field] = json_decode($validated[$field], true);
            }
        }

        // Handle file uploads - check both 'image_files' and 'image'
        $fileField = $request->hasFile('image_files') ? 'image_files' : ($request->hasFile('image') ? 'image' : null);
        
        if ($fileField) {
            $uploadedImages = [];
            $files = is_array($request->file($fileField)) 
                ? $request->file($fileField) 
                : [$request->file($fileField)];
                
            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('product_images', $filename, 'public');
                    $uploadedImages[] = '/storage/' . $path;
                }
            }
            if (!empty($uploadedImages)) {
                $validated['images'] = $uploadedImages;
            }
        }
        
        unset($validated['image_files']);

        $product = Product::create($validated);
        
        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        // Convert string booleans to actual booleans
        if ($request->has('in_stock')) {
            $request->merge([
                'in_stock' => filter_var($request->in_stock, FILTER_VALIDATE_BOOLEAN)
            ]);
        }
        
        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'category' => 'string',
            'images' => 'nullable',
            'image_files' => 'nullable',
            'in_stock' => 'nullable|boolean',
            'stock_quantity' => 'nullable|integer|min:0',
            'sizes' => 'nullable',
            'colors' => 'nullable',
            'rating' => 'nullable|numeric|min:0|max:5',
            'review_count' => 'nullable|integer|min:0',
            'features' => 'nullable',
            'brand' => 'nullable|string',
            'payment_link' => 'nullable|string'
        ]);

        // Parse JSON strings if needed
        foreach (['sizes', 'colors', 'features', 'images'] as $field) {
            if (isset($validated[$field]) && is_string($validated[$field])) {
                $validated[$field] = json_decode($validated[$field], true);
            }
        }

        // Handle file uploads - check both 'image_files' and 'image'
        $fileField = $request->hasFile('image_files') ? 'image_files' : ($request->hasFile('image') ? 'image' : null);
        
        if ($fileField) {
            $uploadedImages = [];
            $files = is_array($request->file($fileField)) 
                ? $request->file($fileField) 
                : [$request->file($fileField)];
                
            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('product_images', $filename, 'public');
                    $uploadedImages[] = '/storage/' . $path;
                }
            }
            if (!empty($uploadedImages)) {
                $validated['images'] = $uploadedImages;
            }
        }
        
        unset($validated['image_files']);

        $product->update($validated);
        
        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        
        return response()->json([
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
