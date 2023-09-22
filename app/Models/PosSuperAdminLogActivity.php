<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosSuperAdminLogActivity extends Model
{
    use HasFactory;

    protected $table = 'pos_superadmin_log_activities';
    protected $fillable = [
        'name', 'type', 'type_name', 'type_id', 'status', 'role', 'role_id',
    ];
}
