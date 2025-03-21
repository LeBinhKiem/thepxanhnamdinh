const AdminSetting = {
    init() {
        this.validateForm();
        this.openFormInfor();
        this.updateAdmin();
    },
    validateForm() {
        $("#form-infor").validate({
            onfocusout: false,
            onkeyup: false,
            onclick: false,
            rules: {
                "name": {
                    required: true,
                },
                "phone_number": {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                },
                "sex": {
                    required: true,
                }
            },
            messages: {
                "name": {
                    required: "Bạn phải nhập họ tên",
                },
                "phone_number": {
                    required: "Bạn phải nhập số điện thoại",
                    minlength: "Số điện thoại gồm 10 số",
                    maxlength: "Số điện thoại gồm 10 số"
                },
                "sex": {
                    required: "Bạn phải nhập giới tính",
                }
            }
        });
        $("#form-change-password").validate({
            onfocusout: false,
            onkeyup: false,
            onclick: false,
            rules: {
                "old_password": {
                    required: true,
                },
                "new_password": {
                    required: true,
                    minlength: 8,
                },
                "new_password_again": {
                    required: true,
                    minlength: 8,
                }
            },
            messages: {
                "old_password": {
                    required: "Bạn phải nhập mật khẩu cũ",
                },
                "new_password": {
                    required: "Bạn phải nhập mật khẩu mới",
                    minlength: "Mật khẩu ít nhất 8 kí tự",
                },
                "new_password_again": {
                    required: "Bạn phải nhập đúng mật khẩu mới",
                    equalTo: "Bạn phải nhập đúng mật khẩu mới",
                    minlength: "Mật khẩu ít nhất 8 kí tự",
                }
            }
        });
    },

    openFormInfor() {
        $(".edit-infor, .btn-exit").click(function () {
            $("#infor-view").toggleClass("hide")
            $("#form-infor").toggleClass("hide")
        })
    },

    updateAdmin() {
        $("#form-infor").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            if (form.valid()) {
                $.ajax({
                    url: URL_UPDATE_ADMIN,
                    type: "post",
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (data) {
                        console.log(data.status)
                        if (data.status) {
                            toastr.success(data.message, data.title)
                            setTimeout(function () {
                                window.location = data.data["urlReload"];
                            }, 2000)
                        } else {
                            toastr.error(data.message, data.title)
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                })
            }
            else {
                toastr.warning("Yêu cầu nhập đủ thông tin","Cảnh báo");
            }
        });

        $("#form-change-password").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            if (form.valid()) {
                $.ajax({
                    url: URL_UPDATE_PASSWORD_ADMIN,
                    type: "post",
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (data) {
                        if (data.status) {
                            toastr.success(data.message, data.title)
                            setTimeout(function () {
                                window.location = data.data["urlReload"];
                            }, 2000)
                        } else {
                            toastr.error(data.message, data.title)
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                })
            }
            else {
                toastr.warning("Yêu cầu nhập đủ thông tin","Cảnh báo");
            }
        });
    },
};

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
        }
    });


    AdminSetting.init()
})