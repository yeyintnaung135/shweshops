<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ShopOwnersAndStaffs extends Authenticatable
{
    use Notifiable, SoftDeletes;

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
