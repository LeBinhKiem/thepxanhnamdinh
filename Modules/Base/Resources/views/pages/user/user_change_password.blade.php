@extends('sell::layouts.master')
@section("css")
@stop
@section("title","Thay đổi mật khẩu")
@section("script")
    <script src="{{ asset("plugins/jquery/jquery-validate.js") }}"></script>
    <script src="{{ asset("vendor/base/js/user_change_password.js") }}"></script>
@stop
@section('content')
    <div class="container content">
{{--        {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("user:change_password") !!}--}}
        <div class="row mt-4">
            <div class="col-lg-3">
                @include("base::pages.user.includes.inc_tab")
            </div>
            <div class="col-lg-9">
                <div class="p-4 bg-white">
                    <h2>Đổi mật khẩu</h2>
                    <p class="fs-14px">Thay đổi mật khẩu người dùng. Nếu bạn quên mật khẩu, xin vui lòng lấy lại mật khẩu <a
                            href="{{route('get.auth_user.forget_password')}}">Tại đây!</a></p>

                    <form action="{{ route('post.user.change_password') }}" method="post" id="form-change-password">
                        @csrf
                        <div class="form-group mt-4">
                            <label class="form-label">Mật khẩu cũ</label>
                            <input type="text" class="form-control" name="old_password" value="{{ old_input("old_password") }}">
                        </div>
                        <div class="form-group mt-4">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="text" class="form-control" name="new_password" id="new_password"
                                   value="{{ old_input("new_password") }}">
                        </div>
                        <div class="form-group mt-4">
                            <label class="form-label">Nhập lại mật khẩu mới</label>
                            <input type="text" class="form-control" name="new_password_again"
                                   value="{{ old_input("new_password_again") }}">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary-web mt-5 ">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

