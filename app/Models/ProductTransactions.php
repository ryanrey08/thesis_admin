<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class ProductTransactions extends Model
{
    protected $guarded = [];
    protected $table = 'products_transaction';
    public $timestamps = false;
}
