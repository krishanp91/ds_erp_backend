<?php

namespace App\Dtos;

use Carbon\Carbon;
use Cerbero\LaravelDto\Dto;

use const Cerbero\Dto\PARTIAL;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;

/**
 *  @OA\Schema(
 *     schema="TaxCategoryTaxRequest",
 *     type="object",
 *     title="TaxCategoryTaxRequest",
 *     description="Tax category tax request body",
 *     required={"taxCategoryId", "taxId", "sequence"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the tax category tax"
 *     ),
 *     @OA\Property(
 *         property="taxCategoryId",
 *         type="integer",
 *         description="Tax category id"
 *     ),
 *     @OA\Property(
 *         property="taxId",
 *         type="integer",
 *         description="Tax id"
 *     ),
 *     @OA\Property(
 *         property="sequence",
 *         type="integer",
 *         description="Sequence order"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="TaxCategoryTaxResponse",
 *     type="object",
 *     title="TaxCategoryTaxResponse",
 *     description="Tax category tax response model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the tax category tax"
 *     ),
 *     @OA\Property(
 *         property="taxCategoryId",
 *         type="integer",
 *         description="Tax category id"
 *     ),
 *     @OA\Property(
 *         property="taxId",
 *         type="integer",
 *         description="Tax id"
 *     ),
 *     @OA\Property(
 *         property="sequence",
 *         type="integer",
 *         description="Sequence order"
 *     ),
 *     @OA\Property(
 *         property="taxCategory",
 *         ref="#/components/schemas/TaxCategoryResponse",
 *         description="Related tax category"
 *     ),
 *     @OA\Property(
 *         property="tax",
 *         ref="#/components/schemas/TaxResponse",
 *         description="Related tax"
 *     )
 * )
 *
 * The data transfer object for the TaxCategoryTax model.
 *
 * @property int $id
 * @property int $taxCategoryId
 * @property int $taxId
 * @property int $sequence
 * @property TaxCategoryDto|null $taxCategory
 * @property TaxDto|null $tax
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property Carbon|null $deletedAt
 */
class TaxCategoryTaxDto extends Dto
{
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
