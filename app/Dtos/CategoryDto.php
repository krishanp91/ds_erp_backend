<?php

namespace App\Dtos;

use Carbon\Carbon;
use Cerbero\LaravelDto\Dto;

use const Cerbero\Dto\PARTIAL;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;


/**
 *  @OA\Schema(
 *     schema="CategoryRequest",
 *     type="object",
 *     title="CategoryRequest",
 *     description="Category request body",
 *     required={"categoryName", "active"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the category"
 *     ),
 *     @OA\Property(
 *         property="categoryName",
 *         type="string",
 *         description="Name of the category"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the category"
 *     ),
 *     @OA\Property(
 *         property="parentId",
 *         type="int",
 *         description="Parent category id of the category"
 *     ),
 *     @OA\Property(
 *         property="active",
 *         type="int",
 *         description="Active status of the category"
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="CategoryResponse",
 *     type="object",
 *     title="CategoryResponse",
 *     description="Category response model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the category"
 *     ),
 *     @OA\Property(
 *         property="categoryName",
 *         type="string",
 *         description="Name of the category"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the category"
 *     ),
 *     @OA\Property(
 *         property="parent",
 *         type="object",
 *         ref="#/components/schemas/CategoryRequest",
 *         description="Parent category of this category"
 *     ),
 *     @OA\Property(
 *         property="children",
 *         type="array",
 *         description="Active status of the category",
 *         @OA\Items(
 *          ref="#/components/schemas/CategoryRequest"
 *         )
 *     ),
 *     @OA\Property(
 *         property="active",
 *         type="int",
 *         description="Active status of the category"
 *     )
 * )
 * 
 * The data transfer object for the Category model.
 *
 * @property int $id
 * @property string $categoryName
 * @property string|null $description
 * @property int|null $parentId
 * @property int|null $companyId
 * @property bool $active
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property Carbon|null $deletedAt
 * @property CategoryDto|null $parent
 * @property CategoryDto[]|null $children
 */
class CategoryDto extends Dto
{
    /**
     * The default flags.
     *
     * @var int
     */
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
