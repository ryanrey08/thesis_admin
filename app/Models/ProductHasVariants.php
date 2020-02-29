<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductHasVariants extends Model
{
    protected $guarded = [];
    protected $table = 'product_has_variant';
    public $timestamps = false;
}
