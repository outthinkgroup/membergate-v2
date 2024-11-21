/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./extend-block-editor/src/protectedlink/index.css":
/*!*********************************************************!*\
  !*** ./extend-block-editor/src/protectedlink/index.css ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "./extend-block-editor/src/protectedlink/ProtectedLink.js":
/*!****************************************************************!*\
  !*** ./extend-block-editor/src/protectedlink/ProtectedLink.js ***!
  \****************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Edit: () => (/* binding */ Edit),
/* harmony export */   Save: () => (/* binding */ Save)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");


const BUTTONS_TEMPLATE = [["core/buttons", {}, [["core/button", {
  text: "Download"
}]]]];
function Edit() {
  const blockProps = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps)();
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    ...blockProps
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.InnerBlocks, {
    template: BUTTONS_TEMPLATE,
    templateLock: "all"
  }));
}
function Save() {
  const blockProps = _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps.save();
  const {
    children,
    ...innerBlocksProps
  } = _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useInnerBlocksProps.save(blockProps);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    ...innerBlocksProps
  }, children);
}

/***/ }),

/***/ "./extend-block-editor/src/protectedlink/block.json":
/*!**********************************************************!*\
  !*** ./extend-block-editor/src/protectedlink/block.json ***!
  \**********************************************************/
/***/ ((module) => {

module.exports = JSON.parse('{"apiVersion":3,"name":"membergate/protectedlink","title":"Protected Linked Content","description":"Protect Download or other links but allow the user to still view the landing page.","category":"widgets","icon":"admin-comments","keywords":["membergate","link","protect"],"editorScript":"file:./index.js","render":"file:./render.php","editorStyle":"file:./index.css","style":"file:./style-index.css","viewScript":"file:./view.js"}');

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
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
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
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!********************************************************!*\
  !*** ./extend-block-editor/src/protectedlink/index.js ***!
  \********************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _index_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.css */ "./extend-block-editor/src/protectedlink/index.css");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _ProtectedLink_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ProtectedLink.js */ "./extend-block-editor/src/protectedlink/ProtectedLink.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./block.json */ "./extend-block-editor/src/protectedlink/block.json");





/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_3__.name, {
  category: _block_json__WEBPACK_IMPORTED_MODULE_3__.category,
  title: _block_json__WEBPACK_IMPORTED_MODULE_3__.title,
  edit: _ProtectedLink_js__WEBPACK_IMPORTED_MODULE_2__.Edit,
  save: _ProtectedLink_js__WEBPACK_IMPORTED_MODULE_2__.Save
});
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__.registerBlockVariation)("core/buttons", {
  name: "membergate/protectedbutton",
  title: "Membergate Protected Link",
  attributes: {
    className: "is-membergate-protect-link"
  },
  innerBlocks: [["core/button", {
    text: "Download"
  }]],
  isActive: (blockAttributes, variationAttributes) => blockAttributes.className === variationAttributes.className
});
})();

/******/ })()
;
//# sourceMappingURL=index.js.map