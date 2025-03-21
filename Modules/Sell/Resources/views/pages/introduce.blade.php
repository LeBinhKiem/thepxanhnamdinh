@extends("sell::layouts.master")
@section("css")
    <style>
        .border-left {
            border-color: #ff6e4e !important;
        }

        .img-radius-top {
            height: 480px;
            object-fit: cover;
            object-position: center center;
            border-radius: 180px 180px 10px 10px;
        }

        .table thead th {
            border-bottom: white 1px solid;
            border-top: none;
        }

        .table > :not(caption) > * > * {
            background-color: #472f92;
            color: #fff;
        }
    </style>
@stop
@section("content")
    @php
        $info = \Illuminate\Support\Facades\DB::table("info")->first();
        $info->introduce = str_replace("\n", "<br>", $info->introduce);
        $info->history = str_replace("\n", "<br>", $info->history);
        $info->achievements = str_replace("\n", "<br>", $info->achievements);
        $info->contact = str_replace("\n", "<br>", $info->contact);
    @endphp

    <div class="container mt-5">
        <div class="fw-bold">GIỚI THIỆU</div>
        <div class="mt-3">
            {!! $info->introduce ?? "" !!}
        </div>
        <div class="fw-bold mt-3">LOGO ĐỘI BÓNG</div>
        <div class="mt-3">
            <img src="{{ render_url_upload($info->logo) }}" alt="" style="width: 200px;">
        </div>
        <div class="fw-bold mt-3">LỊCH SỬ HÌNH THÀNH VÀ PHÁT TRIỂN</div>
        <div class="mt-3">
            {!! $info->history ?? "" !!}
        </div>
        <div class="fw-bold mt-3">THÀNH TÍCH VÀ NHỮNG DANH HIỆU
        </div>
        <div class="">
            {!! $info->achievements ?? "" !!}
        </div>
        <div class="fw-bold mt-3">LIÊN HỆ
        </div>
        <div class="mt-3 mb-5">
            {!! $info->contact ?? "" !!}
        </div>
        
    </div>
@stop