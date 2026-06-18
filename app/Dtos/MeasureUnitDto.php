<?php

namespace App\Dtos;

use Carbon\Carbon;
use Cerbero\LaravelDto\Dto;

use const Cerbero\Dto\PARTIAL;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;

/**
 * @OA\Schema(
 *     schema="MeasureUnitRequest",
 *     type="object",
 *     title="MeasureUnitRequest",
 *     description="Measure unit request body",
 *     required={"unitName"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the measure unit"
 *     ),
 *     @OA\Property(
 *         property="unitName",
 *         type="string",
 *         description="Name of the measure unit"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the measure unit"
 *     ),
 *     @OA\Property(
 *         property="active",
 *         type="integer",
 *         description="Active status of the measure unit"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="MeasureUnitResponse",
 *     type="object",
 *     title="MeasureUnitResponse",
 *     description="Measure unit response model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the measure unit"
 *     ),
 *     @OA\Property(
 *         property="unit_name",
 *         type="string",
 *         description="Name of the measure unit"
 *     ),
 *     @OA\Property(
 *         property="unit_code",
 *         type="string",
 *         description="Code of the measure unit"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the measure unit"
 *     ),
 *     @OA\Property(
 *         property="active",
 *         type="integer",
 *         description="Active status of the measure unit"
 *     )
 * )
 *
 * The data transfer object for the MeasureUnit model.
 *
 * @property int $id
 * @property string|null $unitName
 * @property string|null $description
 * @property bool $active
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property Carbon|null $deletedAt
 */
class MeasureUnitDto extends Dto
{
    /**
     * The default flags.
     *
     * @var int
     */
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
