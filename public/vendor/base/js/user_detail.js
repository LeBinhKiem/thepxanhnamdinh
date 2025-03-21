/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************************************!*\
  !*** ./Modules/Base/Resources/assets/js/pages/user/user_detail.js ***!
  \********************************************************************/
var UserDetail = {
  init: function init() {
    this.validate();
    this.handleUpdateUser();
  },
  validate: function validate() {
    $(document).ready(function () {
      $("#modal-update-user form").validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
          "full_name": {
            required: true,
            minlength: 5
          }
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
  handleUpdateUser: function handleUpdateUser() {
    $(document).ready(function () {
      $("#modal-update-user .js-submit").click(function () {
        var form = $('#modal-update-user form');
        if (form.valid()) {
          $('#modal-update-user').modal('hide');
          setTimeout(function () {
            form.submit();
          }, 1000);
        }
      });
    });
  }
};
$(function () {
  UserDetail.init();
});
/******/ })()
;