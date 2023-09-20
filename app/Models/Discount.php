<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Discount extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['discount_price', 'discount_min', 'dec_price', 'discount_max', 'item_id', 'percent', 'shop_id', 'base', 'deleted_at'];

    protected $table = 'discount';
    protected $appends = ['MmPrice']; //this is for vue if you want to pass attribute to js json you set this

//    function items()
//    {
//        return $this->belongsTo('App\Item','item_id');
//    }

    public function shop()
    {
        return $this->belongsTo(Shops::class, 'shop_id');
    }

    public function getItembyDiscountAttribute()
    {
        $item = Item::where('id', $this->item_id)->first();
        return $item;
    }

    public function getShortPriceAttribute()
    {
        $shortprice = Str::limit($this->discount_min . '-' . $this->discount_max, 12, '...');
        return $shortprice;
    }

    public function getMmPriceAttribute()
    {

        if ($this->discount_price != 0) {
            $tempthaung = '';
            $tempthousand = '';
            //for exact price
            if ($this->discount_price > 99999) {
                $mmpricelakh = intval($this->discount_price / 100000) . ' သိန်း';

                if (($this->discount_price % 100000) > 9999) {
                    $tempthaung = intval(($this->discount_price % 100000) / 10000) . ' သောင်း';

                    //for ဝန်းကျင်ကျော် can hide

                    if ($tempthaung > 4) {
                        $tempthaung = '<span style="font-size:13px"> ဝန်းကျင် </span>';
                    } else {
                        $tempthaung = '<span style="font-size:13px"> ဝန်းကျင် </span>';

                    }
                    //for ဝန်းကျင်ကျော်
                    if ((($this->discount_price % 100000) % 10000) > 999) {
                        $tempthousand = intval((($this->discount_price % 100000) % 10000) / 1000) . ' ထောင်';

                    }
                }

                return $mmpricelakh . '' . $tempthaung;
            } else {
                if ($this->discount_price > 9999) {
                    $tempthaung = intval(($this->discount_price / 10000)) . ' သောင်း';

                    if (($this->discount_price % 10000) > 999) {

                        $tempthousand = intval((($this->discount_price % 100000) % 10000) / 1000) . ' ထောင်';

                    }
                    return $tempthaung . '' . $tempthousand;

                } else {
                    $tempthousand = intval($this->discount_price / 1000) . ' ထောင်';
                    return $tempthousand;
                }
            }
            //for exact price

        } else {
//            for min
            $tempthaung = '';
            $tempthousand = '';
            if ($this->discount_min > 99999) {
                $mmpricelakh = intval($this->discount_min / 100000);

                if (($this->discount_min % 100000) > 9999) {
                    $tempthaung = intval(($this->discount_min % 100000) / 10000) . ' သောင်း';
                    if ((($this->discount_min % 100000) % 10000) > 999) {
                        $tempthousand = intval((($this->discount_min % 100000) % 10000) / 1000) . ' ထောင်';

                    }
                }
                $minprice = $mmpricelakh;
            } else {
                if ($this->discount_min > 9999) {
                    $tempthaung = intval(($this->discount_min / 10000)) . ' သောင်း';

                    if (($this->discount_min % 10000) > 999) {

                        $tempthousand = intval((($this->discount_min % 100000) % 10000) / 1000) . ' ထောင်';

                    }
                    $minprice = $tempthaung;
                } else {
                    $tempthousand = intval($this->discount_min / 1000) . ' ထောင်';
                    $minprice = $tempthousand;
                }
            }
//            for min

            $max_pricethaung = '';
            $max_pricethousand = '';
            if ($this->discount_max > 99999) {
                $max_pricelakh = intval($this->discount_max / 100000) . ' သိန်း';

                if (($this->discount_max % 100000) > 9999) {
                    $max_pricethaung = intval(($this->discount_max % 100000) / 10000) . ' သောင်း';
                    if ((($this->discount_max % 100000) % 10000) > 999) {
                        $max_pricethousand = intval((($this->discount_max % 100000) % 10000) / 1000) . ' ထောင်';

                    }
//                if($max_pricethaung > 4){
//                    $max_pricethaung='ကျော်';
//                }else{
//                    $max_pricethaung='ဝန်းကျင်';
//
//                }
                }
//                $max_price=$max_pricelakh.''.$max_pricethaung.''.$max_pricethousand;

                //if thein is 2 digit i delete thaung
                if ($max_pricelakh > 9) {
                    $max_price = $max_pricelakh;

                } else {
                    $max_price = $max_pricelakh;

                }
            } else {
                //if price is thaung
                if ($this->discount_max > 9999) {
                    $max_pricethaung = intval(($this->discount_max / 10000)) . ' သောင်း';

                    if (($this->discount_max % 10000) > 999) {

                        $max_pricethousand = intval((($this->discount_max % 100000) % 10000) / 1000) . ' ထောင်';

                    }
                    $max_price = $max_pricethaung;
                } else {
                    $max_pricethousand = intval($this->discount_max / 1000) . ' ထောင်';
                    $max_price = $max_pricethousand;
                }
            }
            //for max

            return Str::limit($minprice . '-' . $max_price, 21, '...') . '<span style="font-size:13px"> ကြား </span>';

        }
    }

}
