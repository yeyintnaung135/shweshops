<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosAssignGoldPrice extends Model
{
    //
    protected $fillable = ['date', 'shop_owner_id', 'open_price', 'shop_price', 'price_16',
        'outprice_15', 'inprice_15',
        'outprice_14', 'inprice_14',
        'outprice_14_2', 'inprice_14_2',
        'outprice_13', 'inprice_13',
        'outprice_12', 'inprice_12',
        'outprice_12_2', 'inprice_12_2',
    ];

}
