<?php

namespace App\Services\Impl;

use App\Dtos\MeasureUnitDto;
use App\Exceptions\ErpException;
use App\Models\MeasureUnit;
use App\Services\MeasureUnitService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class MeasureUnitServiceImpl implements MeasureUnitService
{
    public function createMeasureUnit(MeasureUnitDto $measureUnitDto): MeasureUnitDto
    {
        try {
            $measureUnit = MeasureUnit::create([
                'unit_name' => $measureUnitDto->unitName,
                'description' => $measureUnitDto->description,
                'active' => 1
            ]);

            return MeasureUnitDto::fromModel($measureUnit);
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function updateMeasureUnit(int $id, MeasureUnitDto $measureUnitDto): MeasureUnitDto
    {
        try {
            $measureUnit = MeasureUnit::where('id', $id)->withTrashed()->first();

            if ($measureUnit == null) {
                throw new ErpException("Measure unit not found.", 400);
            }

            $measureUnit->unit_name = $measureUnitDto->unitName;
            $measureUnit->description = $measureUnitDto->description;
            $measureUnit->active = $measureUnitDto->active;
            $measureUnit->update();

            return MeasureUnitDto::fromModel($measureUnit);
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
