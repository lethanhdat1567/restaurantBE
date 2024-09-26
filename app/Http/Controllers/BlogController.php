<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Http\Resources\BlogResource;


class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::whereNull('deleted')->get();  // Query to get all records where deleted is null

        $arr = [
            'state' => true,
            'message' => 'Success',
            'data' => BlogResource::collection($blogs),
        ];

        return response()->json($arr, 200);
    }


    public function store(Request $request)
    {
        $input = $request->all();

        $blog = Blog::create($input);
        
        $arr = [
            'state' => true,
            'message' => 'Success',
            'data' => $blog,
        ];
        return response()->json($arr,200);

    }
    public function show(string $id)
    {
        $blogs = Blog::find($id);
        if (is_null($blogs)) {
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
            'data' => new BlogResource($blogs),
        ];
        return response()->json($arr,200);
    }

    public function update(Request $request, string $id)
    {
        $blogs = Blog::find($id);
    
        if (!$blogs) {
            return response()->json([
                'success' => false,
                'message' => 'Blog not found',
            ], 404);
        }
    
        $status = $blogs->update($request->all());
    
        if ($status) {
            return response()->json([
                'success' => true,
                'message' => 'Update sản phẩm thành công',
                'data' => $blogs, 
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
       $blog = Blog::find($id);
       $blog->deleted = 0;
       $blog->save();
        $arr = [
            'status' => true,
            'message' => 'Destroy data success',
            'data' =>$blog,
        ];

        return response()->json($arr,200);
    }
}
