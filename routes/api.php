<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;


// Route đăng ký và đăng nhập
Route::post('/register', [AuthController::class, 'register']);
Route::post('/authenticate', [AuthController::class, 'authenticate']);


// Các route không cần xác thực
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// Các route cần xác thực
Route::middleware('auth:sanctum')->group(function () {
    // Thêm sản phẩm — cần quyền create_product
    Route::post('/products', [ProductController::class, 'store'])
        ->middleware('permission:create_product');

    // Cập nhật sản phẩm — cần quyền update_product
    Route::put('/products/{id}', [ProductController::class, 'update'])
        ->middleware('permission:update_product');

    // Xoá sản phẩm — chỉ admin được phép
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])
        ->middleware(['role:admin', 'permission:delete_product']);
});
