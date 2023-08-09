<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderForDinger extends Model
{
    //
    protected $table = 'order_dinger';
    protected $fillable = ['user_id', 'item_id', 'item_counts', 'status', 'amount', 'qr', 'transaction_no'];
}
