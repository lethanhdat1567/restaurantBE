<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function index(string $id) {
        $products = DB::table('orders as o')
            ->join('order_details as od', 'o.id', '=', 'od.order_id')
            ->join('products as p', 'od.product_id', '=', 'p.id')
            ->select('p.id', 'p.title','p.total','p.thumbnail','p.description' ,'od.quantity')
            ->where('o.id', $id)
            ->get();

        $userInfo = DB::table('orders as o')
            ->join('users as u', 'o.user_id', '=', 'u.id')
            ->select('u.fullname','u.phone_number','o.total_money','o.created_at','u.email', 'u.address') // Thay đổi trường tùy thuộc vào nhu cầu
            ->where('o.id', $id)
            ->first();
        
        $arr = [
            'status' => true,
            'message' => 'Success',
            'data' => [
                'userInfo' => $userInfo,
                'products' => $products,
            ],
        ];

        return response()->json($arr,200);
    }
    public function userHistory(string $id) {
        $userInfo = DB::table('orders as o')
        ->join('users as u', 'o.user_id', '=', 'u.id')
        ->select('o.*')
        ->where('o.user_id', $id)
        ->orderBy('o.created_at', 'desc') 
        ->get();

        $arr = [
            'status' => true,
            'message' => 'Success',
            'data' => $userInfo,
        ];

        return response()->json($arr,200);
    }
}
