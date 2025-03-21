<form method="post" enctype="multipart/form-data" action="{{ $action }}">
    @csrf
    @if($type != "create")
        <input type="hidden" name="id" value="{{ $item->id }}">
    @endif

    <div class="form-group {{ has_error($errors,"name") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Họ tên <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <input class="form-control form-control-sm" name="name" type="text" placeholder="Nhập họ tên"
                       value="{{ old_input("name",$item ?? []) }}">
                <div class="text-sm text-danger mt-2 text-error-unique"></div>
                {!! get_error($errors,"name") !!}
            </div>
        </div>
    </div>
    <div class="form-group {{ has_error($errors,"email") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Email (Tên tài khoản) <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <input class="form-control form-control-sm" name="email" type="email" placeholder="Nhập email"
                       value="{{ old_input("email",$item ?? []) }}">
                <div class="text-sm text-danger mt-2 text-error-unique"></div>
                {!! get_error($errors,"email") !!}
            </div>
        </div>
    </div>
    <div class="form-group {{ has_error($errors,"phone_number") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Số điện thoại <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <input class="form-control form-control-sm" name="phone_number" type="text" placeholder="Nhập số điện thoại"
                       value="{{ old_input("phone_number",$item ?? []) }}">
                <div class="text-sm text-danger mt-2 text-error-unique"></div>
                {!! get_error($errors,"phone_number") !!}
            </div>
        </div>
    </div>
    <div class="form-group {{ has_error($errors,"status") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Trạng thái <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <select class="form-control form-control-sm" name="status">
                    <option value="">--Chọn trạng thái--</option>
                    @foreach(\Modules\Accounts\Models\Enums\AdminEnum::ARR_STATUS as $index => $value)
                        <option
                                {{ old_selected("status", (array)  ($item ?? []), $index) }}
                                value="{{ $index }}">{{ $value }}
                        </option>
                    @endforeach
                </select>
                {!! get_error($errors,"status") !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Sau khi lưu</b>
            </div>
            <div class="col-10 form-inline">
                <div class="form-check">
                    <input class="form-check-input" name="rdo_option" checked type="radio" value="0" id="continuce">
                    <label class="form-check-label ms-1" for="continuce">
                        Tiếp tục
                    </label>
                </div>
                <div class="form-check ms-3">
                    <input class="form-check-input" name="rdo_option" type="radio" value="1" id="returnList">
                    <label class="form-check-label ms-1" for="returnList">
                        Trở về danh sách
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-2"></div>
        <div class="col-10">
            @if($type == "create")
                <p class="fs-15px">Mật khẩu mặc định khi tạo của tài khoản là <b
                            class="text-danger fw-bold">{{ \Modules\Accounts\Models\Enums\AdminEnum::PASSWORD_DEFAULT }}</b>
                </p>
                <button type="submit" class="btn btn-primary btn-submit btn-md">
                    <i class="fa-solid fa-filter"></i>
                    Thêm
                </button>
            @else
                <button type="submit" class="btn btn-primary btn-submit btn-md">
                    <i class="fa-solid fa-filter"></i>
                    Cập nhật
                </button>
            @endif

            <a href="{{ route("get.admin.index") }}" class="btn btn-light">
                <i class="fa-solid fa-rotate-left"></i>
                Trở về danh sách
            </a>
        </div>
    </div>
</form>