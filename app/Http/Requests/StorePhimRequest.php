<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePhimRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ten_phim' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'dao_dien' => 'nullable|string|max:100',
            'dien_vien' => 'nullable|string',
            'thoi_luong' => 'nullable|integer|min:1',
            'ngay_cong_chieu' => 'nullable|date',
            'trang_thai' => 'required|in:sap_chieu,dang_chieu,ngung_chieu',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'the_loai' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'ten_phim.required' => 'Tên phim không được để trống',
            'ten_phim.max' => 'Tên phim không được vượt quá 255 ký tự',
            'thoi_luong.integer' => 'Thời lượng phải là số nguyên',
            'thoi_luong.min' => 'Thời lượng phải lớn hơn 0',
            'ngay_cong_chieu.date' => 'Ngày công chiếu không hợp lệ',
            'trang_thai.required' => 'Trạng thái không được để trống',
            'trang_thai.in' => 'Trạng thái không hợp lệ',
            'hinh_anh.image' => 'File phải là hình ảnh',
            'hinh_anh.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'hinh_anh.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
        ];
    }
}
