<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $req) {
        $credentials = $req->only('email', 'password');
        if(!Auth::attempt($credentials)) {
            return response([
                'message' => 'email or password wrong'
            ]);
        }
        $user = Auth::user();

        $token = $user->createToken('main')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function register(Request $req) {
        $user = User::create([
            'fullname' => $req->fullname,
            'email' => $req->email,
            'phone_number' => $req->phone_number,
            'avatar' => $req->avatar,
            'address' => $req->address,
            'password' => bcrypt($req->password),
            'role_id' => 1,
        ]);

        $token = $user->createToken('main',[$user->role_id])->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }   

    public function logout(Request $req) {
        // Lấy người dùng hiện tại từ yêu cầu
        $user = $req->user();
    
        // Kiểm tra xem người dùng có tồn tại không
        if ($user) {
            // Xóa token hiện tại
            $user->currentAccessToken()->delete();
            return response('', 204); // Trả về mã trạng thái 204 No Content
        } else {
            // Nếu không có người dùng, trả về lỗi xác thực
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    }
    public function getUser(Request $request)
        {
            return response()->json($request->user());
        }
}
