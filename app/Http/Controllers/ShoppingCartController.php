<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Http\Requests\RemoveCartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function addToCart(AddCartRequest $req)
    {
        $user = auth()->user();

        if (Cart::where('user_id', $user->id)->where('product_id', $req->product_id)->exists()) {
            return $this->error(['Product is already added to cart']);
        }

        $product = Product::findOrFail($req->product_id);
        $productDetails = ProductDetail::where('product_id', $req->product_id)->get();

        $availableSizes = $productDetails->pluck('size')->unique()->values();
        $availableColors = $productDetails->pluck('color')->unique()->values();

        if ($availableSizes->isNotEmpty()) {
            if (!$req->filled('size')) {
                return $this->error(['Size is required'], 400);
            }
            if (!$availableSizes->contains($req->size)) {
                return $this->error(['This size is not available right now'], 400);
            }
        }
        if ($availableColors->isNotEmpty()) {
            if (!$req->filled('color')) {
                return $this->error(['color is required'], 400);
            }
            if (!$availableColors->contains($req->color)) {
                return $this->error(['This color is not available right now'], 400);
            }
        }

        if ($product->discount && $product->discount > 0) {
            $price = $product->discounted_price;
        } else {
            $price = $product->price;
        }

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $req->quantity,
            'price' => $price,
            'color' => $availableColors->isNotEmpty() ? $req->size : null,
            'size' => $availableSizes->isNotEmpty() ? $req->size : null,
        ]);

        return $this->success(null, ['Product added to your cart']);
    }

    public function removeToCart(RemoveCartRequest $req)
    {
        $user = auth()->user();

        $cart = Cart::where('user_id', $user->id)
            ->where('id', $req->cart_id)
            ->first();

        if (!$cart) {
            return $this->error(['Product is not in your cart']);
        }

        $cart->delete();

        return $this->success(null, ['Product removed from your cart successfully']);
    }

    public function flashCart()
    {
        Cart::where('user_id', auth()->id())->delete();
        return $this->success(null, ['Cart cleared successfully']);
    }

    public function index()
    {
        $user = auth()->user();
        $cart = Cart::with('product')->where('user_id', $user->id)->get();
        return $this->success($cart, ['cart data retrieved successfully']);
    }
}
