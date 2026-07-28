<?php

namespace App\Services;

use App\Dtos\MeasureUnitDto;

interface MeasureUnitService
{
    function createMeasureUnit(MeasureUnitDto $measureUnitDto): MeasureUnitDto;

    function updateMeasureUnit(int $id, MeasureUnitDto $measureUnitDto): MeasureUnitDto;
}
