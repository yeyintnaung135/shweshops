<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FeaturesForShops extends Model
{
    //
    protected $table = 'features_for_shop';
    protected $fillable = ['shop_id', 'feature'];
    public function shops():BelongsToMany
    {
        return $this->belongsToMany(Shops::class, 'shop_id');

        
    }
}
