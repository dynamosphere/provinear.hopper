<?php

namespace App\Http\Requests;

use App\Rules\NigerianCityInState;
use App\Rules\NigerianPhoneNumber;
use App\Rules\NigerianState;
use Illuminate\Foundation\Http\FormRequest;

class UserAddressRequest extends FormRequest
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
        return [
            'first_name'    => 'required|string|min:3|max:64|alpha',
            'last_name'     => 'required|string|min:3|max:64|alpha',
            // or room number or building name
            'house_number'  => 'required|string|min:2|max:128',
            'street'        => 'required|string|min:2|max:255',
            'city'          => ['required', new NigerianCityInState($this->input('state'))],
            'state'         => ['required', new NigerianState],
            'postal_code'   => 'digits:6',
            'phone'         => ['required', new NigerianPhoneNumber],
        ];
    }
}
