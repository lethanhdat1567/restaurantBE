<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        $arr = [
            'status' => true,
            'message' => 'Users lists',
            'data' => UserResource::collection($users),
        ];
        return response()->json($arr,200);
    }

    public function store(Request $req)
    {
        $user = User::create([
            'fullname' => $req->fullname,
            'email' => $req->email,
            'phone_number' => $req->phone_number,
            'address' => $req->address,
            'password' => bcrypt($req->password),
            'role_id' => intval($req->role),
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
        $users = User::find($id);
        if (is_null($users)) {
            $arr = [
                'success' => false,
                'message' => 'Khong co san pham nay',
                'data' => [],
            ];
            return response()->json($arr,200);
        };

        $arr = [
            'success' => true,
            'message' => 'Lay san pham thanh cong',
            'data' => new UserResource($users),
        ];
        return response()->json($arr,200);
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }
    
        $status = $user->update($request->all());
    
        if ($status) {
            return response()->json([
                'success' => true,
                'message' => 'Update sản phẩm thành công',
                'data' => $user, 
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Update thất bại',
            ], 500);
        }
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->deleted = 0;
        $user->save();
        $arr = [
            'status' => true,
            'message' => 'Destroy data success',
            'data' => $user,
        ];

        return response()->json($arr,200);
    }
    public function updateRole(Request $request, $id) {
        $input = $request->all();

        $validator = Validator::make($input, [
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Error while checking data',
                'data' => $validator->errors(),
            ], 422); 
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404); 
        }

        $user->role_id = $input['role_id']; 
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Update data success',
            'data' => $user, 
        ], 200);
    }
    public function upload(Request $request) {
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('files', 'public'); // Lưu vào thư mục 'files' trong 'storage/app/public'

            // Tạo URL công khai của tệp
            $url = Storage::url($path);

            return response()->json([
                'success' => true,
                'url' => $url,
            ]);
        }

        return response()->json(['success' => false], 400);
    }
}
