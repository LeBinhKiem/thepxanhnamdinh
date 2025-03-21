/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************************************!*\
  !*** ./Modules/Keywords/Resources/assets/js/pages/majors/index.js ***!
  \********************************************************************/
var MAJORS = {
  init: function init() {
    this.checkUniqueMajor();
  },
  checkUniqueMajor: function checkUniqueMajor() {
    $("input[name='name']").keyup(function () {
      var _$$val;
      var name = $(this).val();
      var id = (_$$val = $("input[name='id']").val()) !== null && _$$val !== void 0 ? _$$val : 0;
      $.ajax({
        url: URL_CHECK_UNIQUE_NAME,
        method: "post",
        data: {
          name: name,
          id: id
        },
        success: function success(data) {
          if (data) {
            $(".text-error-unique").text("Trùng tên ngành nghề");
            $(".btn-submit").prop('disabled', true);
          } else {
            $(".text-error-unique").text("");
            $(".btn-submit").prop('disabled', false);
          }
        }
      });
    });
  }
};
$(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
    }
  });
  MAJORS.init();
});
/******/ })()
;