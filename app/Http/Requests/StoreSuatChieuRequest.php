<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSuatChieuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phim_id' => 'required|exists:phim,phim_id',
            'phong_id' => 'required|exists:phong_chieu,phong_id',
            'ngay_chieu' => 'required|date|after_or_equal:today',
            'gio_bat_dau' => 'required',
            'gio_ket_thuc' => 'required|after:gio_bat_dau',
            'gia_ve' => 'required|numeric|min:0',
            'trang_thai' => 'required|in:sap_chieu,dang_chieu,da_ket_thuc',
        ];
    }

    public function messages(): array
    {
        return [
            'phim_id.required' => 'Vui lòng chọn phim',
            'phim_id.exists' => 'Phim không tồn tại',
            'phong_id.required' => 'Vui lòng chọn phòng chiếu',
            'phong_id.exists' => 'Phòng chiếu không tồn tại',
            'ngay_chieu.required' => 'Vui lòng chọn ngày chiếu',
            'ngay_chieu.date' => 'Ngày chiếu không hợp lệ',
            'ngay_chieu.after_or_equal' => 'Ngày chiếu không được trong quá khứ',
            'gio_bat_dau.required' => 'Vui lòng nhập giờ bắt đầu',
            'gio_ket_thuc.required' => 'Vui lòng nhập giờ kết thúc',
            'gio_ket_thuc.after' => 'Giờ kết thúc phải sau giờ bắt đầu',
            'gia_ve.required' => 'Vui lòng nhập giá vé',
            'gia_ve.numeric' => 'Giá vé phải là số',
            'gia_ve.min' => 'Giá vé không được âm',
            'trang_thai.required' => 'Vui lòng chọn trạng thái',
            'trang_thai.in' => 'Trạng thái không hợp lệ',
        ];
    }
}
