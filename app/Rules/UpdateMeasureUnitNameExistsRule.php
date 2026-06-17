<?php

namespace App\Rules;

use App\Models\MeasureUnit;
use Illuminate\Contracts\Validation\Rule;

class UpdateMeasureUnitNameExistsRule implements Rule
{
    private $measureUnitId = 0;

    public function __construct(int $measureUnitId) {
        $this->measureUnitId = $measureUnitId;
    }

    // Should return true or false depending on whether the attribute value is valid or not.
    public function passes($attribute, $value)
    {
        return MeasureUnit::where('unit_name', '=', $value)->whereNot('id', '=', $this->measureUnitId)->doesntExist();
    }

    // This method should return the validation error message that should be used when validation fails
    public function message()
    {
        return trans('measure.unit.update.name.exists');
    }
}
