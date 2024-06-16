<?php

namespace App\Http\Requests\Coupons;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
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
            'name' => 'required|unique:coupons,name,'.$this->coupon,
            'type' => 'required',
            'value' => 'required|numeric',
            'expiry_date' => 'required|date',
        ];
    }

    public function messages()
{
    return [
        'name.required' => 'Tên phiếu giảm giá không được để trống.',
        'name.unique' => 'Tên phiếu giảm giá đã tồn tại.',
        'type.required' => 'Loại phiếu giảm giá không được để trống.',
        'value.required' => 'Giá trị phiếu giảm giá không được để trống.',
        'value.numeric' => 'Giá trị phiếu giảm giá phải là số.',
        'expiry_date.required' => 'Ngày hết hạn không được để trống.',
        'expiry_date.date' => 'Ngày hết hạn phải là định dạng ngày tháng.',
    ];
}
}
