<form method="post" action="{{ $action }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group {{ has_error($errors,"name") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Tên CLB <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <input class="form-control form-control-sm" name="name" type="text" placeholder="Nhập tên"
                       value="{{ old_input("name",$item ?? []) }}">
                {!! get_error($errors,"name") !!}
            </div>
        </div>
    </div>
    <div class="form-group {{ has_error($errors,"logo") }}">
        <div class="row">
            <div class="col-lg-2 col-sm-12">
                <b class="form-text mb-2">Logo</b>
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
                <img id="img-preview" alt="your image" class="my-3"
                     onerror="this.onerror=null;this.src='{{ asset("images/image-default.jpg") }}';"
                     src="{{ render_url_upload($item->logo ?? "") }}" width="250" height="250">

            </div>
        </div>
    </div>
    <input type="hidden" name="id" value="{{ $item->id ?? 0 }}">

    <div class="form-group {{ has_error($errors,"introduce") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Giới thiệu <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <textarea class="form-control form-control-sm" name="introduce" placeholder="Giới thiệu"
                >{{ old_input("introduce",$item ?? []) }}</textarea>
                {!! get_error($errors,"introduce") !!}
            </div>
        </div>
    </div>
    
    <div class="form-group {{ has_error($errors,"address") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Địa chỉ <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <textarea class="form-control form-control-sm" name="address" placeholder="Địa chỉ"
                >{{ old_input("address",$item ?? []) }}</textarea>
                {!! get_error($errors,"address") !!}
            </div>
        </div>
    </div>
    <div class="form-group {{ has_error($errors,"history") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Lịch sử <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <textarea class="form-control form-control-sm" name="history" placeholder="Lịch sử"
                >{{ old_input("history",$item ?? []) }}</textarea>
                {!! get_error($errors,"history") !!}
            </div>
        </div>
    </div>
    <div class="form-group {{ has_error($errors,"achievements") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Thành tựu <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <textarea id="editor" class="form-control form-control-sm" name="achievements" placeholder="Thành tựu"
                >{{ old_input("achievements",$item ?? []) }}</textarea>
                {!! get_error($errors,"achievements") !!}
            </div>
        </div>
    </div>

    <div class="form-group {{ has_error($errors,"contact") }}">
        <div class="row">
            <div class="col-2">
                <b class="form-text mb-2">Liên hệ <span class="text-danger">*</span></b>
            </div>
            <div class="col-10">
                <textarea class="form-control form-control-sm" name="contact" placeholder="Liên hệ"
                >{{ old_input("contact",$item ?? []) }}</textarea>
                {!! get_error($errors,"contact") !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-2"></div>
        <div class="col-10">
            <button type="submit" class="btn btn-primary btn-md">
                <i class="fa-solid fa-filter"></i>
                Lưu
            </button>
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