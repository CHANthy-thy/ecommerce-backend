<?php

use App\Http\Controllers\Api\CategoryController as ApiCategoryController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Api\CartController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\ReviewController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user']);
Route::middleware('auth:sanctum')->get('/profile', [AuthController::class, 'profile']);
Route::middleware('auth:sanctum')->put('/profile', [AuthController::class, 'updateProfile']);
Route::middleware('auth:sanctum')->put('/change-password', [AuthController::class, 'changePassword']);


Route::get('/ping', function () {
    return response()->json([
        'success' => true,
        'message' => 'pong',
    ]);
});

Route::get('/categories', [ApiCategoryController::class, 'index']);



Route::get('/products', [ApiProductController::class, 'index']);
Route::get('/products/{id}', [ApiProductController::class, 'show']);
Route::get('/products/search', [ApiProductController::class, 'search']);

use App\Http\Controllers\Api\WishlistController;

Route::middleware('auth:sanctum')->get('/wishlist', [WishlistController::class, 'index']);
Route::middleware('auth:sanctum')->post('/wishlist', [WishlistController::class, 'store']);
Route::middleware('auth:sanctum')->delete('/wishlist/{id}', [WishlistController::class, 'destroy']);

// Cart (auth required)
Route::middleware('auth:sanctum')->get('/cart', [CartController::class, 'index']);


Route::middleware('auth:sanctum')->post('/cart', [CartController::class, 'store']);
Route::middleware('auth:sanctum')->put('/cart/{productId}', [CartController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/cart/{productId}', [CartController::class, 'destroy']);

// Checkout (auth required)
Route::middleware('auth:sanctum')->post('/checkout', [CheckoutController::class, 'store']);

// Reviews
Route::get('/products/{id}/reviews', [ReviewController::class, 'index']);
Route::middleware('auth:sanctum')->post('/products/{id}/reviews', [ReviewController::class, 'store']);
Route::middleware('auth:sanctum')->delete('/reviews/{id}', [ReviewController::class, 'destroy']);

// Orders (auth required)
Route::middleware('auth:sanctum')->get('/orders', [\App\Http\Controllers\Api\OrderController::class, 'index']);
Route::middleware('auth:sanctum')->get('/orders/{id}', [\App\Http\Controllers\Api\OrderController::class, 'show']);




















