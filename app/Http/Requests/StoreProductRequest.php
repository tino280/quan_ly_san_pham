<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => ['required','unique:products,name'],
            'type_id' => ['required', 'exists:types,id'],
            'producer_id' => ['required','exists:producers,id'],
            'price' => ['required', 'numeric', 'min:10000', 'max:10000000000'],
            'description' => 'required|string|min:1|max:500',
            'image_link' => ['required', 'image']
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được bỏ trống',
            'string' => ':attribute phải là ký tự',
            'exists' => ':attribute này không tồn tại',
            'numeric' => ':attribute phải là số',
            'price' => ':attribute phải nằm trong khoảng từ 10000 đến 10000000000',
            'description' => ':attribute không quá 500 ký tự',
            'image' => 'Đây không phải là :attribute',
            'unique' => ":attribute đã tồn tại",
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên sản phẩm',
            'email' => 'Email',
            'type_id' => 'Danh mục sản phẩm',
            'producer_id' => 'Hãng sản xuất',
            'price' => 'Giá',
            'description' => 'Mô tả',
            'image_link' => 'Ảnh',
        ];
    }
}
