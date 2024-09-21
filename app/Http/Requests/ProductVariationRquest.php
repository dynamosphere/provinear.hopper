<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductVariationRquest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'variation'         => 'required|string|exists:variation,variation_id',
            'variation_value'   => 'required|string',
            'variation_price'   => 'required|decimal:2',
            'variation_detail'  => 'nullable|json'
        ];
    }
}
