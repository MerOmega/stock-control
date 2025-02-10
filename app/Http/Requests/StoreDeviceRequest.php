<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sku'          => 'required|string|max:255',
            'entry_year'   => 'required|date',
            'state'        => 'required|string',
            'brand_id'     => 'nullable|exists:brands,id',
            'sector_id'    => 'nullable|exists:sectors,id',
            'description'  => 'nullable|string',
            'observations' => 'nullable|string',
        ];
    }
}
