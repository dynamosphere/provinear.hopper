<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'product_name'              => 'required|string',
            'product_description'       => 'required|string',
            'product_attribute'         => 'nullable|json',
            'available_quantity'        => 'nullable|int',
            'unit_price'                => 'required|decimal:2',
            'currency_code'             => 'nullable|string|exists:currency',
            'strikeout_price'           => 'nullable|decimal:2',
            'price_percentage_discount' => 'nullable|decimal:2',
            'estimated_prepare_minute'  => 'required|int',
            'unit_measure'              => 'nullable|string',
            'opened_to_bargain'         => 'nullable|boolean',
            'brand_name'                => ['nullable', 'string', Rule::unique('product', 'brand_name')->where('shop_id', $this->route('shop'))->where('product_name', $this->product_name)],
            'main_image'                => 'required|image|max:4096',
            'image_1'                   => 'nullable|image|max:4096',
            'image_2'                   => 'nullable|image|max:4096',
            'image_3'                   => 'nullable|image|max:4096',
            'tags'                      => 'nullable|array',
            'tags.*'                    => 'distinct|exists:tag,tag_id',
            'categories'                => 'nullable|array',
            'categories.*'              => 'distinct|exists:category,category_id'
        ];
    }

    public function messages(): array
    {
        return [
            'brand_name.unique' => 'Product with name and brand name already exist in shop'
        ];
    }
}
