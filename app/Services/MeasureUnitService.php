<?php

namespace App\Services;

use App\DTOs\MeasureUnitDto;

interface MeasureUnitService {
    function createMeasureUnit(MeasureUnitDto $measureUnitDto): MeasureUnitDto;
}