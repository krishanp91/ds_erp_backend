<?php

namespace App\Services\Impl;

use App\Dtos\TaxCategoryTaxDto;
use App\Exceptions\ErpException;
use App\Models\TaxCategoryTax;
use App\Services\TaxCategoryTaxService;
use Cerbero\Dto\Dto;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class TaxCategoryTaxServiceImpl implements TaxCategoryTaxService
{
    public function createTaxCategoryTax(TaxCategoryTaxDto $taxCategoryTaxDto): TaxCategoryTaxDto
    {
        try {
            $taxCategoryTax = TaxCategoryTax::create([
                'tax_category_id' => $taxCategoryTaxDto->taxCategoryId,
                'tax_id' => $taxCategoryTaxDto->taxId,
                'sequence' => $taxCategoryTaxDto->sequence,
            ]);

            return TaxCategoryTaxDto::fromModel($taxCategoryTax->load(['taxCategory', 'tax']));
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function getAllTaxCategoryTaxes(): Collection
    {
        try {
            $taxCategoryTaxes = TaxCategoryTax::with(['taxCategory', 'tax'])->withTrashed()->get();
            $result = new Collection();
            $taxCategoryTaxes->map(function ($item) use ($result): Dto {
                return $result[] = TaxCategoryTaxDto::fromModel($item);
            });

            return collect($result);
        } catch (QueryException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function getTaxCategoryTaxById(int $id): TaxCategoryTaxDto
    {
        try {
            $taxCategoryTax = TaxCategoryTax::with(['taxCategory', 'tax'])
                ->withTrashed()
                ->where('id', $id)
                ->first();

            if ($taxCategoryTax == null) {
                throw new ErpException("Tax category tax not found.", 400);
            }

            return TaxCategoryTaxDto::fromModel($taxCategoryTax);
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw new ErpException(trans("messages.erp.sql.exception.message"), 500, $e);
        }
    }

    public function updateTaxCategoryTax(int $id, TaxCategoryTaxDto $taxCategoryTaxDto): TaxCategoryTaxDto
    {
        try {
            $taxCategoryTax = TaxCategoryTax::where('id', $id)->withTrashed()->first();

            if ($taxCategoryTax == null) {
                throw new ErpException("Tax category tax not found.", 400);
            }

            $taxCategoryTax->tax_category_id = $taxCategoryTaxDto->taxCategoryId;
            $taxCategoryTax->tax_id = $taxCategoryTaxDto->taxId;
            $taxCategoryTax->sequence = $taxCategoryTaxDto->sequence;
            $taxCategoryTax->update();

            return TaxCategoryTaxDto::fromModel($taxCategoryTax->load(['taxCategory', 'tax']));
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function deleteTaxCategoryTax(int $id): void
    {
        try {
            $taxCategoryTax = TaxCategoryTax::where('id', $id)->withTrashed()->first();

            if ($taxCategoryTax == null) {
                throw new ErpException("Tax category tax not found.", 400);
            }

            $taxCategoryTax->delete();
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function activateTaxCategoryTax(int $id): void
    {
        try {
            $taxCategoryTax = TaxCategoryTax::onlyTrashed()->where('id', $id)->first();

            if ($taxCategoryTax == null) {
                throw new ErpException("Tax category tax not found.", 400);
            }

            $taxCategoryTax->restore();
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
