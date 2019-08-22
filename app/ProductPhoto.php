<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    //
    protected $table = "products_photos";
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
