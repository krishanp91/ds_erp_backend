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
