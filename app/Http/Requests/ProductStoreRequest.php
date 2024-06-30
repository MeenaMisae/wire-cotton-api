<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'quantity' => 'required|int',
            'attributes' => 'required',
            'attributeOptions' => 'required',
            'subcategory' => 'required',
            'files' => 'required|array',
            'files.*' => 'file|mimes:png,jpg,webp,jpeg',
            'discount' => 'nullable|numeric|gt:0|max:100',
            'finalPrice' => 'required_with:discount|numeric|min:0',
            'amount' => 'nullable|required_if:finalPrice,null|required_without:discount|numeric|min:0',
            'attributeOptions' => 'required'
        ];
    }
}
