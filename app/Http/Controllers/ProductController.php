<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSlider;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
         $products = Product::with('category','brand')->ProductFilter($request)->paginate(20);
         return $this->success($products,'Products retrieved successfully');
    }

    public function show(string $slug){
        $product = Product::with('category','brand')->where('slug', $slug)->first();
        if(!$product){
            return $this->error('Product not found', 404);
        }
        return $this->success($product,'Product retrieved successfully');
    }

    public function productSlider(){
        $sliders = ProductSlider::with('product')->get();
        return $this->success($sliders,'Product sliders retrieved successfully');

    }
}
