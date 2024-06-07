<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required|integer|between:0,100',
            'sale' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg,PNG,jpec',
            'price' => 'required',
            'category_ids' => 'required',
        ];
    }
}
