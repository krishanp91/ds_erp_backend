<?php

namespace App\Http\Requests;

use App\Exceptions\ErpValidationException;
use App\Rules\UpdateTaxCategoryNameExistsRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TaxCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|max:100|unique:tax_categories,name',
                    'isActive' => 'required|integer|in:0,1',
                ];
            case 'PUT':
                return [
                    'id' => 'required',
                    'name' => ['required', 'max:100', new UpdateTaxCategoryNameExistsRule($this->request->getInt('id'))],
                    'isActive' => 'required|integer|in:0,1',
                ];
            default:
                return [];
        }
    }

    protected function prepareForValidation()
    {
        if ($this->route()->hasParameter('id')) {
            $this->merge(['id' => (int) $this->route('id')]);
        }
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new ErpValidationException($validator->errors()->first(), 400);
    }
}
