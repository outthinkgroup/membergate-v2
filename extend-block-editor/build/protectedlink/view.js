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
/*!*******************************************************!*\
  !*** ./extend-block-editor/src/protectedlink/view.js ***!
  \*******************************************************/
__webpack_require__.r(__webpack_exports__);
//create an object for us to add stuff to
window.publicMembergate.protectedLink = {};
createSignals();
window.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".wp-block-membergate-protectedlink [data-action='open-overlay']").forEach(b => b.addEventListener("click", e => {
    e.preventDefault();
    // for extensions
    const link = e.target.getAttribute("href");
    window.publicMembergate.protectedLink.updateIntendedLink(link);
    document.querySelector("#membergate_overlay_root").dataset.state = "active";
  }));
});
function createSignals() {
  let listeners = [];
  window.publicMembergate.protectedLink.subscribe = function (cb) {
    listeners.push(cb);
  };
  window.publicMembergate.protectedLink.updateIntendedLink = function (link) {
    for (let listener of listeners) {
      listener(link);
    }
  };
}
/******/ })()
;
//# sourceMappingURL=view.js.map