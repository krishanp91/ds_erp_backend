<?php

namespace App\Rules;

use App\Models\TaxCategory;
use Illuminate\Contracts\Validation\Rule;

class UpdateTaxCategoryNameExistsRule implements Rule
{
    private $taxCategoryId = 0;

    public function __construct(int $taxCategoryId)
    {
        $this->taxCategoryId = $taxCategoryId;
    }

    public function passes($attribute, $value)
    {
        return TaxCategory::where('name', '=', $value)->whereNot('id', '=', $this->taxCategoryId)->doesntExist();
    }

    public function message()
    {
        return trans('validation.tax_category.update.name.exists');
    }
}
