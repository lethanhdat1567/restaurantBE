<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        $arr = [
            'status' => true,
            'message' => 'products lists',
            'data' => ProductResource::collection($products),
        ];
        return response()->json($arr,200);

    }

    public function store(Request $request)
    {
        $price = intval($request->price);  
        $discount = intval($request->discount); 
        
        $discountAmount = $price * ($discount / 100);
        
        $total = $price - $discountAmount;
        $total = round($total);
        $totalString = strval($total);

        $product = Product::create([
            'title' => $request->name,
            'price' => $request->price,
            'discount' => $request->discount,
            'thumbnail' => $request->thumbnail,
            'content' => $request->content,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'total' => $totalString,
        ]);

        $arr = [
            'status' => true,
            'message' => 'Insert data success',
            'data' => $product,
        ];

        return response()->json($arr,200);

    }


    public function show(string $id)
    {
        $product = Product::with('category')->find($id);
        if (is_null($product)) {
            $arr = [
                'success' => false,
                'message' => 'Khong co san pham nay',
                'data' => [],
            ];
            return response()->json(ProductResource::collection($arr),200);
        };

        $arr = [
            'success' => true,
            'message' => 'Lay san pham thanh cong',
            'data' => new ProductResource($product),
        ];
        return response()->json($arr,200);
    }

    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }
    
        $product->fill($request->all());
    
        $price = intval($product->price);  
        $discount = intval($product->discount); 
        $discountAmount = $price * ($discount / 100);
        $total = $price - $discountAmount;
        $total = round($total);
    
        $product->total = $total;
    
        if ($product->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Update sản phẩm thành công',
                'data' => $product,
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
        $product = Product::find($id);
        $product->deleted = 0;
        $product->save();
        $arr = [
            'status' => true,
            'message' => 'Destroy data success',
            'data' => $product,
        ];

        return response()->json($arr,200);
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
    public function menuList() {
        $products = Product::select('products.*', 'category.name as category_name')
        ->join('category', 'products.category_id', '=', 'category.id')
        ->where(function($query) {
            $query->where('products.deleted', '!=', 0)
                  ->orWhereNull('products.deleted');
        })
        ->get();

        $menuList = $products->groupBy('category_name')->map(function ($group, $title) {
        return [
            'title' => $title,
            'foods' => $group->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->title,
                    'desc' => $product->description,
                    'price' => $product->price,
                    'discount' => $product->discount,
                    'total' => $product->total,
                    'img' => $product->thumbnail,
                ];
            })->values()->all(),
            ];
        })->values()->all();

        $response = [
        'status' => true,
        'message' => 'products lists',
        'data' => $menuList,
        ];

    return response()->json($response, 200);
    }
}
