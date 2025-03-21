@extends('sell::layouts.master')
@section("title","Tài khoản của bạn đã bị khóa")
@section("css")

@stop
@section("script")

@stop
@section('content')
    <div class="container content">
        <div class="d-flex flex-column align-items-center justify-content-center">
            <img class="w-50" src="{{ asset("images/lock.jpg") }}">
            <div class="mt-3 mb-4 d-flex flex-column align-items-center justify-content-center">
                <h4 class="mb-2">Tài khoản của bạn đã bị khóa</h4>
                <div class="w-70">
                    Lý do: <b>{{ $reasonLock->reason ?? "" }}</b>
                </div>
                <div class="text-danger mt-1">Thời gian
                    khóa: {{ $reasonLock->updated_at ?? "Đang cập nhật"  }}</div>
                <div class="mt-1">
                    Nếu bạn cho rằng việc khóa tài khoản là nhầm lẫn, bạn có thể liên hệ nhân viên hỗ trợ để xử lý
                    vấn đề này này
                </div>
            </div>
        </div>
    </div>
@endsection

