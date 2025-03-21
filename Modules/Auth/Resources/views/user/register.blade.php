@extends('auth::user.layouts.auth_base')
@section('css')

@endsection
@section("title","Đăng ký")
@section('content')
    <div class="login-left__body">
        <div class="fw-bold mb-4 title text-center">Đăng kí</div>
        <form method="post">
            @csrf
            <div class="mb-3 form-group {{ has_error($errors, "full_name") }}">
                <label for="exampleInputEmail1" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                <input type="text" class="form-control p-10px" name="full_name" placeholder="Nhập họ và tên" value="{{ old_input("full_name") }}">
                {!! get_error($errors, "full_name") !!}
            </div>
            <div class="mb-3 form-group {{ has_error($errors, "name") }}">
                <label for="exampleInputEmail1" class="form-label">Tài khoản đăng nhập <span class="text-danger">*</span></label>
                <input type="text" class="form-control p-10px" name="name" placeholder="Nhập tên tài khoản" value="{{ old_input("name") }}" }}>
                {!! get_error($errors, "name") !!}
            </div>
            <div class="mb-3 form-group {{ has_error($errors, "email") }}">
                <label for="exampleInputEmail1" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="text" class="form-control p-10px" value="{{ old_input("email") }}" name="email" placeholder="Nhập tên tài khoản">
                {!! get_error($errors, "email") !!}
            </div>
            <div class="mb-3 form-group {{ has_error($errors, "password") }}">
                <label for="exampleInputPassword1" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                <div class="field-password">
                    <input type="password" id="password" name="password" value="{{ old_input("password") }}" placeholder="Nhập mật khẩu" class="form-control p-10px">
                    <div class="show-password">
                        <i class="fa-regular icon-not-show fa-eye-slash"></i>
                        <i class="fa-regular icon-show fa-eye"></i>
                    </div>
                </div>
                {!! get_error($errors, "password") !!}
            </div>
            <button type="submit" class="btn btn-default w-100 mt-4">Đăng kí</button>
        </form>
        <div class="fs-6 login-left__header text-center mt-5">Bạn đã có tài khoản? <a
                href="{{ route("get.auth_user.login") }}">Đăng nhập ngay</a></div>
        <div class="mt-2 text-center">Hoặc trở về <a href="{{ route("get.sell.index") }}">trang chủ</a></div>
    </div>
@endsection
