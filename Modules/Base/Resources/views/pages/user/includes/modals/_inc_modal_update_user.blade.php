<div class="modal fade" id="modal-update-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content p-3" style="overflow: scroll">
            <form action="{{ route("get.user.update_user") }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3 col-sm-12 mb-2"><b>Ảnh đại diện</b></div>
                        <div class="col-lg-9 col-sm-12">
                            <label for="logo"
                                   class="overflow-hidden d-flex align-items-center justify-content-center decord cs-pointer border-2 border"
                                   style="width: 120px; height: 120px; border-radius: 50%">
                                <img src="{{ render_url_upload($user->logo) }}" alt="" class="" id="img-preview"
                                     onerror="this.onerror=null;this.src='{{ asset("images/avatar-default.png") }}';"
                                     width="140px">
                                <i class="fa-solid fa-floppy-disk decord-bottom-right text-black border-1 border d-flex align-items-center justify-content-center fs-18px bg-white"
                                   style="right: 18px; padding: 4px; border-radius: 50%;  bottom: 10px">

                                </i>
                                <input type="file" class="hide" name="logo" id="logo"
                                       onchange="document.getElementById('img-preview').src = window.URL.createObjectURL(this.files[0])">
                            </label>
                        </div>
                        <hr class="mt-4">
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-3 col-sm-12 mb-2">
                            <b>Tên đầy đủ <span class="text-danger">*</span></b>
                        </div>
                        <div class="col-lg-9 col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="full_name" value="{{ $user->full_name }}">
                                <div class="fs-13px opacity-50 mt-1">
                                    Tên của bạn có thể thay đổi không giới hạn
                                </div>
                            </div>
                        </div>
                        <hr class="mt-4">
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-3 col-sm-12 mb-2">
                            <b>Địa chỉ</b>
                        </div>
                        <div class="col-lg-9 col-sm-12 ">
                            <div class="form-group">
                                <textarea name="short_desc" class="form-control"
                                          rows="5">{{ $user->short_desc }}</textarea>
                                <div class="fs-13px opacity-50 mt-1">
                                    Ví dụ: Đống Đa, Hà Nội,...
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-3 col-sm-12 mb-2">
                            <b>Số điện thoại</b>
                        </div>
                        <div class="col-lg-9 col-sm-12 ">
                            <div class="form-group">
                                <input name="number_phone" class="form-control" value="{{ $user->number_phone ?? "" }}" type="text">
                                <div class="fs-13px opacity-50 mt-1">
                                    Ví dụ: 08357800
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 0;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fa-solid fa-xmark me-1"></i> Đóng
                    </button>
                    <button type="button" class="btn btn-primary-web js-submit"><i class="fa-solid  fa-floppy-disk me-1"></i>
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
