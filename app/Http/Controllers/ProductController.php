<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use Core\Response;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Product Repository
     */
    protected $productRepository;

    public function __construct()
    {
        $this->productRepository = resolve(ProductRepository::class);
    }

    public function index()
    {
        $products = $this->productRepository->getAll();
        return Response::success($products);
    }

    public function show($id)
    {
        $product = $this->productRepository->findById($id);

        if (!$product) {
            return Response::error('Product not found', 404);
        }

        return Response::success($product);
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $product = $this->productRepository->create($validated);

        return Response::success($product, 'Product created successfully', 201);

    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productRepository->update($id, $request->validated());

        return Response::success($product, 'Product updated successfully');
    }

    public function destroy($id)
    {
        $this->productRepository->delete($id);

        return Response::success(null, 'Product deleted successfully');
    }
}
