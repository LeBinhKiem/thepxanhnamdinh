@extends('sell::layouts.master')
@section("title","Trang cá nhân")
@section("css")
    <link rel="stylesheet" href='{{ asset("plugins/nice-select2/nice-select2.css") }}'>
    <style>
        @media screen and (max-width: 994px) {
            .info {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
        }

    </style>
@stop
@section("script")
    <script src="{{ asset("plugins/jquery/jquery-validate.js") }}"></script>
    <script src="{{ asset("vendor/base/js/user_detail.js") }}"></script>
@stop
@section('content')
    <div class="container content">
{{--        {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("user:detail",$user->name) !!}--}}
        <div class="row mt-4">
            <div class="col-lg-3 ">
                @include("base::pages.user.includes.inc_tab")
            </div>
            <div class="col-lg-9">
                <div class="bg-white p-4">
                    <div class="row">
                        <div class="col-lg-2 col-sm-12">
                            <img src="{{ render_url_upload($user->logo) }}" alt=""
                                onerror="this.onerror=null;this.src='{{ asset("images/avatar-default.png") }}';"
                                width="120px" height="120px" class="rounded-circle border shadow-lg">
                        </div>
                        <div class="col-lg-10 col-sm-12 info mt-2">
                            <h4 class="fw-bold">
                                {{ $user->full_name }}
                            </h4>
                            <div class="opacity-75 mb-2">Tên tài khoản: {{ $user->name }}</div>
                            <div class="opacity-75 mb-2">Số điện thoại: {{ $user->number_phone }}</div>
                            <div class="opacity-75 mb-2">Địa chỉ: {{ $user->short_desc }}</div>
                            <button class="btn btn-light p-2" data-bs-toggle="modal"
                                    data-bs-target="#modal-update-user">
                                <i class="fa-solid fa-user-pen me-2"></i>
                                Chỉnh sửa
                            </button>
                            @include("base::pages.user.includes.modals._inc_modal_update_user")
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

