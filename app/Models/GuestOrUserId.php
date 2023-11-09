<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestOrUserId extends Model
{
    //
    protected $table = 'guestoruserid';
    protected $fillable = ['guest_id', 'user_id', 'ip', 'user_agent'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function logs()
    {
        return $this->hasMany(FrontUserLogs::class,'userorguestid');
        
    }
}
