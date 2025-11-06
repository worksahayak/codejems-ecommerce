<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function colorDetails()
    {
        return $this->hasMany(ProductColorDetail::class, 'product_id');
    }

}
