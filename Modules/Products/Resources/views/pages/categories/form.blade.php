<form method="post" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if($type != "create")
        <input type="hidden" name="id" value="{{ $item->id }}">
    @endif

    <div class="form-group {{ has_error($errors,"name") }}">
        <div class="row">
            <div class="col-lg-2 col-sm-12">
                <b class="form-text mb-2">Tên danh mục <span class="text-danger">*</span></b>
            </div>
            <div class="col-lg-10 col-sm-12">
                <input class="form-control form-control-sm" name="name" type="text" placeholder="Tên danh mục"
                       value="{{ old_input("name",$item ?? []) }}">
                {!! get_error($errors,"name") !!}
            </div>
        </div>
    </div>
    <div class="form-group {{ has_error($errors,"status") }}">
        <div class="row">
            <div class="col-lg-2 col-sm-12">
                <b class="form-text mb-2">Trạng thái <span class="text-danger">*</span></b>
            </div>
            <div class="col-lg-10 col-sm-12">
                <select class="form-control form-control-sm" name="status">
                    <option value="">--Chọn trạng thái--</option>
                    @foreach(\Modules\Products\Enums\CategoriesEnum::ARR_STATUS as $index => $value)
                        <option
                                {{ old_selected("status",(array) ($item ?? []), $index) }}
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
            <div class="col-lg-2 col-sm-12">
                <b class="form-text mb-2">Sau khi lưu</b>
            </div>
            <div class="col-lg-10 col-sm-12 form-inline">
                <div class="form-check me-3">
                    <input class="form-check-input" name="rdo_option" checked type="radio" value="0" id="continuce">
                    <label class="form-check-label ms-1" for="continuce">
                        Tiếp tục
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="rdo_option" type="radio" value="1" id="returnList">
                    <label class="form-check-label ms-1" for="returnList">
                        Trở về danh sách
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 col-sm-12"></div>
        <div class="col-lg-10 col-sm-12">
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

            <a href="{{ route("get.categories.index") }}" class="btn btn-light "><i
                        class="fa-solid fa-rotate-left"></i> Trở
                về danh sách</a>
        </div>
    </div>
</form>