<?php

namespace App\Services\Impl;

use App\Dtos\ProductDto;
use App\Exceptions\ErpException;
use App\Models\Product;
use App\Services\ProductService;
use Cerbero\Dto\Dto;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ProductServiceImpl implements ProductService
{
    public function createProduct(ProductDto $productDto): ProductDto
    {
        try {
            $product = Product::create([
                'item_code' => $productDto->itemCode,
                'product_name' => $productDto->productName,
                'product_description' => $productDto->productDescription,
                'product_type_id' => $productDto->productTypeId,
                'category_id' => $productDto->categoryId,
                'low_stock_qty' => $productDto->lowStockQty ?? 0,
                'unit_id' => $productDto->unitId,
                'on_sale' => $productDto->onSale ?? 0,
                'active' => $productDto->active,
                'company_id' => $productDto->companyId,
            ]);

            return ProductDto::fromModel($product->load(['category', 'measureUnit', 'company']));
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
            $products = Product::with(['category', 'measureUnit', 'company'])->withTrashed()->get();
            $result = new Collection();
            $products->map(function ($item) use ($result): Dto {
                return $result[] = ProductDto::fromModel($item);
            });

            return collect($result);
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
            $products = Product::with(['category', 'measureUnit', 'company'])
                ->where('active', 1)
                ->get();
            $result = new Collection();
            $products->map(function ($item) use ($result): Dto {
                return $result[] = ProductDto::fromModel($item);
            });

            return collect($result);
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
            $product = Product::with(['category', 'measureUnit', 'company'])
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
            $product = Product::where('id', $id)->withTrashed()->first();

            if ($product == null) {
                throw new ErpException("Product not found.", 400);
            }

            $product->item_code = $productDto->itemCode;
            $product->product_name = $productDto->productName;
            $product->product_description = $productDto->productDescription;
            $product->product_type_id = $productDto->productTypeId;
            $product->category_id = $productDto->categoryId;
            $product->low_stock_qty = $productDto->lowStockQty ?? 0;
            $product->unit_id = $productDto->unitId;
            $product->on_sale = $productDto->onSale ?? 0;
            $product->active = $productDto->active;
            $product->company_id = $productDto->companyId;
            $product->update();

            return ProductDto::fromModel($product->load(['category', 'measureUnit', 'company']));
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
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
}
