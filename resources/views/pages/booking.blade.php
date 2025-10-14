@extends('layouts.app')

@section('title', 'Chọn ghế - ' . $suatChieu->phim->ten_phim)

@push('styles')
<style>
    .seat {
        width: 30px;
        height: 30px;
        margin: 5px;
        border-radius: 5px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        font-size: 10px;
        cursor: pointer;
        border: 1px solid #ccc;
        background-color: #e9ecef;
        transition: all 0.2s;
    }
    .seat.available:hover {
        background-color: #d1e7dd;
    }
    .seat.available.selected {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
    .seat.taken {
        background-color: #dc3545;
        color: white;
        cursor: not-allowed;
    }
    .screen {
        width: 80%;
        height: 20px;
        background-color: #343a40;
        margin: 20px auto;
        color: white;
        text-align: center;
        line-height: 20px;
        border-radius: 5px;
    }
</style>
@endpush

@section('content')
    <div class="container my-5">
        <h2 class="text-center mb-4">Đặt vé xem phim: {{ $suatChieu->phim->ten_phim }}</h2>
        <div class="card shadow-sm p-4 mb-4">
            <p><strong>Phòng chiếu:</strong> {{ $suatChieu->phongChieu->ten_phong }}</p>
            <p><strong>Ngày:</strong> {{ date('d-m-Y', strtotime($suatChieu->ngay_chieu)) }}</p>
            <p><strong>Giờ:</strong> {{ $suatChieu->gio_bat_dau }}</p>
            <p><strong>Giá vé:</strong> {{ number_format($suatChieu->gia_ve) }} VNĐ/ghế</p>
            <p class="text-primary" id="total-price"><strong>Tổng tiền:</strong> 0 VNĐ</p>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <div class="screen">MÀN HÌNH</div>

            <form action="{{ route('luu_ve_tam_thoi') }}" method="POST">

                @csrf
                <input type="hidden" name="suat_chieu_id" value="{{ $suatChieu->suat_chieu_id }}">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        @foreach($gheTrongPhong->chunk(10) as $rowOfSeats) 
                        <div class="d-flex justify-content-center mb-2">
                            @foreach($rowOfSeats as $ghe)
                                @php
                                    $isTaken = in_array($ghe->ghe_id, $gheDaDat);

                                    $statusClass = 'available';
                                    if ($isTaken) {
                                        $statusClass = 'taken';
                                    }
                                @endphp
                                <div class="seat {{ $statusClass }}" 
                                    data-ghe-id="{{ $ghe->ghe_id }}" 
                                    data-price="{{ $suatChieu->gia_ve }}">
                                    {{ $ghe->ghe_id }}
                                </div>
                                @if(!$isTaken)
                                    <input type="checkbox" name="ghe_ids[]" value="{{ $ghe->ghe_id }}" class="seat-checkbox" style="display:none;">
                                @endif
                                @if ($isTaken)
                                    
                                @endif
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg" id="book-button" disabled>Đặt vé</button>
                </div>
            
            <div class="text-center mt-3">
                <span class="seat taken"></span> Đã bán |
                <span class="seat available" style="background-color:#e9ecef; border-color:#ccc;"></span> Còn trống |
                <span class="seat available selected"></span> Đã chọn
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
