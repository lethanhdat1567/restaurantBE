<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
{
    $param = strtolower($request->query('search', ''));

    $query = Product::whereRaw('LOWER(title) LIKE ?', ['%' . $param . '%']);

    $products = $query->deleted()->get();

    if ($products->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'Not Found',
            'data' => [],
        ], 200);
    }

    return response()->json([
        'status' => true,
        'message' => 'Success',
        'data' => $products,
    ], 200);
}
}
