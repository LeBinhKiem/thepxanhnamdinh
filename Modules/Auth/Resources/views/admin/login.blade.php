@extends('auth::admin.layouts.auth_base')
@section('css')

@stop
@section('content')
    <div class="p-3">
        <div class="fw-bold mb-4 fs-30px title text-center">Đăng nhập</div>
        <form method="post">
            @csrf
            <div class="form-group {{ has_error($errors,"email") }} mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="text" name="email" value="{{ old_input("email") }}" class="form-control p-10px"
                       placeholder="Nhập email">
                {!! get_error($errors, "email") !!}
            </div>
            <div class="form-group {{ has_error($errors,"password") }} mb-4">
                <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                <div class="field-password">
                    <input type="password" name="password" id="password" placeholder="Nhập mật khẩu"
                           value="{{ old_input("password") }}" class="form-control p-10px">
                    <div class="show-password">
                        <i class="fa-regular icon-not-show fa-eye-slash"></i>
                        <i class="fa-regular icon-show fa-eye"></i>
                    </div>
                </div>
                {!! get_error($errors, "password") !!}
            </div>
            <div class="mb-4 form-check d-flex justify-content-between">
                <div class="">
                    <input type="checkbox" name="remember" {{ old_checked("remember",[], 1) }} class="form-check-input"
                           value="1" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Nhớ mật khẩu</label>
                    <a href="{{ route("get.auth.forget_password") }}" class="ms-3">Quên mật khẩu?</a>
                </div>
            </div>
            <button type="submit" class="btn btn-default w-100">Đăng nhập</button>
        </form>
    </div>
@endsection
@section("script")
    <script>
        $(".show-password").click(function () {
            if ($(this).hasClass("active")) {
                $(this).removeClass("active")
                $("#password").attr("type", "password")
            } else {
                $(this).addClass("active")
                $("#password").attr("type", "text")
            }
        })
    </script>
@endsection