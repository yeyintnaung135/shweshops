<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 use Illuminate\Foundation\Auth\User as Authenticatable;


use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class PosSuperAdmin extends Authenticatable
{
    use Notifiable;
//    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table = 'pos_super_admins';

    protected $fillable = [
        'name','email', 'password','active'
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
}
