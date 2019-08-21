<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = "categories";
    public function childs()
    {
        return $this->hasMany('App\Category', 'father_id');
    }
    // public function padre()
    // {
    //     return $this->belongsTo(Category::class, 'father_id');
    // }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
