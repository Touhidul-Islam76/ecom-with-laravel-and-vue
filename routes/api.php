<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\UserProductController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function(){

    Route::post('login/otp/send', [AuthController::class,'loginOtpSend']);
    Route::post('login', [AuthController::class,'login']);
    
    Route::get('brands',[BrandController::class, 'index']);
    Route::get('categories',[CategoryController::class, 'index']);
    Route::get('products',[ProductController::class, 'index']);

    Route::group(['middleware' => 'auth:sanctum'], function(){
        Route::post('add/wishlist', [UserProductController::class, 'addWishlist']);
        Route::post('remove/wishlist', [UserProductController::class, 'removeWishList']);
        Route::get('wishlist', [UserProductController::class, 'wishList']);
        Route::get('cart', [ShoppingCartController::class,'index']);
        Route::post('add/cart', [ShoppingCartController::class,'addToCart']);
        Route::post('delete/cart', [ShoppingCartController::class,'removeToCart']);
        Route::post('flash/cart', [ShoppingCartController::class,'flashCart']);
    });
});