<?php

namespace App\Services\Impl;

use App\Dtos\TaxCategoryDto;
use App\Exceptions\ErpException;
use App\Models\TaxCategory;
use App\Services\TaxCategoryService;
use Cerbero\Dto\Dto;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class TaxCategoryServiceImpl implements TaxCategoryService
{
    public function createTaxCategory(TaxCategoryDto $taxCategoryDto): TaxCategoryDto
    {
        try {
            $taxCategory = TaxCategory::create([
                'name' => $taxCategoryDto->name,
                'is_active' => $taxCategoryDto->isActive,
            ]);

            return TaxCategoryDto::fromModel($taxCategory);
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function getAllTaxCategories(): Collection
    {
        try {
            $taxCategories = TaxCategory::withTrashed()->get();
            $result = new Collection();
            $taxCategories->map(function ($item) use ($result): Dto {
                return $result[] = TaxCategoryDto::fromModel($item);
            });

            return collect($result);
        } catch (QueryException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function getActiveTaxCategories(): Collection
    {
        try {
            $taxCategories = TaxCategory::where('is_active', 1)->get();
            $result = new Collection();
            $taxCategories->map(function ($item) use ($result): Dto {
                return $result[] = TaxCategoryDto::fromModel($item);
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

    public function getTaxCategoryById(int $id): TaxCategoryDto
    {
        try {
            $taxCategory = TaxCategory::withTrashed()->where('id', $id)->first();

            if ($taxCategory == null) {
                throw new ErpException("Tax category not found.", 400);
            }

            return TaxCategoryDto::fromModel($taxCategory);
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw new ErpException(trans("messages.erp.sql.exception.message"), 500, $e);
        }
    }

    public function updateTaxCategory(int $id, TaxCategoryDto $taxCategoryDto): TaxCategoryDto
    {
        try {
            $taxCategory = TaxCategory::where('id', $id)->withTrashed()->first();

            if ($taxCategory == null) {
                throw new ErpException("Tax category not found.", 400);
            }

            $taxCategory->name = $taxCategoryDto->name;
            $taxCategory->is_active = $taxCategoryDto->isActive;
            $taxCategory->update();

            return TaxCategoryDto::fromModel($taxCategory);
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function deleteTaxCategory(int $id): void
    {
        try {
            $taxCategory = TaxCategory::where('id', $id)->withTrashed()->first();

            if ($taxCategory == null) {
                throw new ErpException("Tax category not found.", 400);
            }

            $taxCategory->delete();
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function activateTaxCategory(int $id): void
    {
        try {
            $taxCategory = TaxCategory::onlyTrashed()->where('id', $id)->first();

            if ($taxCategory == null) {
                throw new ErpException("Tax category not found.", 400);
            }

            $taxCategory->restore();
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
