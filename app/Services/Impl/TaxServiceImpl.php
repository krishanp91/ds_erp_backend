<?php

namespace App\Services\Impl;

use App\Dtos\TaxDto;
use App\Exceptions\ErpException;
use App\Models\Tax;
use App\Services\TaxService;
use Cerbero\Dto\Dto;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class TaxServiceImpl implements TaxService
{
    public function createTax(TaxDto $taxDto): TaxDto
    {
        try {
            $tax = Tax::create([
                'name' => $taxDto->name,
                'rate' => $taxDto->rate,
                'type' => $taxDto->type,
                'calculation_method' => $taxDto->calculationMethod,
                'is_active' => $taxDto->isActive,
            ]);

            return TaxDto::fromModel($tax);
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function getAllTaxes(): Collection
    {
        try {
            $taxes = Tax::withTrashed()->get();
            $result = new Collection();
            $taxes->map(function ($item) use ($result): Dto {
                return $result[] = TaxDto::fromModel($item);
            });

            return collect($result);
        } catch (QueryException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function getActiveTaxes(): Collection
    {
        try {
            $taxes = Tax::where('is_active', 1)->get();
            $result = new Collection();
            $taxes->map(function ($item) use ($result): Dto {
                return $result[] = TaxDto::fromModel($item);
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

    public function getTaxById(int $id): TaxDto
    {
        try {
            $tax = Tax::withTrashed()->where('id', $id)->first();

            if ($tax == null) {
                throw new ErpException("Tax not found.", 400);
            }

            return TaxDto::fromModel($tax);
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw new ErpException(trans("messages.erp.sql.exception.message"), 500, $e);
        }
    }

    public function updateTax(int $id, TaxDto $taxDto): TaxDto
    {
        try {
            $tax = Tax::where('id', $id)->withTrashed()->first();

            if ($tax == null) {
                throw new ErpException("Tax not found.", 400);
            }

            $tax->name = $taxDto->name;
            $tax->rate = $taxDto->rate;
            $tax->type = $taxDto->type;
            $tax->calculation_method = $taxDto->calculationMethod;
            $tax->is_active = $taxDto->isActive;
            $tax->update();

            return TaxDto::fromModel($tax);
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function deleteTax(int $id): void
    {
        try {
            $tax = Tax::where('id', $id)->withTrashed()->first();

            if ($tax == null) {
                throw new ErpException("Tax not found.", 400);
            }

            $tax->delete();
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function activateTax(int $id): void
    {
        try {
            $tax = Tax::onlyTrashed()->where('id', $id)->first();

            if ($tax == null) {
                throw new ErpException("Tax not found.", 400);
            }

            $tax->restore();
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
