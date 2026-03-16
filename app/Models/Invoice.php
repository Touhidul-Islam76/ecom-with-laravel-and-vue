<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable =[
        'user_id',
        'invoice_no',
        'total',
        'vat',
        'payable',
        'customer_details',
        'ship_details',
        'status',
        'payment_status',
    ];
}
