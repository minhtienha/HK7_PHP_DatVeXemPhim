@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1>{{ $thanh_cong ? '✅ Thanh toán thành công!' : '❌ Thanh toán thất bại!' }}</h1>
    

    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Về trang chủ</a>
</div>
@endsection
