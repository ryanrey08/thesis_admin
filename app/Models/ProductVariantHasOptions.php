<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantHasOptions extends Model
{
    protected $guarded = [];
    protected $table = 'product_variant_has_option';
    public $timestamps = false;
}
