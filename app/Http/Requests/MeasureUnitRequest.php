<?php

namespace App\Http\Requests;

use App\Exceptions\ErpValidationException;
use App\Rules\UpdateMeasureUnitNameExistsRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;


class MeasureUnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        Log::info("Request came to rules in measure unit request ".$this->content);
        switch ($this->method()) {
            case 'POST':
                return  [
                    'unitName' => 'required|max:50|unique:measure_units,unit_name'
                ];
            case 'PUT':
                return [
                    'id' => 'required',
                    'unitName' => ['required', 'max:50', new UpdateMeasureUnitNameExistsRule($this->request->getInt('id'))]
                ];
            default:
                return [];
        }
    
    }

    protected function prepareForValidation() 
    {
        if($this->route()->hasParameter('id')) {
            $this->merge(['id' => (int)$this->route('id')]);
        }
    }

    protected function failedValidation(Validator $validator): void
    {
        Log::error("Request validation failed ".$validator->errors()->first());
        throw new ErpValidationException($validator->errors()->first(), 400);
    }
}
