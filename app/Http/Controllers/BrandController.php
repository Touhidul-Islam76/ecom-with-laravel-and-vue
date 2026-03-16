<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(){
        $brands = Brand::select('id','name','image')->get();
        return $this->success($brands,'Brands retrieved successfully');
    }
}
