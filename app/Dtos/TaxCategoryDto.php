<?php

namespace App\Dtos;

use Carbon\Carbon;
use Cerbero\LaravelDto\Dto;

use const Cerbero\Dto\PARTIAL;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;

/**
 *  @OA\Schema(
 *     schema="TaxCategoryRequest",
 *     type="object",
 *     title="TaxCategoryRequest",
 *     description="Tax category request body",
 *     required={"name", "isActive"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the tax category"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the tax category"
 *     ),
 *     @OA\Property(
 *         property="isActive",
 *         type="integer",
 *         description="Active status of the tax category"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="TaxCategoryResponse",
 *     type="object",
 *     title="TaxCategoryResponse",
 *     description="Tax category response model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the tax category"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the tax category"
 *     ),
 *     @OA\Property(
 *         property="isActive",
 *         type="integer",
 *         description="Active status of the tax category"
 *     )
 * )
 *
 * The data transfer object for the TaxCategory model.
 *
 * @property int $id
 * @property string $name
 * @property int $isActive
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property Carbon|null $deletedAt
 */
class TaxCategoryDto extends Dto
{
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
