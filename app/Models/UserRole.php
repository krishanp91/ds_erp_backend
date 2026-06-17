<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $fillable = [
        'role_name', 'description', 'active'
    ];

    public function permissions() {
        return $this->hasMany('App\RolePermission', 'user_role_id', 'id');
    }

    public function grantedPermissions($roleId) {
        return $this->hasMany('App\RolePermission', 'user_role_id', 'id')
                    ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')
                    ->where('permissions.depth', 2)
                    ->where('role_permissions.role_id', $roleId)
                    ->where('permissions.active', 1);
    }
}