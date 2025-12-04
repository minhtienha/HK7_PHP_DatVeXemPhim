@extends('layouts.app')

@section('title', 'Chọn ghế - ' . $suatChieu->phim->ten_phim)

@push('styles')
<style>
    .seat {
        width: 38px;
        height: 38px;
        margin: 4px;
        border-radius: 6px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        border: 2px solid #dee2e6;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .seat:hover:not(.taken) {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    .seat.available {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #495057;
    }
    .seat.available.selected {
        background: linear-gradient(135deg, #c41e3a 0%, #a01630 100%);
        color: white;
        border-color: #c41e3a;
        box-shadow: 0 4px 12px rgba(196, 30, 58, 0.3);
    }
    .seat.taken {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: #ffffff;
        cursor: not-allowed;
        border-color: #495057;
        opacity: 0.9;
        font-weight: bold;
    }
    .screen {
        width: 85%;
        height: 30px;
        background: linear-gradient(90deg, #343a40 0%, #495057 50%, #343a40 100%);
        margin: 30px auto;
        color: white;
        text-align: center;
        line-height: 30px;
        border-radius: 8px;
        font-weight: bold;
        font-size: 14px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        border: 3px solid #495057;
    }
    .booking-info-card {
        background: white;
        border-left: 5px solid #c41e3a;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    .seat-legend {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-top: 20px;
    }
    .legend-item {
        display: inline-flex;
        align-items: center;
        margin-right: 20px;
        margin-bottom: 10px;
    }
    .legend-item .seat {
        margin-right: 8px;
        cursor: default;
    }
</style>
@endpush

@section('content')
    <div class="container my-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('phim.index') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('phim.show', $suatChieu->phim->phim_id) }}">{{ Str::limit($suatChieu->phim->ten_phim, 50) }}</a></li>
                <li class="breadcrumb-item active">Chọn Ghế</li>
            </ol>
        </nav>

        <h1 class="fw-bold mb-4 text-dark">
            Đặt Vé - {{ $suatChieu->phim->ten_phim }}
        </h1>

        <!-- Booking Info Card -->
        <div class="card booking-info-card mb-4 p-4">
            <div class="row">
                <div class="col-md-3 border-end pb-3 pb-md-0">
                    <h6 class="text-muted small">PHÒNG CHIẾU</h6>
                    <p class="fw-bold text-dark">{{ $suatChieu->phongChieu->ten_phong }}</p>
                </div>
                <div class="col-md-3 border-end pb-3 pb-md-0">
                    <h6 class="text-muted small">NGÀY & GIỜ</h6>
                    <p class="fw-bold text-dark">{{ date('d/m/Y', strtotime($suatChieu->ngay_chieu)) }} - {{ $suatChieu->gio_bat_dau }}</p>
                </div>
                <div class="col-md-3 border-end pb-3 pb-md-0">
                    <h6 class="text-muted small">GIÁ VÉ</h6>
                    <p class="fw-bold text-dark">{{ number_format($suatChieu->gia_ve) }} <small>VNĐ</small></p>
                </div>
                <div class="col-md-3">
                    <h6 class="text-muted small">TỔNG TIỀN</h6>
                    <p class="fw-bold" id="total-price" style="color: #c41e3a; font-size: 18px;">0 VNĐ</p>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Screen Display -->
        <div class="screen">
            <i class="bi bi-display"></i> MÀN HÌNH
        </div>

        <!-- Seats Selection Form -->
        <form action="{{ route('luu_ve_tam_thoi') }}" method="POST">
            @csrf
            <input type="hidden" name="suat_chieu_id" value="{{ $suatChieu->suat_chieu_id }}">

            <!-- Seats Grid -->
            <div class="text-center my-5">
                <div class="d-inline-block">
                    @foreach($gheTrongPhong->chunk(10) as $rowOfSeats)
                        <div class="d-flex justify-content-center mb-1">
                            @foreach($rowOfSeats as $ghe)
                                @php
                                    $isTaken = in_array($ghe->ghe_id, $gheDaDat);
                                    $statusClass = $isTaken ? 'taken' : 'available';
                                @endphp
                                <div class="seat {{ $statusClass }}" 
                                     data-ghe-id="{{ $ghe->ghe_id }}" 
                                     data-price="{{ $suatChieu->gia_ve }}"
                                     @if($isTaken) style="pointer-events: none;" @endif>
                                    {{ $ghe->ghe_id }}
                                </div>
                                @if(!$isTaken)
                                    <input type="checkbox" name="ghe_ids[]" value="{{ $ghe->ghe_id }}" class="seat-checkbox" style="display:none;">
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Seat Legend -->
            <div class="seat-legend text-center">
                <div class="legend-item">
                    <div class="seat available"></div>
                    <small><strong>Còn trống</strong></small>
                </div>
                <div class="legend-item">
                    <div class="seat available selected"></div>
                    <small><strong>Đã chọn</strong></small>
                </div>
                <div class="legend-item">
                    <div class="seat taken"></div>
                    <small><strong>Đã bán</strong></small>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-lg fw-bold" id="book-button" 
                        style="background: linear-gradient(135deg, #c41e3a 0%, #a01630 100%); color: white; border: none; padding: 12px 50px;" 
                        disabled>
                    <i class="bi bi-check-circle"></i> Xác Nhận Đặt Vé
                </button>
                <a href="{{ route('phim.show', $suatChieu->phim->phim_id) }}" class="btn btn-lg btn-outline-secondary ms-2" style="padding: 12px 50px;">
                    <i class="bi bi-arrow-left"></i> Quay Lại
                </a>
            </div>
        </form>
    </div>

    <script>
        const pricePerTicket = {{ $suatChieu->gia_ve }};
        const seats = document.querySelectorAll('.seat.available');
        const totalPriceEl = document.getElementById('total-price');
        const bookButton = document.getElementById('book-button');
        let selectedSeatsCount = 0;

        seats.forEach(seat => {
            seat.addEventListener('click', function() {
                if (this.classList.contains('available')) {
                    const checkbox = this.nextElementSibling;
                    
                    this.classList.toggle('selected');
                    checkbox.checked = !checkbox.checked;

                    if (this.classList.contains('selected')) {
                        selectedSeatsCount++;
                    } else {
                        selectedSeatsCount--;
                    }
                    
                    updateTotalPrice();
                    updateBookButtonStatus();
                }
            });
        });

        function updateTotalPrice() {
            const totalPrice = selectedSeatsCount * pricePerTicket;
            totalPriceEl.innerHTML = `<strong>Tổng tiền:</strong> ${totalPrice.toLocaleString('vi-VN')} VNĐ`;
        }

        function updateBookButtonStatus() {
            bookButton.disabled = selectedSeatsCount === 0;
        }

    </script>
@endsection
