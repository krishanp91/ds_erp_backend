<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
  private function getPermissionsForMenu($locationId, $moduleId) {
    $result = RolePermission::select('p.id', 'p.fxml_path', 'p.display_name', 'p.parent_id', 'p.depth', 'p.permission_type', 'p.active', 'p.created_at', 'p.updated_at')
              ->join('permissions AS p', 'p.id', '=', 'role_permissions.permission_id')
              // ->where('p.user_role_id', $userRoleId)
              ->where('p.active', 1)
              ->orderBy('p.permission_order')
              ->get();

    return $result;
  }
}
