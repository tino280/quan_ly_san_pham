<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSlideRequest extends FormRequest
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
            'slot' => [ 'bail', 'required', 'numeric', 'min:1', 'max:4'],
            'image' => [ 'bail','required', 'file', 'image'],
            'product_id' => [ 'bail', 'required', 'exists:products,id'],
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được bỏ trống',
            'exists' => ':attribute này không tồn tại',
            'numeric' => ':attribute không đúng',
            'image' => 'Đây không phải là :attribute',
        ];
    }

    public function attributes()
    {
        return [
            'slot' => 'Vị trí',
            'image' => 'ảnh',
            'product_id' => 'Sản phẩm',
        ];
    }
}
