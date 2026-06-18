<?php

namespace App\Http\Controllers;

use App\Models\RolePermission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
  /**
   * @OA\Get(
   *     path="/permissions/{locationId}/{moduleId}",
   *     summary="Get permissions for menu by location and module",
   *     tags={"Permissions"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="locationId",
   *         in="path",
   *         description="Location id",
   *         @OA\Schema(type="integer"),
   *         required=true,
   *         example=1
   *     ),
   *     @OA\Parameter(
   *         name="moduleId",
   *         in="path",
   *         description="Module id",
   *         @OA\Schema(type="integer"),
   *         required=true,
   *         example=1
   *     ),
   *     @OA\Response(
   *          response=200,
   *          description="Success",
   *          @OA\JsonContent(
   *              type="array",
   *              @OA\Items(ref="#/components/schemas/PermissionResponse")
   *          )
   *     )
   * )
   */
  public function getPermissionsForMenu($locationId, $moduleId) {
    $result = RolePermission::select('p.id', 'p.fxml_path', 'p.display_name', 'p.parent_id', 'p.depth', 'p.permission_type', 'p.active', 'p.created_at', 'p.updated_at')
              ->join('permissions AS p', 'p.id', '=', 'role_permissions.permission_id')
              ->where('p.active', 1)
              ->orderBy('p.permission_order')
              ->get();

    return response()->json($result, 200);
  }
}
