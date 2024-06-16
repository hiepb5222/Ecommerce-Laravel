<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
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
            'display_name' =>'required',
            'group' =>'required',
        ];
    }

    public function messages()
{
    return [
        'name.required' => 'Tên không được để trống.',
        'name.string' => 'Tên phải là chuỗi.',
        'name.max' => 'Tên không được vượt quá 255 ký tự.',
        
        'display_name.required' => 'Tên hiển thị không được để trống.',
        'display_name.string' => 'Tên hiển thị phải là chuỗi.',
        'display_name.max' => 'Tên hiển thị không được vượt quá 255 ký tự.',
        
        'group.required' => 'Nhóm không được để trống.',
        'group.string' => 'Nhóm phải là chuỗi.',
        'group.max' => 'Nhóm không được vượt quá 255 ký tự.',
    ];
}
}
