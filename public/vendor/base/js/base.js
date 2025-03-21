/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./Modules/Base/Resources/assets/js/base.js":
/*!**************************************************!*\
  !*** ./Modules/Base/Resources/assets/js/base.js ***!
  \**************************************************/
/***/ (() => {

var UpLoad = {
  init: function init() {
    var url = $(".js-show-file").data("link");
    if (url !== "" && url !== undefined) {
      var getFileNameFromPath = function getFileNameFromPath(path) {
        var pathArray = path.split('/');
        var fileName = pathArray[pathArray.length - 1];
        return fileName;
      }; // fetch(url)
      //     .then(response => {
      //         if (!response.ok) {
      //             throw new Error(`Network response was not ok: ${response.status}`);
      //         }
      //         return response;
      //     })
      //     .then(response => response.blob())
      //     .then(blob => {
      //         const fileType = blob.type;
      //         const fileSize = blob.size;
      //         $(".js-show-file").find(".size").text(fileSize)
      //         $(".js-show-file").find(".type").text(fileType)
      //     })
      //     .catch(error => {
      //         console.error('Error fetching file details:', error.message);
      //     });
      $(".js-form-upload").addClass("active");
      $(".js-show-file").find(".name").html(getFileNameFromPath(url));
      $(".js-show-option").addClass("hide");
    }
    $(".js-choose-file input").change(function (e) {
      console.log();
      var file = e.target.files[0];
      var form = $(this).closest(".js-form-upload");
      form.addClass("active");
      form.find(".name").text(limitCharacters(file.name, 30));
      form.find(".size").text(file.size);
      form.find(".type").text(file.type);
      function limitCharacters(text, limit) {
        if (text.length > limit) {
          return text.substring(0, limit) + '...';
        } else {
          return text;
        }
      }
    });
    $(".js-remove-file").click(function (e) {
      e.stopPropagation();
      var confirmDelete = confirm('Bạn chắc chắn muốn xóa?');
      if (!confirmDelete) return;
      $(".js-form-upload").removeClass("active");
      $(".js-choose-file input").val("");
      $(".js-show-option").removeClass("hide");
    });
    $(".js-show-file").click(function (e) {
      var url = $(this).data("link");
      if (url === "" || url === undefined) {
        return;
      }
      window.open(url, '_blank');
    });
  }
};
$(function () {
  UpLoad.init();
});

/***/ }),

/***/ "./Modules/Base/Resources/assets/sass/base.scss":
/*!******************************************************!*\
  !*** ./Modules/Base/Resources/assets/sass/base.scss ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./Modules/Base/Resources/assets/sass/vote.scss":
/*!******************************************************!*\
  !*** ./Modules/Base/Resources/assets/sass/vote.scss ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/base": 0,
/******/ 			"css/base": 0,
/******/ 			"css/vote": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/base","css/vote"], () => (__webpack_require__("./Modules/Base/Resources/assets/js/base.js")))
/******/ 	__webpack_require__.O(undefined, ["css/base","css/vote"], () => (__webpack_require__("./Modules/Base/Resources/assets/sass/base.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/base","css/vote"], () => (__webpack_require__("./Modules/Base/Resources/assets/sass/vote.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;