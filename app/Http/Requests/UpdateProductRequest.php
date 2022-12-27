<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:50'],
            'type_id' => ['nullable', 'exists:types,id'],
            'producer_id' => ['nullable', 'exists:producers,id'],
            'price' => ['nullable', 'numeric', 'between: 10000, 100000000000'],
            'description' => ['nullable', 'string', 'max: 500'],
            'image_link' => ['file', 'image'],

            'slide1' => [ 'nullable', 'image', ],
            'slide2' => [ 'nullable', 'image', ],
            'slide3' => [ 'nullable', 'image', ],
            'slide4' => [ 'nullable', 'image', ],

            'deleteSlide1' => ['nullable', 'boolean'],
            'deleteSlide2' => ['nullable', 'boolean'],
            'deleteSlide3' => ['nullable', 'boolean'],
            'deleteSlide4' => ['nullable', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được bỏ trống',
            'string' => ':attribute phải là ký tự',
            'exists' => ':attribute này không tồn tại',
            'numeric' => ':attribute phải là số',
            'price' => ':attribute phải nằm trong khoảng từ 10000 đến 100000000000',
            'description' => ':attribute không quá 500 ký tự',
            'image' => 'File vừa chọn không phải là ảnh',
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
