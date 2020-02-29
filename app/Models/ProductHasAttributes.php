<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductHasAttributes extends Model
{
    protected $guarded = [];
    protected $table = 'product_has_attributes';
    public $timestamps = false;
}
