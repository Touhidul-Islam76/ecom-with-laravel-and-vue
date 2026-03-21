<?php

namespace App\Http\Controllers;

use App\Events\PaymentEvent;
use App\Helpers\SslCommerce;
use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout( CheckoutRequest $req ){
        try{
            $user = auth()->user();
        $usercart = Cart::whereUserId($user->id)->get();

        if(!$usercart){
            return $this->error(['Cart is Empty']);
        }

        $address = "Name:$req->name,Email:$req->email,Mobile:$req->mobile_no,city:$req->city,state:$req->state,postCode:$req->post_code,address:$req->address";

        $total = 0;
        foreach( $usercart as $cart ){
            $total += $cart->price * $cart->quantity;
        }

        $vat = ($total*3)/100;
        $payable = $total + $vat;

        $invoiceId  = 'INV:-'.rand(100000,99999).'-'.date('Ymd').'-'.time();


        DB::beginTransaction();
        $invoice = Invoice::create([
            'user_id' => $user->id,
            'invoice_no' => $invoiceId,
            'total' => $total,
            'vat' => $vat,
            'payable' => $payable,
            'customer_details' => $address,
            'ship_details' => $address,
        ]);

        foreach( $usercart as $cart ){
            InvoiceProduct::create([
                'invoice_id' => $invoice->id,
                'product_id' => $cart['product_id'],
                'quantity' => $cart['quantity'],
                'unit_price' => $cart['price'],
                'total_price' => $cart['price']*$cart['quantity'],
                'color' => $cart['color'],
                'size' => $cart['size'],
            ]);
        }

        Cart::whereUserId($user->id)->delete();
        DB::commit();
        // event(new PaymentEvent($invoice));
        $sslResponse = SslCommerce::initPayment($req,$invoice);

        return $this->success($sslResponse, ['Invoice created successfully']);
        }catch(\Exception $e){
            DB::rollBack();
            return $this->error(['Something went wrong'],500);
        }

    }
}
