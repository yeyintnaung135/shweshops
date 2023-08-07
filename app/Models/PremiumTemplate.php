<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PremiumTemplate extends Model
{
    protected $table = 'premium_templates';

    protected $fillable = [
        'name',
    ];

    public function shopOwners()
    {
        return $this->hasMany(Shopowner::class);
    }
}
