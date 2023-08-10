<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopOwnersAndStaffs extends Authenticatable
{
    use Notifiable;

    protected $table = 'shop_owners_and_staffs';

    protected $fillable = [
        'name', 'phone', 'shop_id', 'role_id', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
