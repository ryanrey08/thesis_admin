<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class ProductTransactions extends Model
{
    protected $guarded = [];
    protected $table = 'transaction_has_item';
    public $timestamps = false;
}
