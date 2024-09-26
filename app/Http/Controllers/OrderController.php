<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $req)
    {
        $user = Order::create([
            'user_id' => $req->user_id,
            'fullname' => $req->fullname,
            'email' => $req->email,
            'phone_number' => $req->phone_number,
            'address' => $req->address,
            'note' => $req->note,
            'total_money' => $req->total_money,
        ]);
        $arr = [
            'status' => true,
            'message' => 'Insert data success',
            'data' => $user,
        ];

        return response()->json($arr,200);
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
