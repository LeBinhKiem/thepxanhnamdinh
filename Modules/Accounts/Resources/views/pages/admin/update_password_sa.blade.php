@extends('base::layouts.master')
@section("breadcrumb")
    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("admin::update_password") !!}
@endsection
@section('content')
    <form action="{{ route("post.admin.updatePasswordBySuperAdmin") }}" method="post">
        @csrf
        <div class="form-group {{ has_error($errors,"new_password") }}">
            <div class="row">
                <div class="col-2">
                    <b class="form-text mb-2">Mật khẩu mới <span class="text-danger">*</span></b>
                </div>
                <div class="col-10">
                    <input class="form-control form-control-sm" name="new_password" type="text"
                           placeholder="Nhập mật khẩu mới"
                           value="{{ old_input("new_password",$item ?? []) }}">
                    <input class="form-control form-control-sm" name="id" type="hidden"
                           value="{{ $id }}">
                    <div class="text-sm text-danger mt-2 text-error-unique"></div>
                    {!! get_error($errors,"new_password") !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-10">
                <button type="submit" class="btn btn-primary btn-submit btn-md">
                    <i class="fa-solid fa-filter"></i>
                    Cập nhật
                </button>
                <a href="{{ route("get.admin.index") }}" class="btn btn-light">
                    <i class="fa-solid fa-rotate-left"></i>
                    Trở về danh sách
                </a>
            </div>
        </div>
    </form>
@endsection

