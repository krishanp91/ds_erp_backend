<?php

namespace App\Dtos;

use Carbon\Carbon;
use Cerbero\LaravelDto\Dto;

use const Cerbero\Dto\PARTIAL;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;

/**
 * @OA\Schema(
 *     schema="UserRequest",
 *     type="object",
 *     title="UserRequest",
 *     description="User request body",
 *     required={"id", "name", "email", "password", "userRoleId", "active", "locations", "modules"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the user"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Full name of the user"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="Email of the user"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="Login Password of the user"
 *     ),
 *     @OA\Property(
 *         property="userRoleId",
 *         type="int",
 *         description="Id of the user role associated with the user"
 *     ),
 *     @OA\Property(
 *         property="active",
 *         type="int",
 *         description="Active status of the user"
 *     ),
 *     @OA\Property(
 *         property="locations",
 *         type="array",
 *         example={1, 2},
 *         description="Location ids, the user can log in",
 *         @OA\Items(type="int", example=1)
 *     ),
 *     @OA\Property(
 *         property="modules",
 *         type="array",
 *         example={1, 2},
 *         description="Module ids, the user can access",
 *         @OA\Items(type="int", example=1)
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="LoginRequest",
 *     type="object",
 *     title="LoginRequest",
 *     description="Login credentials",
 *     required={"email", "password"},
 *     @OA\Property(property="email", type="string", format="email", description="User email"),
 *     @OA\Property(property="password", type="string", description="User password")
 * )
 *
 * @OA\Schema(
 *     schema="RegisterRequest",
 *     type="object",
 *     title="RegisterRequest",
 *     description="User registration body",
 *     required={"name", "email", "password", "password_confirmation"},
 *     @OA\Property(property="name", type="string", description="Full name of the user"),
 *     @OA\Property(property="email", type="string", format="email", description="User email"),
 *     @OA\Property(property="password", type="string", description="User password"),
 *     @OA\Property(property="password_confirmation", type="string", description="Password confirmation")
 * )
 *
 * @OA\Schema(
 *     schema="UserResponse",
 *     type="object",
 *     title="UserResponse",
 *     description="Authenticated user response",
 *     @OA\Property(property="id", type="integer", description="Unique identifier for the user"),
 *     @OA\Property(property="name", type="string", description="Full name of the user"),
 *     @OA\Property(property="email", type="string", description="Email of the user"),
 *     @OA\Property(property="user_role_id", type="integer", description="User role id"),
 *     @OA\Property(property="active", type="integer", description="Active status of the user"),
 *     @OA\Property(property="token", type="string", description="JWT access token"),
 *     @OA\Property(
 *         property="locations",
 *         type="array",
 *         description="Locations the user can access",
 *         @OA\Items(type="object")
 *     ),
 *     @OA\Property(
 *         property="modules",
 *         type="array",
 *         description="Modules the user can access",
 *         @OA\Items(type="object")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="PermissionResponse",
 *     type="object",
 *     title="PermissionResponse",
 *     description="Permission record",
 *     @OA\Property(property="id", type="integer", description="Permission id"),
 *     @OA\Property(property="permission_code", type="string", description="Permission code"),
 *     @OA\Property(property="fxml_path", type="string", description="FXML path for menu permission"),
 *     @OA\Property(property="display_name", type="string", description="Display name"),
 *     @OA\Property(property="parent_id", type="integer", description="Parent permission id"),
 *     @OA\Property(property="depth", type="integer", description="Permission depth in hierarchy"),
 *     @OA\Property(property="permission_type", type="string", description="Permission type"),
 *     @OA\Property(property="active", type="integer", description="Active status"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * The data transfer object for the User model.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $emailVerifiedAt
 * @property string $password
 * @property int $userRoleId
 * @property string|null $rememberToken
 * @property int $active
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property Carbon|null $deletedAt
 * @property LocationDto[] $locations
 * @property ModuleDto[] $modules
 */
class UserDto extends Dto
{
    /**
     * The default flags.
     *
     * @var int
     */
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
