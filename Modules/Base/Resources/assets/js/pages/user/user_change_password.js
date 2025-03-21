const UserChangePassword = {
    init() {
        this.validate();
    },
    validate() {
        $(document).ready(function () {
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
                        equalTo: "#new_password",
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
        });
    },
};

$(function () {
    UserChangePassword.init()
})
