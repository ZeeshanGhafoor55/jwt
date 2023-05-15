<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post("/register",[AuthController::class,'register']);
Route::post("/login",[AuthController::class,'login']);
Route::post("/logout",[AuthController::class,'logout']);
Route::get('users', [AuthController::class,'users']);
// Route::group(['middleware'=>['auth:sanctum']->function (Request $request)]) {
//     // return $request->user();
        
// });


// Group Middleware
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('product',[ProductController::class, 'index']); 
    Route::get('product/{id}',[ProductController::class, 'show']); 
    Route::post('product-add',[ProductController::class, 'store']);
    Route::put('product/update/{id}',[ProductController::class, 'update']);
    Route::delete('product/delete/{id}',[ProductController::class, 'destroy']);
});

// Route Middleware 
// Route::middleware('auth:sanctum')->get('product',[ProductController::class, 'index']);


// Route::get('product/{id}',[ProductController::class, 'show']);
// Route::post('product-add',[ProductController::class, 'store']);
// Route::put('product/update/{id}',[ProductController::class, 'update']);
// Route::delete('product/delete/{id}',[ProductController::class, 'destroy']);


