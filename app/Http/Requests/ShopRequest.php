<?php

namespace App\Http\Requests;

use App\Traits\HasFile;
use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
{
    use HasFile;

    public $uploadDir = 'public/shop_brand_images';
    
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
        $shopId = $this->route('shop');
        return [
            'shop_name' => 'required|unique:shop,shop_name'. $shopId ?? ',except,'.$shopId,
            'shop_description' => 'required|min:50|max:250',
            'address' => 'string|min:5|max:250|required',
            'brand_cover_image' => 'image|mimes:png,jpg|size:2048|nullable'
        ];
        
    }
    
}
