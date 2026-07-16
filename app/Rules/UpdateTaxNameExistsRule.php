<?php

namespace App\Rules;

use App\Models\Tax;
use Illuminate\Contracts\Validation\Rule;

class UpdateTaxNameExistsRule implements Rule
{
    private $taxId = 0;

    public function __construct(int $taxId)
    {
        $this->taxId = $taxId;
    }

    public function passes($attribute, $value)
    {
        return Tax::where('name', '=', $value)->whereNot('id', '=', $this->taxId)->doesntExist();
    }

    public function message()
    {
        return trans('validation.tax.update.name.exists');
    }
}
