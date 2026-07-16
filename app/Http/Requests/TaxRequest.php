<?php

namespace App\Http\Requests;

use App\Exceptions\ErpValidationException;
use App\Rules\UpdateTaxNameExistsRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TaxRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sharedRules = [
            'name' => 'required|max:25|unique:taxes,name',
            'rate' => 'required|integer',
            'type' => 'required|max:20',
            'calculationMethod' => 'required|max:20',
            'isActive' => 'required|integer|in:0,1',
        ];

        switch ($this->method()) {
            case 'POST':
                return $sharedRules;
            case 'PUT':
                return [
                    'id' => 'required',
                    'name' => ['required', 'max:25', new UpdateTaxNameExistsRule($this->request->getInt('id'))],
                    'rate' => 'required|integer',
                    'type' => 'required|max:20',
                    'calculationMethod' => 'required|max:20',
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
