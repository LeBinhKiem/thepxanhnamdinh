<form method="post" action="{{ $action }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group {{ has_error($errors,"name") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Họ và tên <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <input class="form-control form-control-sm" name="name" type="text" placeholder="Nhập tên"
                       value="{{ old_input("name",$item ?? []) }}">
                {!! get_error($errors,"name") !!}
            </div>
        </div>
    </div>
    <div class="form-group {{ has_error($errors,"avatar") }}">
        <div class="row">
            <div class="col-lg-2 col-sm-12">
                <b class="form-text mb-2">Ảnh</b>
            </div>
            <div class="col-lg-10 col-sm-12">
                <label class="btn btn-success" for="avatar">
                    Chọn ảnh
                </label>
                <input class="form-control form-control-sm hide" id="avatar" name="avatar"
                       type="file"
                       onchange="document.getElementById('img-preview').src = window.URL.createObjectURL(this.files[0])"
                       value="">
                       {!! get_error($errors,"avatar") !!}
                <br>
                <img id="img-preview" alt="your image" class=""
                     onerror="this.onerror=null;this.src='{{ asset("images/image-default.jpg") }}';"
                     src="{{ render_url_upload($item->avatar ?? "") }}" width="250" height="200">

            </div>
        </div>
    </div>
    @if($type != "create")
        <input type="hidden" name="id" value="{{ $item->id }}">
    @endif

    <div class="form-group {{ has_error($errors,"birth_day") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Sinh nhật <span class="text-danger">*</span></b> (mm-dd-yyyy)
            </div>
            <div class="col-10">
                <input class="form-control form-control-sm" name="birth_day" id="birth_day" type="text" readonly="readonly" placeholder="Sinh nhật"
                       value="{{ date("m/d/Y", strtotime(old_input("birth_day",$item ?? []))) }}">
                <br>
                <input class="form-control form-control-sm" name="birth_day_choose" id="birth_day_choose" type="date" placeholder="Chọn sinh nhật"
                       value="\">
                {!! get_error($errors,"birth_day") !!}
            </div>
        </div>
    </div>
    <div class="form-group {{ has_error($errors,"position") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Vị trí <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <select class="form-control form-control-sm" name="position">
                    <option value="">--Chọn vị trí--</option>
                    @foreach(\Modules\Products\Enums\CoachEnum::POSITION as $index => $value)
                        <option
                                {{ old_input("position", $item ?? []) == $value ? "selected" : "" }}
                                value="{{ $value }}">{{ $value }}
                        </option>
                    @endforeach
                </select>
                {!! get_error($errors,"position") !!}
            </div>
        </div>
    </div>
    <div class="form-group {{ has_error($errors,"address") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Quê quán <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <textarea class="form-control form-control-sm" name="address" placeholder="Địa chỉ"
                >{{ old_input("address",$item ?? []) }}</textarea>
                {!! get_error($errors,"address") !!}
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
                <button type="submit" class="btn btn-primary btn-md">
                    <i class="fa-solid fa-filter"></i>
                    Thêm
                </button>
            @else
                <button type="submit" class="btn btn-primary btn-md">
                    <i class="fa-solid fa-filter"></i>
                    Cập nhật
                </button>
            @endif

            <a href="{{ route("get.coaches.index") }}" class="btn btn-light "><i
                        class="fa-solid fa-rotate-left"></i> Trở
                về danh sách</a>
        </div>
    </div>
</form>
<script>
    document.getElementById('birth_day_choose').addEventListener('change', function() {
        var birthDayChooseValue = this.value;
        var dateParts = birthDayChooseValue.split('-');
        var formattedDate = dateParts[1] + '/' + dateParts[2] + '/' + dateParts[0];
        document.getElementById('birth_day').value = formattedDate;
    });
</script>