<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionHasProducts extends Model
{
    protected $guarded = [];
    protected $table = 'collection_has_product';
    public $timestamps = false;
}
