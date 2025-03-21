const UserDetail = {
    init() {
        this.validate();
        this.handleUpdateUser();
    },
    validate() {
        $(document).ready(function () {
            $("#modal-update-user form").validate({
                onfocusout: false,
                onkeyup: false,
                onclick: false,
                rules: {
                    "full_name": {
                        required: true,
                        minlength: 5
                    },
                },
                messages: {
                    "full_name": {
                        required: "Bạn phải nhập tên đẩy đủ",
                        minlength: "Hãy nhập ít nhất 5 ký tự"
                    }
                }
            });
        });
    },
    handleUpdateUser() {
        $(document).ready(function () {
            $("#modal-update-user .js-submit").click(function () {
                let form = $('#modal-update-user form');
                if (form.valid()) {
                    $('#modal-update-user').modal('hide')
                    setTimeout(function () {
                        form.submit();
                    }, 1000)
                }
            })
        })
    },
};

$(function () {
    UserDetail.init()
})
