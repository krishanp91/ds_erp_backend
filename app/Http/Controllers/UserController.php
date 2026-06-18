<?php

namespace App\Http\Controllers;

use JWTAuth;
use Auth;

use App\Models\User;
use App\Models\RolePermission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
  /**
   * @OA\Post(
   *     path="/login",
   *     summary="Authenticate user and obtain JWT token",
   *     tags={"Authentication"},
   *     @OA\RequestBody(
   *          required=true,
   *          @OA\JsonContent(ref="#/components/schemas/LoginRequest")
   *     ),
   *     @OA\Response(
   *          response=200,
   *          description="Successful authentication",
   *          @OA\JsonContent(ref="#/components/schemas/UserResponse")
   *     ),
   *     @OA\Response(response=401, description="Invalid credentials"),
   *     @OA\Response(response=500, description="Could not create token")
   * )
   */
  public function authenticate(Request $request)
  {
    $this->middleware('auth:api', ['except' => ['login', 'refresh']]);

    $credentials = $request->only('email', 'password');

    try {
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['status' => 'Invalid Username and/or Password'], 401);
        }
    } catch (JWTException $e) {
        return response()->json(['status' => 'Could not Create Token. Please Try Again.'], 500);
    }

    User::find(Auth::id());

    $user = User::with('locations')->with('modules')->find(Auth::id());

    $user->token = $token;

    return response()->json($user, 200);
  }

  private function getPermissionsForUserRole($userRoleId)
  {
    $result = RolePermission::select('p.id', 'p.permission_code', 'p.display_name', 'p.parent_id', 'p.depth', 'p.permission_type', 'p.active', 'p.created_at', 'p.updated_at')
              ->join('permissions AS p', 'p.id', '=', 'role_permissions.permission_id')
              ->where('role_permissions.user_role_id', $userRoleId)
              ->where('p.active', 1)
              ->orderBy('p.permission_order')
              ->get();

    return $result;
  }

  /**
   * @OA\Post(
   *     path="/register",
   *     summary="Register a new user",
   *     tags={"Authentication"},
   *     @OA\RequestBody(
   *          required=true,
   *          @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
   *     ),
   *     @OA\Response(
   *          response=201,
   *          description="User registered successfully",
   *          @OA\JsonContent(
   *              type="object",
   *              @OA\Property(property="user", ref="#/components/schemas/UserResponse"),
   *              @OA\Property(property="token", type="string", description="JWT access token")
   *          )
   *     ),
   *     @OA\Response(response=400, description="Validation error")
   * )
   */
  public function register(Request $request) {
    $validator = Validator::make($request->json()->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
    }

    $user = User::create([
        'name' => $request->json()->get('name'),
        'email' => $request->json()->get('email'),
        'password' => Hash::make($request->json()->get('password')),
    ]);

    $token = JWTAuth::fromUser($user);

    return response()->json(compact('user','token'),201);
  }

  /**
   * @OA\Get(
   *     path="/user",
   *     summary="Get authenticated user",
   *     tags={"Users"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Response(
   *          response=200,
   *          description="Success",
   *          @OA\JsonContent(
   *              type="object",
   *              @OA\Property(property="user", ref="#/components/schemas/UserResponse")
   *          )
   *     ),
   *     @OA\Response(response=404, description="User not found"),
   *     @OA\Response(response=401, description="Token expired, invalid, or absent")
   * )
   */
  public function getAuthenticatedUser() {
    try {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }
    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
        return response()->json(['token_expired'], $e->getStatusCode());
    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
        return response()->json(['token_invalid'], $e->getStatusCode());
    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
        return response()->json(['token_absent'], $e->getStatusCode());
    }

    return response()->json(compact('user'));
  }

  /**
   * @OA\Get(
   *     path="/users/permissions/{locationId}/{moduleId}",
   *     summary="Get user permissions by location and module",
   *     tags={"Users"},
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
  public function getUserPermissionsByLocationAndModule($locationId, $moduleId) {
    $user = User::find(Auth::id());

    $result = RolePermission::select('p.id', 'p.permission_code', 'p.display_name', 'p.parent_id', 'p.depth', 'p.permission_type', 'p.active', 'p.created_at', 'p.updated_at')
              ->join('permissions AS p', 'p.id', '=', 'role_permissions.permission_id')
              ->join('location_permission AS l', 'l.permission_id', '=', 'p.id')
              ->where('role_permissions.user_role_id', $user->user_role_id)
              ->where('l.location_id', $locationId)
              ->where('p.module_id', $moduleId)
              ->where('p.active', 1)
              ->orderBy('p.permission_order')
              ->get();

    return response()->json($result, 200);
  }
}
