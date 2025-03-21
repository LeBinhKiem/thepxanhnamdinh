<form method="post" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if($type != "create")
        <input type="hidden" name="id" value="{{ $item->id }}">
    @endif
    <div class="form-group {{ has_error($errors,"title") }}{{ has_error($errors,"slug") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Tiêu đề <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <input class="form-control form-control-sm" name="title" type="text" placeholder="Nhập tiêu đề"
                       value="{{ old_input("title",$item ?? []) }}">
                {!! get_error($errors,"title") !!}
                {!! get_error($errors,"slug") !!}
            </div>
        </div>
    </div>
    <div class="form-group {{ has_error($errors,"logo") }}">
        <div class="row">
            <div class="col-lg-2 col-sm-12">
                <b class="form-text mb-2">Ảnh <span class="text-danger">*</span></b>
            </div>
            <div class="col-lg-10 col-sm-12">
                <label class="btn btn-success" for="logo">
                    Chọn ảnh
                </label>
                <input class="form-control form-control-sm hide" id="logo" name="logo"
                       type="file"
                       onchange="document.getElementById('img-preview').src = window.URL.createObjectURL(this.files[0])"
                       value="">
                       {!! get_error($errors,"logo") !!}
                <br>
                <img id="img-preview" alt="your image" class=""
                     onerror="this.onerror=null;this.src='{{ asset("images/image-default.jpg") }}';"
                     src="{{ render_url_upload($item->logo ?? "") }}" width="250" height="200">
            </div>
        </div>
    </div>
    <div class="form-group {{ has_error($errors,"blog_category_id") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Chuyên mục<span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <select class="form-control form-control-sm" name="blog_category_id">
                    <option value="">--Chọn danh mục--</option>
                    @foreach($blogCategories  as  $blogCategory)
                        <option
                                {{ old_selected("blog_category_id", $item ?? [], $blogCategory["id"]) }} class="fw-bold"
                                value="{{ $blogCategory["id"] }}">{{ $blogCategory["name"] }}
                        </option>
                        @if(isset($blogCategory["child"]) && count($blogCategory["child"]) > 0)
                            @foreach($blogCategory["child"] as $itemChild)
                                <option
                                        {{ old_selected("blog_category_id",  $item ?? [], $itemChild["id"]) }}
                                        value="{{ $itemChild["id"] }}">---- {{ $itemChild["name"] }}
                                </option>
                            @endforeach
                        @endif
                    @endforeach
                </select>
                {!! get_error($errors,"blog_category_id") !!}
            </div>
        </div>
    </div>

    <div class="form-group {{ has_error($errors,"short_description") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Mô tả ngắn <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <textarea class="form-control form-control-sm"  name="short_description" placeholder="Mô tả ngắn"
                >{{ old_input("short_description",$item ?? []) }}</textarea>
                {!! get_error($errors,"short_description") !!}
            </div>
        </div>
    </div>
    
    <div class="form-group {{ has_error($errors,"content") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Nội dung <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <textarea class="form-control form-control-sm" id="editor" name="content" placeholder=""
                >{!! old_input("content",$item ?? []) !!}</textarea>
                {!! get_error($errors,"content") !!}
            </div>
        </div>
    </div>

    <div class="form-group {{ has_error($errors,"tag") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Tag <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <input class="w-100 rounded-1" name="tag" value='{{ old_input("tag",$item ?? []) }}' type="text" placeholder="Nhập tag">
                {!! get_error($errors,"tag") !!}
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
                    @foreach(\Modules\Products\Enums\BLogEnum::ARR_STATUS as $index => $value)
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

            <a href="{{ route("get.blog.index") }}" class="btn btn-light "><i
                        class="fa-solid fa-rotate-left"></i> Trở
                về danh sách</a>
        </div>
    </div>
</form>
<script type="text/javascript" src="{{ asset("plugins/ckeditor4/ckeditor.js") }}"></script>
<script src="{{ asset("plugins/tagify/tagify.js") }}"></script>
<script >
    var editor = CKEDITOR.replace('editor'
        , {
            filebrowserUploadUrl: '{{ route("api.file.upload", ['_token' => csrf_token() ]) }}',
            filebrowserUploadMethod: 'form',
            extraPlugins: 'image2, ckeditor_wiris',
            image2_disableResizer: true,
            allowedContent: true
        }
    );

    var input = document.querySelector('input[name=tag]')
    var tagify = new Tagify(input, {
        dropdown: {
            enabled: 0
        },
    })

</script>