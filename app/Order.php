<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = "orders";
    public function order_products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
