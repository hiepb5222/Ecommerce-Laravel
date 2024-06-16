<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'email' =>'required|email|unique:users,email',
            'password' => 'required|min:6',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,PNG,jpec',
            'phone' => 'required|unique:users,phone',
            'gender' => 'required'
        ];
    }
    public function messages()
{
    return [
        'name.required' => 'Vui lòng nhập tên người dùng.',
        'name.string' => 'Tên người dùng phải là chuỗi.',
        'name.max' => 'Tên người dùng không được vượt quá 255 ký tự.',
        
        'email.required' => 'Vui lòng nhập địa chỉ email.',
        'email.email' => 'Địa chỉ email không hợp lệ.',
        'email.unique' => 'Địa chỉ email đã tồn tại trong hệ thống.',
        
        'password.required' => 'Vui lòng nhập mật khẩu.',
        'password.string' => 'Mật khẩu phải là chuỗi.',
        'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        
        'image.image' => 'Tệp tải lên phải là hình ảnh.',
        'image.mimes' => 'Định dạng ảnh phải là png, jpg hoặc jpeg.',
        
        'phone.required' => 'Vui lòng nhập số điện thoại.',
        'phone.unique' => 'Số điện thoại đã tồn tại trong hệ thống.',
        
        'gender.required' => 'Vui lòng chọn giới tính.',
        'gender.in' => 'Giới tính không hợp lệ.',
    ];
}
}
