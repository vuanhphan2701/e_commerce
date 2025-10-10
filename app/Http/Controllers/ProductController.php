<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    protected $productRepository;

    // inject repository
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    // Get all products
    public function index()
    {
        $products = $this->productRepository->getAll();
        return response()->json($products);
    }

    // Get a product by ID
    public function show($id)
    {
        $product = $this->productRepository->findById($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    // Create new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $product = $this->productRepository->create($validated);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    // Update product
    public function update(Request $request, $id)
    {
        $product = $this->productRepository->update($id, $request->all());

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

    // Delete product
    public function destroy($id)
    {
        $this->productRepository->delete($id);

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
