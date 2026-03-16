<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function(){
    Route::get('brands',[BrandController::class, 'index']);
    Route::get('categories',[CategoryController::class, 'index']);
    Route::get('products',[ProductController::class, 'index']);
});