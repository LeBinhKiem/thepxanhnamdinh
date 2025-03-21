@extends('auth::user.layouts.auth_base')
@section('css')

@endsection
@section("title","Quên mật khẩu")
@section('content')
    <div class="login-left__body">
        <div class="fw-bold mb-4 title text-center">Quên mật khẩu</div>
        <form method="post" action="{{ route("post.auth_user.forget_password") }}">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control p-10px" name="email" value="{{ old_input("email") }}" placeholder="Nhập email" required>
            </div>
            <button type="submit" class="btn btn-default w-100 mt-4">Gửi</button>
        </form>
        <div class="fs-6 login-left__header text-center mt-5">Bạn đã có tài khoản? <a
                href="{{ route("get.auth_user.login") }}">Đăng nhập ngay</a></div>
    </div>
@endsection
