<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class SslCommerce{
    public static function initPayment( $req,$invoice ){
        $paymentUrl = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";
        $store_Id = "test-store";
        $store_passwd = "";
        $success_url = "http://127.0.0.1:8000/success";
        $fail_url = "http://127.0.0.1:8000/fail";
        $cancel_url = "http://127.0.0.1:8000/cancel";
        $ipn_url = "http://127.0.0.1:8000/ipn";

        $response = Http::asForm()->post($paymentUrl,[
            'store_Id' => $store_Id,
            'store_passwd' => $store_passwd,
            'total_amount' => $invoice->total_amount,
            'currency' => 'BDT',
            'tran_id' => $invoice->invoice_id,
            'success_url' => $success_url.'?invoice_id'.$invoice->invoice_id,
            'fail_url' => $fail_url.'?invoice_id'.$invoice->invoice_id,
            'cancel_url' => $cancel_url.'?invoice_id'.$invoice->invoice_id,
            'ipn_url' => $ipn_url,
            'customer_name' => $req->name,
            'customer_email' => $req->email,
            'customer_mobile' => $req->mobile_no,
            'customer_address' => $req->address,
            'customer_city' => $req->city,
            'customer_state' => $req->state,
            'customer_postcode' => $req->post_code,
        ]);
    }
}