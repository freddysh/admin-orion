<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    //
    protected $table = "orders_products";
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function products()
    {
        return $this->hasOne(Product::class, 'product_id');
    }
}
