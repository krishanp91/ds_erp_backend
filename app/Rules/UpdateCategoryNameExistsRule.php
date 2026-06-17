<?php

namespace App\Rules;

use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;

class UpdateCategoryNameExistsRule implements Rule
{
    private $categoryId = 0;

    public function __construct(int $categoryId) {
        $this->categoryId = $categoryId;
    }

    // Should return true or false depending on whether the attribute value is valid or not.
    public function passes($attribute, $value)
    {
        return Category::where('category_name', '=', $value)->whereNot('id', '=', $this->categoryId)->doesntExist();
    }

    // This method should return the validation error message that should be used when validation fails
    public function message()
    {
        return trans('validation.category.update.name.exists');
    }
}
