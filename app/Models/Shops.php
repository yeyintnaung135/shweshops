<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Shops extends Authenticatable
{
    //
    use Notifiable, SoftDeletes;

    protected $table = 'shops';

    protected $fillable = [
        'other_address', 'messenger_link', 'page_link', 'main_phone', 'premium',
        'name', 'shop_name_url', 'shop_logo', 'password', 'active',
        'email', 'shop_name', 'shop_name_myan', 'description', 'active',
        'အထည်မပျက်_ပြန်သွင်း', 'တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ', 'အထည်ပျက်စီးချို့ယွင်း', 'address', 'map',
        'additional_phones', 'state', 'township', 'deleted_at', 'pos_only', 'premium_template_id',
    ];
    protected $appends = ['ConnectedwithFacebook', 'WithoutspaceShopname', 'Ykmessengerlink', 'favIds', 'selectionIds', 'notification'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function premiumTemplate()
    {
        return $this->belongsTo(PremiumTemplate::class);
    }

    public function getPhotos()
    {
        return $this->hasMany(ShopBanner::class, 'shop_owner_id');
    }

    public function getWithoutspaceShopnameAttribute()
    {
        // return str_replace(' ','',$this->shop_name);
        if (!empty($this->shop_name_url)) {
            $shopurl = $this->shop_name_url;
        } else {
            $shopurl = str_replace(' ', '', $this->shop_name);
        }
        return $shopurl;
    }

    public function getFavIdsAttribute()
    {
        if (isset(Auth::guard('shop_owners_and_staffs')->user()->id)) {
            $fav_ids = ShopOwnersFav::where('user_id', $this->id)->get();
            return $fav_ids;
        }
        return ('');
    }
    public function getSelectionIdsAttribute()
    {
        if (isset(Auth::guard('shop_owners_and_staffs')->user()->id)) {
            $selection_ids = ShopOwnersSelection::where('user_id', $this->id)->get();
            return $selection_ids;
        }
        return ('');
    }
    public function getNotificationAttribute()
    {
        if (isset(Auth::guard('shop_owners_and_staffs')->user()->id)) {
            $noti = Usernoti::where('receiver_user_id', $this->id)->where('user_type', 'shop_owners')->where('read_by_receiver', 0)->get();
            return $noti;
        }
        return ('');
    }
    public function getYkmessengerlinkAttribute()
    {
        $check_facebook_function = \App\Models\sitesettings::where('name', 'facebook')->first();

        $check_connect = \App\Models\facebooktable::where('shop_id', $this->id);
        if ($check_facebook_function->action == 'on' and ($check_connect->count() != 0)) {
            return 'http://m.me/' . $check_connect->first()->page_id;
        } else {
            return $this->messenger_link;
        }
    }
    public function getConnectedwithFacebookAttribute()
    {
        $check_facebook_function = \App\Models\sitesettings::where('name', 'facebook')->first();

        $check_connect = \App\Models\facebooktable::where('shop_id', $this->id);
        if ($check_facebook_function->action == 'on' and ($check_connect->count() != 0)) {
            return 'yes';
        } else {
            return 'no';
        }
    }
}
