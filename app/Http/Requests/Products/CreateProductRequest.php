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
            'description' => 'required',
            'sale' => 'required|integer|between:0,100',
            'image' => 'required|image|mimes:png,jpg,jpeg,PNG,jpec',
            'price' => 'required',
            'category_ids' => 'required',
        ];
    }

    public function messages()
{
    return [
        'name.required' => 'Tên sản phẩm không được để trống.',
        'name.string' => 'Tên sản phẩm phải là chuỗi.',
        'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
        
        'description.required' => 'Mô tả sản phẩm không được để trống.',
        'description.string' => 'Mô tả sản phẩm phải là chuỗi.',
        
        'sale.required' => 'Giảm giá không được để trống.',
        'sale.integer' => 'Giảm giá phải là số nguyên.',
        'sale.between' => 'Giảm giá phải nằm trong khoảng từ 0 đến 100.',
        
        'image.required' => 'Ảnh sản phẩm không được để trống.',
        'image.image' => 'Tệp tải lên phải là hình ảnh.',
        'image.mimes' => 'Định dạng ảnh phải là png, jpg hoặc jpeg.',
        
        'price.required' => 'Giá sản phẩm không được để trống.',
        'price.numeric' => 'Giá sản phẩm phải là số.',
        'price.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
        
        'category_ids.required' => 'Danh mục sản phẩm không được để trống.',
        'category_ids.array' => 'Danh mục sản phẩm phải là một mảng.',
    ];
}
    
}
