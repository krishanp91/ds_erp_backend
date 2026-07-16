<?php

namespace App\Dtos;

use Carbon\Carbon;
use Cerbero\LaravelDto\Dto;

use const Cerbero\Dto\PARTIAL;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;

/**
 *  @OA\Schema(
 *     schema="TaxRequest",
 *     type="object",
 *     title="TaxRequest",
 *     description="Tax request body",
 *     required={"name", "rate", "type", "calculationMethod", "isActive"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the tax"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the tax"
 *     ),
 *     @OA\Property(
 *         property="rate",
 *         type="integer",
 *         description="Tax rate"
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Tax type"
 *     ),
 *     @OA\Property(
 *         property="calculationMethod",
 *         type="string",
 *         description="Calculation method"
 *     ),
 *     @OA\Property(
 *         property="isActive",
 *         type="integer",
 *         description="Active status of the tax"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="TaxResponse",
 *     type="object",
 *     title="TaxResponse",
 *     description="Tax response model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the tax"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the tax"
 *     ),
 *     @OA\Property(
 *         property="rate",
 *         type="integer",
 *         description="Tax rate"
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Tax type"
 *     ),
 *     @OA\Property(
 *         property="calculationMethod",
 *         type="string",
 *         description="Calculation method"
 *     ),
 *     @OA\Property(
 *         property="isActive",
 *         type="integer",
 *         description="Active status of the tax"
 *     )
 * )
 *
 * The data transfer object for the Tax model.
 *
 * @property int $id
 * @property string $name
 * @property int $rate
 * @property string $type
 * @property string $calculationMethod
 * @property int $isActive
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property Carbon|null $deletedAt
 */
class TaxDto extends Dto
{
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
