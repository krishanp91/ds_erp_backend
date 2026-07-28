<?php

namespace App\Http\Requests;

use App\Exceptions\ErpValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        Log::info("Request came to rules in product request ".$this->content);

        $sharedRules = [
            'productName' => 'required|max:100',
            'productTypeId' => 'required|integer',
            'active' => 'required|integer|in:0,1',
            'itemCode' => 'nullable|max:100',
            'productDescription' => 'nullable|max:250',
            'categoryId' => 'nullable|integer',
            'lowStockQty' => 'nullable|numeric',
            'unitId' => 'nullable|integer',
            'onSale' => 'nullable|integer|in:0,1',
            'companyId' => 'nullable|integer',
            'taxCategoryId' => 'nullable|integer|exists:tax_categories,id',
        ];

        switch ($this->method()) {
            case 'POST':
                return array_merge($sharedRules, [
                    'barcodes' => 'nullable|array',
                    'barcodes.*.barcode' => 'required|string|max:100',
                    'barcodes.*.barcodeType' => 'nullable|string|max:20',
                ]);
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
        Log::error("Request validation failed ".$validator->errors()->first());
        throw new ErpValidationException($validator->errors()->first(), 400);
    }
}
