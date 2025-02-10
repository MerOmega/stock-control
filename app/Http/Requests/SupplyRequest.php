<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class SupplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get common validation rules.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    protected function commonRules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'category_id'  => 'nullable|exists:categories,id',
            'description'  => 'nullable|string',
            'observations' => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     */
    abstract public function rules(): array;
}
