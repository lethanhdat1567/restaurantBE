<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\FuncCall;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function() {
    Route::get('logout',[AuthController::class,'logout']);
    Route::get('user',[AuthController::class,'getUser']);
});

// Authorization
Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);

// Booking router 
Route::resource('booking', BookingController::class);

// Users router
Route::resource('users', UserController::class);
Route::put('users/{id}/role', [UserController::class, 'updateRole']);
Route::post('users/upload', [UserController::class, 'upload']);

// Products router
Route::get('products/menu', [ProductController::class, 'menuList']);
Route::resource('products', ProductController::class);
Route::post('products/upload', [ProductController::class, 'upload']);

// Orders router 
Route::resource('orders', OrderController::class);

// Blogs router 
Route::resource('blogs', BlogController::class);

// Feedback router 
Route::resource('feedback', FeedbackController::class);


// Orders Detail router 
Route::resource('orderdetail', OrderDetailController::class);

// History
Route::get('history/detail/{id}',[HistoryController::class,'index']);
Route::get('history/{id}',[HistoryController::class,'userHistory']);

// Search 
Route::get('search',[SearchController::class,'index']);

// Comment router 
Route::resource('comments', CommentController::class);