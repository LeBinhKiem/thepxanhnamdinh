<form method="post" action="{{ $action }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group {{ has_error($errors,"name") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Tên sản phẩm <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <input class="form-control form-control-sm" name="name" type="text" placeholder="Nhập tên sản phẩm"
                       value="{{ old_input("name",$item ?? []) }}">
                {!! get_error($errors,"name") !!}
            </div>
        </div>
    </div>
    <div class="form-group {{ has_error($errors,"image") }}">
        <div class="row">
            <div class="col-lg-2 col-sm-12">
                <b class="form-text mb-2">Ảnh</b>
            </div>
            <div class="col-lg-10 col-sm-12">
                <label class="btn btn-success" for="image">
                    Chọn ảnh
                </label>
                <input class="form-control form-control-sm hide" id="image" name="image"
                       type="file"
                       onchange="document.getElementById('img-preview').src = window.URL.createObjectURL(this.files[0])"
                       value="">
                       {!! get_error($errors,"image") !!}
                <br>
                <img id="img-preview" alt="your image" class=""
                     onerror="this.onerror=null;this.src='{{ asset("images/image-default.jpg") }}';"
                     src="{{ render_url_upload($item->image ?? "") }}" width="250" height="200">

            </div>
        </div>
    </div>
    @if($type != "create")
        <input type="hidden" name="id" value="{{ $item->id }}">
    @endif

    <div class="form-group {{ has_error($errors,"amount") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Số lượng<span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <input type="number" class="form-control" name="amount" value="{{ $item->amount ?? 1 }}" placeholder="Nhập số tiền gốc">
                {!! get_error($errors,"amount") !!}
            </div>
        </div>
    </div>
    <div class="form-group {{ has_error($errors,"price") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Giá tiền gốc<span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <input type="number" class="form-control" name="price" value="{{ $item->price ?? 0 }}" placeholder="Nhập số tiền gốc">
                {!! get_error($errors,"price") !!}
            </div>
        </div>
    </div>
    <div class="form-group {{ has_error($errors,"percent_sale") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Giảm giá<span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <input type="number" class="form-control" name="percent_sale" value="{{ $item->percent_sale ?? 0 }}" placeholder="Nhập số tiền gốc">
                {!! get_error($errors,"percent_sale") !!}
            </div>
        </div>
    </div>

    <div class="form-group {{ has_error($errors,"category_id") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Danh mục sản phẩm <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <select class="form-control form-control-sm" name="category_id">
                    <option value="">--Chọn danh mục sản phẩm--</option>
                    @foreach($categories as $category)
                        <option
                                {{ old_selected("category_id",$item ?? [] , $category->id) }}
                                value="{{ $category->id }}">{{ $category->name }}
                        </option>
                    @endforeach
                </select>
                {!! get_error($errors,"category_id") !!}
            </div>
        </div>
    </div>
    <div class="form-group {{ has_error($errors,"description") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Mô tả <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <textarea class="form-control form-control-sm" name="description" placeholder="Mô tả"
                >{{ old_input("description",$item ?? []) }}</textarea>
                {!! get_error($errors,"description") !!}
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
                    @foreach(\Modules\Products\Enums\ProductEnum::ARR_STATUS as $index => $value)
                        <option
                                {{ old_selected("status", $item ?? [], $index) }}
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

            <a href="{{ route("get.products.index") }}" class="btn btn-light "><i
                        class="fa-solid fa-rotate-left"></i> Trở
                về danh sách</a>
        </div>
    </div>
</form>