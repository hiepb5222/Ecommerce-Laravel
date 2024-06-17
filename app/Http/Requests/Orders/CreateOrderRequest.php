<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'customer_name' =>'required',
            'customer_email'=>'required',
            'customer_phone'=>'required',
            'customer_address'=>'required',
            'note'=>'required',
        ];
    }

    public function messages()
{
    return [
        'customer_name.required' => 'Vui lòng nhập tên khách hàng.',
        'customer_name.string' => 'Tên khách hàng phải là chuỗi.',
        'customer_name.max' => 'Tên khách hàng không được vượt quá 255 ký tự.',
        
        'customer_email.required' => 'Vui lòng nhập địa chỉ email của khách hàng.',
        'customer_email.email' => 'Địa chỉ email không hợp lệ.',
        'customer_email.max' => 'Địa chỉ email không được vượt quá 255 ký tự.',
        
        'customer_phone.required' => 'Vui lòng nhập số điện thoại của khách hàng.',
        
        'customer_address.required' => 'Vui lòng nhập địa chỉ của khách hàng.',
        
        'note.required' => 'Vui lòng nhập ghi chú.',
    ];
}
}
