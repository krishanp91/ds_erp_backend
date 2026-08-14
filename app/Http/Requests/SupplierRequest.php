<?php

namespace App\Http\Requests;

use App\Exceptions\ErpValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sharedRules = [
            'supplierName' => 'required|max:200',
            'creditLimit' => 'nullable|numeric',
            'creditPeriod' => 'nullable|integer',
            'taxCategoryId' => 'nullable|integer|exists:tax_categories,id',
            'active' => 'required|integer|in:0,1',
            'contacts' => 'nullable|array',
            'contacts.*.contactName' => 'required|string|max:200',
            'contacts.*.designation' => 'nullable|string|max:200',
            'contacts.*.email' => 'nullable|email|max:100',
            'contacts.*.phone' => 'nullable|string|max:20',
            'contacts.*.mobile' => 'nullable|string|max:20',
            'contacts.*.isPrimary' => 'required|integer|in:0,1',
            'addresses' => 'nullable|array',
            'addresses.*.addressType' => 'required|string|max:20',
            'addresses.*.addressLine1' => 'required|string|max:100',
            'addresses.*.addressLine2' => 'nullable|string|max:100',
            'addresses.*.addressLine3' => 'nullable|string|max:100',
            'addresses.*.city' => 'nullable|string|max:100',
            'addresses.*.district' => 'nullable|string|max:100',
            'addresses.*.province' => 'nullable|string|max:50',
            'addresses.*.postalCode' => 'nullable|string|max:15',
            'addresses.*.isPrimary' => 'nullable|integer|in:0,1',
        ];

        switch ($this->method()) {
            case 'POST':
                return array_merge([
                    'supplierCode' => 'required|max:50|unique:suppliers,supplier_code',
                ], $sharedRules);
            case 'PUT':
                return array_merge([
                    'id' => 'required',
                ], $sharedRules);
            default:
                return [];
        }
    }

    protected function prepareForValidation()
    {
        if ($this->isMethod('POST')) {
            $this->offsetUnset('id');
        } elseif ($this->route()->hasParameter('id')) {
            $this->merge(['id' => (int) $this->route('id')]);
            $this->offsetUnset('supplierCode');
        }

        $this->offsetUnset('createdBy');
        $this->offsetUnset('updatedBy');
        $this->offsetUnset('deletedBy');

        if ($this->has('contacts') && is_array($this->input('contacts'))) {
            $contacts = array_map(function ($contact) {
                unset(
                    $contact['id'],
                    $contact['createdBy'],
                    $contact['updatedBy'],
                    $contact['deletedBy']
                );

                return $contact;
            }, $this->input('contacts'));

            $this->merge(['contacts' => $contacts]);
        }

        if ($this->has('addresses') && is_array($this->input('addresses'))) {
            $addresses = array_map(function ($address) {
                unset(
                    $address['id'],
                    $address['createdBy'],
                    $address['updatedBy'],
                    $address['deletedBy'],
                    $address['active']
                );

                return $address;
            }, $this->input('addresses'));

            $this->merge(['addresses' => $addresses]);
        }
    }

    protected function failedValidation(Validator $validator): void
    {
        Log::error("Request validation failed ".$validator->errors()->first());
        throw new ErpValidationException($validator->errors()->first(), 400);
    }
}
