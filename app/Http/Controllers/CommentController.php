<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $comment = Comment::create($input);

        $arr = [
            'status' => true,
            'message' => 'success',
            'data' => CommentResource::make($comment),
        ];

        return response()->json($arr,200);
    }
    public function show(string $id)
    {
        $comments = DB::table('comments')
            ->join('users', 'comments.user_id','=','users.id')
            ->join('products','comments.product_id','=','products.id')
            ->select('comments.*','users.fullname','users.avatar')
            ->where('comments.product_id','=',$id)
            ->whereNull('comments.parent_id')
            ->get();

        $replies = DB::table('comments')
            ->join('users', 'comments.user_id','=','users.id')
            ->join('products','comments.product_id','=','products.id')
            ->select('comments.*','users.fullname','users.avatar')
            ->where('comments.product_id','=',$id)
            ->whereNotNull('comments.parent_id')
            ->get();

        $arr = [
            'status' => true,
            'message' => 'success',
            'data' => ['comments' => $comments, 'replies' => $replies]
        ];

        return response()->json($arr, 200);
    }
    public function update(Request $request, string $id)
    {
        $comments = Comment::find($id);
    
        if (!$comments) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }
    
        $status = $comments->update($request->all());
    
        if ($status) {
            return response()->json([
                'success' => true,
                'message' => 'Update sản phẩm thành công',
                'data' => $comments, 
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Update thất bại',
            ], 500);
        }
    }
    public function destroy(string $id)
    {
      Comment::destroy($id);
        $arr = [
            'status' => true,
            'message' => 'Destroy data success',
        ];

        return response()->json($arr,200);
    }
}
