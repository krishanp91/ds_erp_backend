<?php

namespace App\Dtos;

use Carbon\Carbon;
use Cerbero\LaravelDto\Dto;

use const Cerbero\Dto\PARTIAL;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;

/**
 *  @OA\Schema(
 *     schema="SupplierRequest",
 *     type="object",
 *     title="SupplierRequest",
 *     description="Supplier request body. createdBy/updatedBy/deletedBy are set by the server from the authenticated user and must not be sent. supplierCode is required on create only and cannot be changed on update.",
 *     required={"supplierCode", "supplierName", "active"},
 *     @OA\Property(property="supplierCode", type="string", maxLength=50, description="Supplier code (create only; ignored on update)"),
 *     @OA\Property(property="supplierName", type="string", maxLength=200, description="Supplier name"),
 *     @OA\Property(property="creditLimit", type="number", description="Credit limit"),
 *     @OA\Property(property="creditPeriod", type="integer", description="Credit period in days"),
 *     @OA\Property(property="taxCategoryId", type="integer", description="Tax category id"),
 *     @OA\Property(property="active", type="integer", description="Active status"),
 *     @OA\Property(
 *         property="contacts",
 *         type="array",
 *         description="Supplier contacts",
 *         @OA\Items(ref="#/components/schemas/ContactDetailRequest")
 *     ),
 *     @OA\Property(
 *         property="addresses",
 *         type="array",
 *         description="Supplier addresses",
 *         @OA\Items(ref="#/components/schemas/AddressRequest")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="SupplierResponse",
 *     type="object",
 *     title="SupplierResponse",
 *     description="Supplier response model",
 *     @OA\Property(property="id", type="integer", description="Supplier id"),
 *     @OA\Property(property="supplierCode", type="string", description="Supplier code"),
 *     @OA\Property(property="supplierName", type="string", description="Supplier name"),
 *     @OA\Property(property="creditLimit", type="number", description="Credit limit"),
 *     @OA\Property(property="creditPeriod", type="integer", description="Credit period in days"),
 *     @OA\Property(property="taxCategoryId", type="integer", description="Tax category id"),
 *     @OA\Property(property="active", type="integer", description="Active status"),
 *     @OA\Property(property="createdBy", type="integer", description="User id who created the supplier"),
 *     @OA\Property(property="updatedBy", type="integer", description="User id who last updated the supplier"),
 *     @OA\Property(property="deletedBy", type="integer", description="User id who deleted the supplier"),
 *     @OA\Property(
 *         property="taxCategory",
 *         ref="#/components/schemas/TaxCategoryResponse",
 *         description="Related tax category"
 *     ),
 *     @OA\Property(
 *         property="contacts",
 *         type="array",
 *         description="Supplier contacts",
 *         @OA\Items(ref="#/components/schemas/ContactDetailResponse")
 *     ),
 *     @OA\Property(
 *         property="addresses",
 *         type="array",
 *         description="Supplier addresses",
 *         @OA\Items(ref="#/components/schemas/AddressResponse")
 *     )
 * )
 *
 * The data transfer object for the Supplier model.
 *
 * @property int|null $id
 * @property string $supplierCode
 * @property string $supplierName
 * @property float|null $creditLimit
 * @property int|null $creditPeriod
 * @property int|null $taxCategoryId
 * @property int $active
 * @property int|null $createdBy
 * @property int|null $updatedBy
 * @property int|null $deletedBy
 * @property TaxCategoryDto|null $taxCategory
 * @property ContactDetailDto[]|null $contacts
 * @property AddressDto[]|null $addresses
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property Carbon|null $deletedAt
 */
class SupplierDto extends Dto
{
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
