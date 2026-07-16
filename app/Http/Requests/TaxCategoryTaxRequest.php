<?php

namespace App\Http\Requests;

use App\Exceptions\ErpValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TaxCategoryTaxRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sharedRules = [
            'taxCategoryId' => 'required|integer|exists:tax_categories,id',
            'taxId' => 'required|integer|exists:taxes,id',
            'sequence' => 'required|integer',
        ];

        switch ($this->method()) {
            case 'POST':
                return $sharedRules;
            case 'PUT':
                return array_merge(['id' => 'required'], $sharedRules);
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
