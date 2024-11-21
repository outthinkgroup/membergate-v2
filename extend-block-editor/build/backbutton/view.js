/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
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
/************************************************************************/
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./extend-block-editor/src/backbutton/view.js ***!
  \****************************************************/
__webpack_require__.r(__webpack_exports__);
window.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("[data-activate-event='PAGE_LOAD'] .wp-block-membergate-backbutton").forEach(b => b.addEventListener("click", () => {
    window.history.back();
  }));
  document.querySelectorAll("[data-activate-event='CLICK_PROTECT_LINK'] .wp-block-membergate-backbutton").forEach(b => b.addEventListener("click", () => {
    b.closest("#membergate_overlay_root").dataset.state = "in_active";
  }));
});
/******/ })()
;
//# sourceMappingURL=view.js.map