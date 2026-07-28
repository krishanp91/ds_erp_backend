<?php

namespace App\Dtos;

use Carbon\Carbon;
use Cerbero\LaravelDto\Dto;

use const Cerbero\Dto\PARTIAL;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;

/**
 *  @OA\Schema(
 *     schema="ProductBarcodeRequest",
 *     type="object",
 *     title="ProductBarcodeRequest",
 *     description="Product barcode request body",
 *     required={"barcode"},
 *     @OA\Property(
 *         property="barcode",
 *         type="string",
 *         description="Barcode value",
 *         maxLength=100
 *     ),
 *     @OA\Property(
 *         property="barcodeType",
 *         type="string",
 *         description="Barcode type",
 *         maxLength=20
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="ProductBarcodeResponse",
 *     type="object",
 *     title="ProductBarcodeResponse",
 *     description="Product barcode response model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the product barcode"
 *     ),
 *     @OA\Property(
 *         property="itemId",
 *         type="integer",
 *         description="Product id"
 *     ),
 *     @OA\Property(
 *         property="barcode",
 *         type="string",
 *         description="Barcode value"
 *     ),
 *     @OA\Property(
 *         property="barcodeType",
 *         type="string",
 *         description="Barcode type"
 *     ),
 *     @OA\Property(
 *         property="active",
 *         type="integer",
 *         description="Active status of the barcode"
 *     ),
 *     @OA\Property(
 *         property="createdBy",
 *         type="integer",
 *         description="User id who created the barcode"
 *     ),
 *     @OA\Property(
 *         property="updatedBy",
 *         type="integer",
 *         description="User id who last updated the barcode"
 *     ),
 *     @OA\Property(
 *         property="deletedBy",
 *         type="integer",
 *         description="User id who deleted the barcode"
 *     )
 * )
 *
 * The data transfer object for the ProductBarcode model.
 *
 * @property int $id
 * @property int $itemId
 * @property string $barcode
 * @property string|null $barcodeType
 * @property int $active
 * @property int $createdBy
 * @property int|null $updatedBy
 * @property int|null $deletedBy
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property Carbon|null $deletedAt
 */
class ProductBarcodeDto extends Dto
{
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
