<form method="post" action="{{ $action }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group {{ has_error($errors,"title") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Tiêu đề <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <input class="form-control form-control-sm" name="title" type="text" placeholder="Nhập tiêu đề"
                       value="{{ old_input("title",$item ?? []) }}">
                {!! get_error($errors,"title") !!}
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

    <div class="form-group {{ has_error($errors,"youtube") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Link youtube <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <input class="form-control form-control-sm" name="youtube" type="text" placeholder="Nhập link youtube"
                       value="{{ old_input("youtube",$item ?? []) }}">
                {!! get_error($errors,"youtube") !!}
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

            <a href="{{ route("get.medias.index") }}" class="btn btn-light "><i
                        class="fa-solid fa-rotate-left"></i> Trở
                về danh sách</a>
        </div>
    </div>
</form>
