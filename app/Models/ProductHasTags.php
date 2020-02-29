<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductHasTags extends Model
{
    protected $guarded = [];
    protected $table = 'product_has_tag';
    public $timestamps = false;
}
