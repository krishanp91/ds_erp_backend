<?php

namespace App\Dtos;

use Carbon\Carbon;
use Cerbero\LaravelDto\Dto;

use const Cerbero\Dto\PARTIAL;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;

/**
 *  @OA\Schema(
 *     schema="ContactDetailRequest",
 *     type="object",
 *     title="ContactDetailRequest",
 *     description="Contact detail request body",
 *     required={"contactName", "isPrimary"},
 *     @OA\Property(property="contactName", type="string", maxLength=200, description="Contact name"),
 *     @OA\Property(property="designation", type="string", maxLength=200, description="Designation"),
 *     @OA\Property(property="email", type="string", maxLength=100, description="Email address"),
 *     @OA\Property(property="phone", type="string", maxLength=20, description="Phone number"),
 *     @OA\Property(property="mobile", type="string", maxLength=20, description="Mobile number"),
 *     @OA\Property(property="isPrimary", type="integer", description="Primary contact flag")
 * )
 *
 * @OA\Schema(
 *     schema="ContactDetailResponse",
 *     type="object",
 *     title="ContactDetailResponse",
 *     description="Contact detail response model",
 *     @OA\Property(property="id", type="integer", description="Contact detail id"),
 *     @OA\Property(property="contactName", type="string", description="Contact name"),
 *     @OA\Property(property="designation", type="string", description="Designation"),
 *     @OA\Property(property="email", type="string", description="Email address"),
 *     @OA\Property(property="phone", type="string", description="Phone number"),
 *     @OA\Property(property="mobile", type="string", description="Mobile number"),
 *     @OA\Property(property="isPrimary", type="integer", description="Primary contact flag"),
 *     @OA\Property(property="createdBy", type="integer", description="User id who created the contact"),
 *     @OA\Property(property="updatedBy", type="integer", description="User id who last updated the contact"),
 *     @OA\Property(property="deletedBy", type="integer", description="User id who deleted the contact")
 * )
 *
 * The data transfer object for the ContactDetail model.
 *
 * @property int|null $id
 * @property string $contactName
 * @property string|null $designation
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $mobile
 * @property int $isPrimary
 * @property int|null $createdBy
 * @property int|null $updatedBy
 * @property int|null $deletedBy
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property Carbon|null $deletedAt
 */
class ContactDetailDto extends Dto
{
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
