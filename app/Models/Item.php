<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Item extends Model
{
    //
    use \Conner\Tagging\Taggable , SoftDeletes;

    protected $fillable = ['id', 'main_category', 'diamond', 'gender', 'size', 'handmade', 'charge', 'carat', 'yati', 'pwint', 'd_gram', 'stock_count', 'product_code', 'photo_one', 'collection_id', 'min_price', 'max_price', 'weight_unit', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_five', 'photo_six', 'default_photo', 'view_count', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten', 'name', 'price', 'description', 'shop_id', 'gold_quality', 'gold_colour', 'sizing_guide', 'undamaged_product', 'valuable_product', 'damaged_product', 'weight', 'review', 'stock', 'category_id', 'user_id'];

    //NOTE Upper Cases are for vue to pass attribute to JS as json

    //NOTE lower cases are accessors for datatables

    protected $appends = ['MainCategoryName', 'ShopName', 'CheckPhotothumbs', 'CheckPhotobig', 'WithoutspaceShopname', 'GemsData', 'YkView', 'YkgetDiscount', 'CheckPhoto', 'YkbeautyCat', 'ShopName', 'ShortPrice', 'MmPrice', 'UserName', 'check_photothumbs'];

    protected $hidden = ['password'];

    //    public function discount()
    //    {
    //        return $this->hasOne('App\discount','item_id');
    //    }

    public function shop()
    {
        return $this->belongsTo(Shops::class, 'shop_id');
    }

    public function getMainCategoryNameAttribute()
    {
        $maincat = MainCategory::where('id', $this->main_category)->first();
        if (empty($maincat->name)) {
            $maincatdata = 'empty';
        } else {
            $maincatdata = $maincat->name;
        }
        return $maincatdata;
    }

    public function getWithoutspaceShopnameAttribute()
    {
        $shop_name_for_space = Shops::select('id', 'shop_name', 'shop_name_url')->where('id', $this->shop_id)->first();
        if (empty($shop_name_for_space)) {
            return 'noshop' . $this->shop_id;
        } else {
            // return str_replace(' ', '', $shop_name_for_space->shop_name);
            if (!empty($shop_name_for_space->shop_name_url)) {
                $shopurl = $shop_name_for_space->shop_name_url;
            } else {
                $shopurl = str_replace(' ', '', $shop_name_for_space->shop_name);
            }
            return $shopurl;
        }
    }

    public function getGemsDataAttribute()
    {
        $gems = Gems::where('item_id', $this->id)->first();
        if (empty($gems->gems)) {
            $gemdata = 'empty';
        } else {
            $gemdata = $gems->gems;
        }
        return $gemdata;
    }

    public function getShopNameAttribute()
    {
        $shop_name = Shops::select('shop_logo', 'shop_name')->where('id', $this->shop_id)->first();
        return $shop_name;
    }

    public function getShortPriceAttribute()
    {
        $shortprice = Str::limit($this->min_price . '-' . $this->max_price, 12, '...');
        return $shortprice;
    }

    public function getFormattedPriceAttribute()
    {
        if ($this->attributes['price'] != 0) {
            return number_format($this->attributes['price']);
        } elseif ($this->attributes['min_price'] != 0 && $this->attributes['max_price'] != 0) {
            $minPrice = number_format($this->attributes['min_price']);
            $maxPrice = number_format($this->attributes['max_price']);
            return $minPrice . ' - ' . $maxPrice;
        }
    }

    public function getCheckPhotoAttribute()
    {
        $photo_column = ['photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten'];

        if ($this->default_photo == '' or !dofile_exists('/items/' . $this->default_photo)) {
            foreach ($photo_column as $pc) {
                if ($this[$pc] != '') {
                    $show_photo = $this[$pc];
                    if (dofile_exists('/items/mid/' . $show_photo)) {
                        return '/items/mid/' . $show_photo;
                    } else {
                        return '/items/' . $show_photo;
                    }
                    break;
                }
            }
        } else {
            if (dofile_exists('/items/mid/' . $this->default_photo)) {

                return '/items/' . $this->default_photo;
            } else {
                return '/items/' . $this->default_photo;
            }
        }
    }

    public function getCheckPhotothumbsAttribute()
    {
        $photo_column = ['photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten'];
        if ($this->default_photo == '' or !dofile_exists('/items/thumbs/' . $this->default_photo)) {
            foreach ($photo_column as $pc) {
                if ($this[$pc] != '') {
                    $show_photo = $this[$pc];
                    if (dofile_exists('/items/thumbs/' . $show_photo)) {

                        return '/items/thumbs/' . $show_photo;
                    } else {
                        return '/items/thumbs/' . $show_photo;
                    }

                    break;
                }
            }
        } else {
            if (dofile_exists('/items/thumbs/' . $this->default_photo)) {

                return '/items/thumbs/' . $this->default_photo;
            } else {
                return '/items/thumbs/' . $this->default_photo;
            }
        }
    }

    public function getCheckPhotobigAttribute()
    {
        $photo_column = ['photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten'];
        if ($this->default_photo == '') {
            foreach ($photo_column as $pc) {
                if ($this[$pc] != '') {
                    $show_photo = $this[$pc];
                    return '/items/' . $show_photo;

                    break;
                }
            }
        } else {
            return '/items/' . $this->default_photo;
        }
    }

    public function getYkbeautyCatAttribute()
    {
        switch ($this->category_id) {
            case 'hair_pin':
                return 'ဆံထိုး';
                break;
            case 'hair_clip':
                return 'ကလစ်';
                break;
            case 'comb':
                return 'ဘီး';
                break;
            case 'headband':
                return 'ဘီးကုတ်';
                break;
            case 'necklace':
                return 'ဆွဲကြိုး';
                break;
            case 'bayat':
                return 'ဘယက်';
                break;
            case 'pendant':
                return 'လောကပ်သီး';
                break;
            case 'earring':
                return 'နားကပ်';
                break;
            case 'nrrswel':
                return 'နားဆွဲ';
                break;
            case 'brooch':
                return 'ရင်ထိုး';
                break;
            case 'ring':
                return 'လက်စွပ်';
                break;
            case 'braceket':
                return 'လက်ကောက်';
                break;
            case 'hand_chain':
                return 'ဟန်းချိန်း';
                break;
            case 'pixiu':
                return 'ပီချူး';
                break;
            case 'footchain':
                return 'ခြေကျင်း';
                break;
            case 'accessories':
                return 'Accessories';
                break;
            case 'swal_tee':
                return 'ဆွဲသီး';
                break;
        }
    }

    //mutators
    public function getYkViewAttribute()
    {
        if ($this->view_count >= 1000 and $this->view_count < 1000000) {
            $tnmpcount = ($this->view_count / 1000);
            if ($tnmpcount > 1.1) {
                $tnmpcount = round($tnmpcount, 1);
            }
            return $tnmpcount . 'K';
        } else {
            if ($this->view_count >= 1000000 and $this->view_count < 1000000000) {
                $tnmpcount = ($this->view_count / 1000000);
                if ($tnmpcount > 1.1) {
                    $tnmpcount = round($tnmpcount, 1);
                }
                return $tnmpcount . 'M';
            } else {
                if ($this->view_count >= 1000000000) {
                    $tnmpcount = ($this->view_count / 1000000000);
                    if ($tnmpcount > 1.1) {
                        $tnmpcount = round($tnmpcount, 1);
                    }
                    return $tnmpcount . 'B';
                } else {
                    return $this->view_count;
                }
            }
        }
    }

    public function getCheckDiscountAttribute()
    {
        $discount = Discount::where('item_id', $this->id)->first();

        return $discount ? $discount->id : 0;
    }

    public function getYkgetDiscountAttribute()
    {
        $discount = Discount::where('item_id', $this->id)->first();

        return $discount ?? 0;
    }

    public function getUserNameAttribute()
    {
        if ((isset(Auth::guard('shop_owners_and_staffs')->user()->id) && Auth::guard('shop_owners_and_staffs')->user()->id == $this->shop_id)) {
            if ($this->user_id != 0) {
                return Auth::guard('shop_owners_and_staffs')->user()->name;

            } else {
                return (0);
            }
        } else {
            return '';
        }
    }

    public function getMmPriceAttribute()
    {

        if ($this->price != 0) {
            $tempthaung = '';
            $tempthousand = '';
            //for exact price
            if ($this->price > 99999) {
                $mmpricelakh = intval($this->price / 100000) . ' သိန်း';

                if (($this->price % 100000) > 9999) {
                    $tempthaung = intval(($this->price % 100000) / 10000) . 'သောင်း';

                    //for ဝန်းကျင်ကျော် can hide

                    if ($tempthaung > 4) {
                        $tempthaung = '<span style="font-size:13px"> ဝန်းကျင် </span>';
                    } else {
                        // $tempthaung=' <span style="font-size:13px"> ဝန်းကျင် </span>';
                        $tempthaung = ' <span style="font-size:13px"> ဝန်းကျင် </span>';
                    }
                    //for ဝန်းကျင်ကျော်
                    if ((($this->price % 100000) % 10000) > 999) {
                        $tempthousand = intval((($this->price % 100000) % 10000) / 1000) . 'ထောင်';
                    }
                }

                return $mmpricelakh . '' . $tempthaung;
            } else {
                if ($this->price > 9999) {
                    $tempthaung = intval(($this->price / 10000)) . 'သောင်း';

                    if (($this->price % 10000) > 999) {

                        $tempthousand = intval((($this->price % 100000) % 10000) / 1000) . 'ထောင်';
                    }
                    return $tempthaung . '' . $tempthousand;
                } else {
                    $tempthousand = intval($this->price / 1000) . 'ထောင်';
                    return $tempthousand;
                }
            }
            //for exact price

        } else {
            //            for min
            $tempthaung = '';
            $tempthousand = '';
            if ($this->min_price > 99999) {
                $mmpricelakh = intval($this->min_price / 100000);

                if (($this->min_price % 100000) > 9999) {
                    $tempthaung = intval(($this->min_price % 100000) / 10000) . 'သောင်း';
                    if ((($this->min_price % 100000) % 10000) > 999) {
                        $tempthousand = intval((($this->min_price % 100000) % 10000) / 1000) . 'ထောင်';
                    }
                }
                $minprice = $mmpricelakh;
            } else {
                if ($this->min_price > 9999) {
                    $tempthaung = intval(($this->min_price / 10000)) . 'သောင်း';

                    if (($this->min_price % 10000) > 999) {

                        $tempthousand = intval((($this->min_price % 100000) % 10000) / 1000) . 'ထောင်';
                    }
                    $minprice = $tempthaung;
                } else {
                    $tempthousand = intval($this->min_price / 1000) . 'ထောင်';
                    $minprice = $tempthousand;
                }
            }
            //            for min

            $max_pricethaung = '';
            $max_pricethousand = '';
            if ($this->max_price > 99999) {
                $max_pricelakh = intval($this->max_price / 100000) . ' သိန်း';

                if (($this->max_price % 100000) > 9999) {
                    $max_pricethaung = intval(($this->max_price % 100000) / 10000) . 'သောင်း';
                    if ((($this->max_price % 100000) % 10000) > 999) {
                        $max_pricethousand = intval((($this->max_price % 100000) % 10000) / 1000) . 'ထောင်';
                    }
                    //                if($max_pricethaung > 4){
                    //                    $max_pricethaung=' ကျော်';
                    //                }else{
                    //                    $max_pricethaung=' ဝန်းကျင်';
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
                if ($this->max_price > 9999) {
                    $max_pricethaung = intval(($this->max_price / 10000)) . 'သောင်း';

                    if (($this->max_price % 10000) > 999) {

                        $max_pricethousand = intval((($this->max_price % 100000) % 10000) / 1000) . 'ထောင်';
                    }
                    $max_price = $max_pricethaung;
                } else {
                    $max_pricethousand = intval($this->max_price / 1000) . 'ထောင်';
                    $max_price = $max_pricethousand;
                }
            }
            //for max
            $forcheck = str_replace('သိန်း', '', $max_price);

            if ($minprice == $forcheck) {
                return $max_price . '<span style="font-size:13px"> ဝန်းကျင် </span>';
            } else {
                if ($minprice != '0ထောင်' && $max_price != '0ထောင်') {
                    return Str::limit($minprice . '-' . $max_price, 21, '...') . '<span style="font-size:13px"> ကြား </span>';
                } else {
                    return $max_price . '<span style="font-size:13px"> ဝန်းကျင် </span>';
                }
            }
        }
    }
}
