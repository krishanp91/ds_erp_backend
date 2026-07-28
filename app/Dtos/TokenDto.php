<?php

namespace App\Dtos;

use Cerbero\LaravelDto\Dto;

use const Cerbero\Dto\PARTIAL;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;

/**
 * @OA\Schema(
 *     schema="TokenResponse",
 *     type="object",
 *     title="TokenResponse",
 *     description="JWT token refresh response",
 *     @OA\Property(property="accessToken", type="string", description="JWT access token"),
 *     @OA\Property(property="tokenType", type="string", example="bearer"),
 *     @OA\Property(property="expiresIn", type="integer", description="Access token lifetime in seconds", example=900),
 *     @OA\Property(property="refreshExpiresIn", type="integer", description="Maximum refresh window in seconds from login", example=86400)
 * )
 *
 * The data transfer object for JWT token responses.
 *
 * @property string $accessToken
 * @property string $tokenType
 * @property int $expiresIn
 * @property int $refreshExpiresIn
 */
class TokenDto extends Dto
{
    /**
     * The default flags.
     *
     * @var int
     */
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
