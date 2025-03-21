@extends('base::layouts.master')
@section("breadcrumb")
    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("admin::setting") !!}
@endsection
@section("css")
    <style>
        button.nav-link {
            box-shadow: none !important;
            width: 100%;
        }

        .nav-pills .nav-item {
            padding-right: 0 !important;
        }

        .edit-infor {
            cursor: pointer;
        }

        .edit-infor:hover {
            color: rgba(0, 0, 0, 0.89) !important;
        }

        .preview {
            border-right: 1px solid rgba(0, 0, 0, 0.1);
        }

        @media screen and (max-width: 990px) {
            .preview {
                border: none;
            }
        }

        .icon-phone {
            position: absolute;
            padding: 5px;
            width: 30px;
            height: 30px;
            background-color: #e0dede;
            border-radius: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            bottom: -5px;
            right: 5px;
        }

        .icon-phone i {
            color: black;
        }

    </style>
@endsection
@section('content')
    @php
        $tab = $query["tab"];
    @endphp
    <div class="row mt-3" style="min-height: 620px">
        <div class="col-sm-12 col-md-12 col-lg-3 preview">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <form style="position: relative" method="post" action="{{ route("post.admin.updateLogo") }}" enctype="multipart/form-data">
                    <label class="avatar rounded-circle border-primary-color-3px me-2" for="avatar"
                           style="min-height: 100px;min-width: 100px;">
                        <img alt="Image placeholder" style="height: 100px"
                             onerror="this.onerror=null;this.src='{{ asset("images/avatar-default.png") }}';"
                             src="{{ \Dinhthang\FileUploader\Services\FileUploaderService::getInstance()->renderUrl($admin->logo) }}">
                        @csrf
                    </label>
                    <label for="avatar" class="icon-phone">
                        <i class="fa-solid fa-camera-retro fs-13px"></i>
                    </label>
                    <input id="avatar" onchange="form.submit()"  type="file" name="file" class="hide">
                </form>

                <b class="mt-3 text-center">{{ $admin->name }}</b>
                <div>{{ $admin->email }}</div>
                <div class="mt-1">
                    @if($admin->status == 1)
                        <span class="badge bg-success mt-1 fs-9px">Hoạt động</span>
                    @else
                        <span class="badge bg-success mt-1">Đã khóa</span>
                    @endif
                </div>
            </div>
            <div class="mt-5">
                <ul class="nav nav-pills d-flex flex-column mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="{{ route("get.admin.setting",["tab" =>"infor"]) }}">
                            <button class="nav-link {{ $tab == "infor" ? "active" : "" }}" id="pills-home-tab">
                                Thông tin tài khoản
                            </button>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="{{ route("get.admin.setting",["tab" =>"change-password"]) }}">
                            <button class="nav-link {{ $tab == "change-password" ? "active" : "" }}"
                                    id="change-password-tab">
                                Đổi mật khẩu
                            </button>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-9">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade {{ $tab == "infor" ? "show active" : "" }}" id="infor" role="tabpanel"
                     aria-labelledby="pills-home-tab">
                    <h3>Thông tin tài khoản</h3>
                    <small>Thông tin bao gồm thông tin cơ bản của admin và phương thức liên lạc</small>
                    <div id="infor-view">
                        <div class="info-item d-flex justify-content-between align-items-center mt-5">
                            <div>
                                <div class="text-muted fs-14px">ID</div>
                                <div class="mt-2">{{ $admin->id }}</div>
                            </div>
                            <div class="edit-infor text-muted" style="font-size: 13px">
                                <i class="fa-regular fa-pen-to-square"></i>
                                Chỉnh sửa
                            </div>
                        </div>
                        <hr>
                        <div class="info-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted fs-14px">Họ tên</div>
                                <div class="mt-2">{{ $admin->name }}</div>
                            </div>
                        </div>
                        <hr>
                        <div class="info-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted fs-14px">Số điện thoại</div>
                                <div class="mt-2">{{ $admin->phone_number }}</div>
                            </div>
                        </div>
                        <hr>
                        <div class="info-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted fs-14px">Skype</div>
                                <div class="mt-2">{{ $admin->skype }}</div>
                            </div>
                        </div>
                        <hr>
                        <div class="info-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted fs-14px">Giới tính</div>
                                <div class="mt-2">{{ \Modules\Accounts\Models\Enums\AdminEnum::ARR_SEX[$admin->sex] }}</div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <form action="" id="form-infor" class="hide mt-5" method="post">
                        <div class="form-group">
                            <b class="form-text mb-2">Họ tên <span class="text-danger">*</span></b>
                            <input class="form-control form-control-sm" name="name" type="text"
                                   value="{{ $admin->name }}">
                        </div>
                        <div class="form-group">
                            <b class="form-text mb-2">Số điện thoại <span class="text-danger">*</span></b>
                            <input class="form-control form-control-sm" name="phone_number" type="text"
                                   value="{{ $admin->phone_number }}">
                        </div>
                        <div class="form-group">
                            <b class="form-text mb-2">Skype</b>
                            <input class="form-control form-control-sm" name="skype" type="text"
                                   value="{{ $admin->skype }}">
                        </div>
                        <div class="form-group">
                            <b class="form-text mb-2">Giới tính <span class="text-danger">*</span></b>
                            <select class="form-control-sm form-control" name="sex">
                                <option value="">--Chọn--</option>
                                @foreach(\Modules\Accounts\Models\Enums\AdminEnum::ARR_SEX as $id => $value)
                                    <option {{ selectedCompareValue($id, $admin->sex) }} value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-regular fa-pen-to-square"></i>
                                Cập nhật
                            </button>
                            <div class="btn btn-light btn-exit">
                                <i class="fa-solid fa-xmark"></i>
                                Hủy
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade {{ $tab == "change-password" ? "show active" : "" }}" id="change-password"
                     role="tabpanel" aria-labelledby="change-password-tab">
                    <h3>Đổi mật khẩu</h3>
                    <small>Nếu bạn quên mật khẩu cũ, bạn nên gửi thông báo đến Admin Leader</small>
                    <form id="form-change-password" class="mt-5">
                        <div class="form-group">
                            <b class="form-text mb-2">Mật khẩu cũ <span class="text-danger">*</span></b>
                            <input class="form-control form-control-sm" type="password" name="old_password"
                                   value="">
                        </div>
                        <div class="form-group">
                            <b class="form-text mb-2">Mật khẩu mới <span class="text-danger">*</span></b>
                            <input class="form-control form-control-sm" id="password" type="password" name="new_password"
                                   value="">
                        </div>
                        <div class="form-group">
                            <b class="form-text mb-2">Nhập lại mật khẩu mới <span class="text-danger">*</span></b>
                            <input class="form-control form-control-sm" type="password" name="new_password_again"
                                   value="">
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-regular fa-pen-to-square"></i>
                                Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("script")
    <script>
        const URL_UPDATE_ADMIN = '{{ route("post.admin.update") }}';
        const URL_UPDATE_PASSWORD_ADMIN = '{{ route("post.admin.updatePasswordMyAccount") }}';
    </script>
    <script src="{{ asset("/plugins/jquery/jquery-validate.js") }}"></script>
    <script src="{{ asset("vendor/accounts/js/admin-setting.js") }}"></script>
@stop