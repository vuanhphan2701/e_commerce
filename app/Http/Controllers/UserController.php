<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Js;
use App\Repositories\ProductRepository;

class UserController extends Controller
{
    // public function index()
    // {

    //     $product = new ProductRepository();
    //     $allProducts = $product->getAllProducts();

    //     return new JsonResponse([
    //         'status' => 'ok',
    //         'message' => 'Manual JsonResponse'
    //     ], 200);
    // }
    public function show(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer', 'min:1', new checkIdInSystem()]
        ]);
        $request->get('id');
        return response()->json([
            'status' => 'ok',
            'message' => 'Helper JsonResponse'
        ], 200);
    }


}
