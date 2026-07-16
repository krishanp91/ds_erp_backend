<?php

namespace App\Dtos;

use Carbon\Carbon;
use Cerbero\LaravelDto\Dto;

use const Cerbero\Dto\PARTIAL;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;

/**
 *  @OA\Schema(
 *     schema="ProductRequest",
 *     type="object",
 *     title="ProductRequest",
 *     description="Product request body",
 *     required={"productName", "productTypeId", "active"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the product"
 *     ),
 *     @OA\Property(
 *         property="itemCode",
 *         type="string",
 *         description="Item code of the product"
 *     ),
 *     @OA\Property(
 *         property="productName",
 *         type="string",
 *         description="Name of the product"
 *     ),
 *     @OA\Property(
 *         property="productDescription",
 *         type="string",
 *         description="Description of the product"
 *     ),
 *     @OA\Property(
 *         property="productTypeId",
 *         type="integer",
 *         description="Product type id"
 *     ),
 *     @OA\Property(
 *         property="categoryId",
 *         type="integer",
 *         description="Category id"
 *     ),
 *     @OA\Property(
 *         property="lowStockQty",
 *         type="number",
 *         description="Low stock quantity threshold"
 *     ),
 *     @OA\Property(
 *         property="unitId",
 *         type="integer",
 *         description="Measure unit id"
 *     ),
 *     @OA\Property(
 *         property="onSale",
 *         type="integer",
 *         description="On sale status"
 *     ),
 *     @OA\Property(
 *         property="active",
 *         type="integer",
 *         description="Active status of the product"
 *     ),
 *     @OA\Property(
 *         property="companyId",
 *         type="integer",
 *         description="Company id"
 *     ),
 *     @OA\Property(
 *         property="taxCategoryId",
 *         type="integer",
 *         description="Tax category id"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="ProductResponse",
 *     type="object",
 *     title="ProductResponse",
 *     description="Product response model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the product"
 *     ),
 *     @OA\Property(
 *         property="itemCode",
 *         type="string",
 *         description="Item code of the product"
 *     ),
 *     @OA\Property(
 *         property="productName",
 *         type="string",
 *         description="Name of the product"
 *     ),
 *     @OA\Property(
 *         property="productDescription",
 *         type="string",
 *         description="Description of the product"
 *     ),
 *     @OA\Property(
 *         property="productTypeId",
 *         type="integer",
 *         description="Product type id"
 *     ),
 *     @OA\Property(
 *         property="categoryId",
 *         type="integer",
 *         description="Category id"
 *     ),
 *     @OA\Property(
 *         property="lowStockQty",
 *         type="number",
 *         description="Low stock quantity threshold"
 *     ),
 *     @OA\Property(
 *         property="unitId",
 *         type="integer",
 *         description="Measure unit id"
 *     ),
 *     @OA\Property(
 *         property="onSale",
 *         type="integer",
 *         description="On sale status"
 *     ),
 *     @OA\Property(
 *         property="active",
 *         type="integer",
 *         description="Active status of the product"
 *     ),
 *     @OA\Property(
 *         property="companyId",
 *         type="integer",
 *         description="Company id"
 *     ),
 *     @OA\Property(
 *         property="taxCategoryId",
 *         type="integer",
 *         description="Tax category id"
 *     ),
 *     @OA\Property(
 *         property="taxCategory",
 *         ref="#/components/schemas/TaxCategoryResponse",
 *         description="Related tax category"
 *     )
 * )
 *
 * The data transfer object for the Product model.
 *
 * @property int $id
 * @property string|null $itemCode
 * @property string $productName
 * @property string|null $productDescription
 * @property int $productTypeId
 * @property int|null $categoryId
 * @property float|null $lowStockQty
 * @property int|null $unitId
 * @property int|null $onSale
 * @property int $active
 * @property int|null $companyId
 * @property int|null $taxCategoryId
 * @property TaxCategoryDto|null $taxCategory
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property Carbon|null $deletedAt
 */
class ProductDto extends Dto
{
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
