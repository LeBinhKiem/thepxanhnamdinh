@extends('auth::user.layouts.auth_base')
@section("css")

@stop
@section("title","Đăng nhập")

@section('content')
    <div class="login-left__body">
        <div class="fw-bold mb-4 title text-center">Đăng nhập</div>
        <form method="post">
            @csrf
            <div class="form-group {{ has_error($errors,"name") }} mb-3">
                <label for="exampleInputEmail1" class="form-label">Tài khoản</label>
                <input type="text" class="form-control p-10px" name="name" placeholder="Nhập tài khoản" value="{{ old_input("name") }}">
                {!! get_error($errors, "name") !!}
            </div>
            <div class="form-group {{ has_error($errors,"password") }} mb-4">
                <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                <div class="field-password">
                    <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" class="form-control p-10px" style="padding-right: 36px" value="{{ old_input("password") }}">
                    <div class="show-password">
                        <i class="fa-regular icon-not-show fa-eye-slash"></i>
                        <i class="fa-regular icon-show fa-eye"></i>
                    </div>
                </div>
                {!! get_error($errors, "password") !!}
            </div>
            <div class="mb-4 form-check d-flex justify-content-between">
                <div class="">
                    <input type="checkbox" class="form-check-input" name="remember" {{ old_checked("remember",[], 1) }} value="1" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Nhớ mật khẩu</label>
                </div>
                <a href="{{ route("get.auth_user.forget_password") }}" class="">Quên mật khẩu?</a>
            </div>
            <button type="submit" class="btn btn-default w-100">Đăng nhập</button>
        </form>
        .
        <div class="d-flex justify-content-center align-content-center">
            <hr class="w-50">
            <small class="d-flex justify-content-center me-2 ms-2">Hoặc</small>
            <hr class="w-50">
        </div>
        <div class="fs-6 login-left__header text-center mt-5">Bạn chưa có tài khoản? <a
                href="{{ route("get.auth_user.register") }}">Đăng kí ngay</a></div>
        <div class="mt-2 text-center">Hoặc trở về <a href="{{ route("get.sell.index") }}">trang chủ</a></div>
    </div>
@endsection

