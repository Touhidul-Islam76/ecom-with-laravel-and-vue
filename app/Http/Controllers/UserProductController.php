<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddWishListRequest;
use App\Http\Requests\RemoveWishListRequest;
use App\Models\ProductNishList;
use Illuminate\Http\Request;

class UserProductController extends Controller
{
    public function addWishlist(AddWishListRequest $req){
        $user = auth()->user();

        if(ProductNishList::where('user_id', $user->id)->where('product_id', $req->product_id)->exists()){
            return $this-> error(['This product already has been added to the wishlist']);
        }

        ProductNishList::create([
            'user_id' => $user->id,
            'product_id'=> $req->product_id
        ]);
        return $this->success('Product added to the wishlist successfully');

    }

    public function removeWishList(RemoveWishListRequest $req){
        $user = auth()->user();

        $productWishList = ProductNishList::where('user_id', $user->id)->where('product_id', $req->product_id)->first();
        if(!$productWishList){
            return $this->error(['This Product is not in your wishlist']);
        }

        $productWishList->delete();
        return $this->success('Product has been successfully removed from your wistlist');
    }

    public function wishlist(){
        $wistlist = ProductNishList::with('product')->whereUserId(auth()->id())->get();
        return $this->success($wistlist);
    }
}
