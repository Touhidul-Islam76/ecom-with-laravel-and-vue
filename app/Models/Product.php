<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'brand_id',
        'title',
        'slug',
        'short_desc',
        'price',
        'discount_type',
        'discount',
        'discounted_price',
        'stock',
        'image',
        'star',
        'remarks',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function scopeProductFilter($query, $request){
        if($request->has('category_id')){
            $query->where('category_id', $request->category_id);
        }
        if($request->has('brand_id')){
            $query->where('brand_id', $request->brand_id);
        }
        
    }
}
