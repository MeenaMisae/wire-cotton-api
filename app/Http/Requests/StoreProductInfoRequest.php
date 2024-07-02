<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductInfoRequest extends FormRequest
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
            'quantity' => 'required|int|gt:0',
            'attributes' => 'required',
            'attributeOptions' => 'required',
            'subcategory' => 'required',
            'discount' => 'nullable|numeric|gt:0|max:100',
            'finalPrice' => 'required_with:discount|numeric|min:0',
            'amount' => 'nullable|required_if:finalPrice,null|required_without:discount|numeric|min:0',
            'attributeOptions' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required_without' => 'O campo preço é obrigatório.',
            'amount.required_if' => 'O campo preço é obrigatório.',
            'attributeOptions.required' => 'O campo é obrigatório'
        ];
    }

    public function attributes(): array
    {
        return [
            'finalPrice' => 'preço',
            'quantity' => 'quantidade',
            'subcategory' => 'subcategoria',
            'discount' => 'desconto'
        ];
    }
}
