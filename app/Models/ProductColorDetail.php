<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColorDetail extends Model
{
    protected $fillable = ['product_id', 'color_id', 'price', 'images'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
