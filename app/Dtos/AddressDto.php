<?php

namespace App\Dtos;

use Carbon\Carbon;
use Cerbero\LaravelDto\Dto;

use const Cerbero\Dto\PARTIAL;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;

/**
 *  @OA\Schema(
 *     schema="AddressRequest",
 *     type="object",
 *     title="AddressRequest",
 *     description="Address request body",
 *     required={"addressType", "addressLine1"},
 *     @OA\Property(property="addressType", type="string", maxLength=20, description="Address type"),
 *     @OA\Property(property="addressLine1", type="string", maxLength=100, description="Address line 1"),
 *     @OA\Property(property="addressLine2", type="string", maxLength=100, description="Address line 2"),
 *     @OA\Property(property="addressLine3", type="string", maxLength=100, description="Address line 3"),
 *     @OA\Property(property="city", type="string", maxLength=100, description="City"),
 *     @OA\Property(property="district", type="string", maxLength=100, description="District"),
 *     @OA\Property(property="province", type="string", maxLength=50, description="Province"),
 *     @OA\Property(property="postalCode", type="string", maxLength=15, description="Postal code"),
 *     @OA\Property(property="isPrimary", type="integer", description="Primary address flag")
 * )
 *
 * @OA\Schema(
 *     schema="AddressResponse",
 *     type="object",
 *     title="AddressResponse",
 *     description="Address response model",
 *     @OA\Property(property="id", type="integer", description="Address id"),
 *     @OA\Property(property="addressType", type="string", description="Address type"),
 *     @OA\Property(property="addressLine1", type="string", description="Address line 1"),
 *     @OA\Property(property="addressLine2", type="string", description="Address line 2"),
 *     @OA\Property(property="addressLine3", type="string", description="Address line 3"),
 *     @OA\Property(property="city", type="string", description="City"),
 *     @OA\Property(property="district", type="string", description="District"),
 *     @OA\Property(property="province", type="string", description="Province"),
 *     @OA\Property(property="postalCode", type="string", description="Postal code"),
 *     @OA\Property(property="isPrimary", type="integer", description="Primary address flag"),
 *     @OA\Property(property="active", type="integer", description="Active status"),
 *     @OA\Property(property="createdBy", type="integer", description="User id who created the address"),
 *     @OA\Property(property="updatedBy", type="integer", description="User id who last updated the address"),
 *     @OA\Property(property="deletedBy", type="integer", description="User id who deleted the address")
 * )
 *
 * The data transfer object for the Address model.
 *
 * @property int|null $id
 * @property string $addressType
 * @property string $addressLine1
 * @property string|null $addressLine2
 * @property string|null $addressLine3
 * @property string|null $city
 * @property string|null $district
 * @property string|null $province
 * @property string|null $postalCode
 * @property int|null $isPrimary
 * @property int|null $active
 * @property int|null $createdBy
 * @property int|null $updatedBy
 * @property int|null $deletedBy
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property Carbon|null $deletedAt
 */
class AddressDto extends Dto
{
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
