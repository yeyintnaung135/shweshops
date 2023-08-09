<?php

namespace App\Models;

use App\Events\Activeusers;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    use Notifiable;
    use HasPushSubscriptions;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'username', 'phone', 'gender', 'birth_day', 'password', 'otp', 'active', 'photo', 'send_baydin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $appends = ['favIds', 'selectionIds', 'notification'];

    public function getFavIdsAttribute()
    {
        $fav_ids = Users_fav::where('user_id', $this->id)->get();
        return $fav_ids;
    }
    public function getSelectionIdsAttribute()
    {
        $selection_ids = Users_selection::where('user_id', $this->id)->get();
        return $selection_ids;
    }
    public function getNotificationAttribute()
    {
        $noti = Usernoti::where('receiver_user_id', $this->id)->where('user_type', 'users')->where('read_by_receiver', 0)->get();
        return $noti;
    }
    public function isonline()
    {
        return $this->hasOne(Activeusers::class, 'users_id');
    }
}
