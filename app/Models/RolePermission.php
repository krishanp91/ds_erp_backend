<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $fillable = [
        'role_id', 'permission_id', 'updated_by'
    ];

    public function permission()
    {
        return $this->belongsTo('App\Permission', 'permission_id'); 
    }

    public function role()
    {
        return $this->belongsTo('App\UserRole', 'role_id'); 
    }
}
