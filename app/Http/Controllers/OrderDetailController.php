<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index()
    {
        //
    }
    public function store(Request $req)
    {
        // Kiểm tra nếu order_details và products không phải là null và là mảng
        $orderDetails = $req->order_details;
        $productDetails = $req->products;
    
        if (!is_array($orderDetails) || !is_array($productDetails)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid data format',
            ], 400);
        }
    
        // Xử lý và lưu dữ liệu nếu hợp lệ
        $results = [];
        foreach ($productDetails as $detail) {
            $orderDetail = OrderDetail::create([
                'order_id' => $orderDetails['id'],
                'product_id' => $detail['product_id'],
                'price' => $detail['price'],
                'quantity' => $detail['quantity'],
                'total_money' => $detail['total'],
            ]);
    
            $results[] = $orderDetail;
        }
    
        $arr = [
            'status' => true,
            'message' => 'Insert data success',
            'data' => $results,
        ];
    
        return response()->json($arr, 200);
    }
    
    public function show(string $id)
    {
        //
    }
    public function update(Request $request, string $id)
    {
        //
    }
    public function destroy(string $id)
    {
        //
    }
}
