<?php

namespace App\Services\Impl;

use App\Dtos\ProductDto;
use App\Exceptions\ErpException;
use App\Models\Product;
use App\Models\ProductBarcode;
use App\Services\ProductService;
use Cerbero\Dto\Dto;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductServiceImpl implements ProductService
{
    private const RELATIONS = ['category', 'measureUnit', 'company', 'taxCategory', 'barcodes'];

    public function createProduct(ProductDto $productDto): ProductDto
    {
        try {
            $product = DB::transaction(function () use ($productDto) {
                $product = Product::create($this->mapDtoToAttributes($productDto));
                $this->createProductBarcodes($product, $productDto);

                return $product;
            });

            return ProductDto::fromModel($product->load(self::RELATIONS));
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function getAllProducts(): Collection
    {
        try {
            $products = Product::with(self::RELATIONS)->withTrashed()->get();

            return $this->mapProductsToDtoCollection($products);
        } catch (QueryException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function getActiveProducts(): Collection
    {
        try {
            $products = Product::with(self::RELATIONS)
                ->where('active', 1)
                ->get();

            return $this->mapProductsToDtoCollection($products);
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function getProductById(int $id): ProductDto
    {
        try {
            $product = Product::with(self::RELATIONS)
                ->withTrashed()
                ->where('id', $id)
                ->first();

            if ($product == null) {
                throw new ErpException("Product not found.", 400);
            }

            return ProductDto::fromModel($product);
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw new ErpException(trans("messages.erp.sql.exception.message"), 500, $e);
        }
    }

    public function updateProduct(int $id, ProductDto $productDto): ProductDto
    {
        try {
            $product = DB::transaction(function () use ($id, $productDto) {
                $product = Product::where('id', $id)->withTrashed()->first();

                if ($product == null) {
                    throw new ErpException("Product not found.", 400);
                }

                $product->fill($this->mapDtoToAttributes($productDto));
                $product->update();
                $this->syncProductBarcodes($product, $productDto);

                return $product;
            });

            return ProductDto::fromModel($product->load(self::RELATIONS));
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (ErpException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function deleteProduct(int $id): void
    {
        try {
            $product = Product::where('id', $id)->withTrashed()->first();

            if ($product == null) {
                throw new ErpException("Product not found.", 400);
            }

            $product->delete();
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function activateProduct(int $id): void
    {
        try {
            $product = Product::onlyTrashed()->where('id', $id)->first();

            if ($product == null) {
                throw new ErpException("Product not found.", 400);
            }

            $product->restore();
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function createProductBarcodes(Product $product, ProductDto $productDto): void
    {
        $barcodes = isset($productDto->barcodes) ? $productDto->barcodes : [];

        foreach ($barcodes as $barcodeDto) {
            $product->barcodes()->create([
                'barcode' => $barcodeDto->barcode,
                'barcode_type' => $barcodeDto->barcodeType,
                'active' => 1,
                'created_by' => Auth::id(),
            ]);
        }
    }

    private function syncProductBarcodes(Product $product, ProductDto $productDto): void
    {
        if (!isset($productDto->barcodes)) {
            return;
        }

        $product->barcodes()->get()->each(function (ProductBarcode $barcode) {
            $barcode->delete();
        });

        $this->createProductBarcodes($product, $productDto);
    }

    private function mapDtoToAttributes(ProductDto $productDto): array
    {
        return [
            'item_code' => $productDto->itemCode,
            'product_name' => $productDto->productName,
            'product_description' => $productDto->productDescription,
            'product_type' => $productDto->productType,
            'category_id' => $productDto->categoryId,
            'low_stock_qty' => $productDto->lowStockQty ?? 0,
            'unit_id' => $productDto->unitId,
            'on_sale' => $productDto->onSale ?? 0,
            'active' => $productDto->active,
            'company_id' => $productDto->companyId,
            'tax_category_id' => $productDto->taxCategoryId,
        ];
    }

    private function mapProductsToDtoCollection(Collection $products): Collection
    {
        $result = new Collection();
        $products->map(function ($item) use ($result): Dto {
            return $result[] = ProductDto::fromModel($item);
        });

        return collect($result);
    }
}
