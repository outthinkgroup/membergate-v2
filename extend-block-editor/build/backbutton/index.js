/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./extend-block-editor/src/backbutton/index.css":
/*!******************************************************!*\
  !*** ./extend-block-editor/src/backbutton/index.css ***!
  \******************************************************/
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

/***/ "./extend-block-editor/src/backbutton/BackButton.js":
/*!**********************************************************!*\
  !*** ./extend-block-editor/src/backbutton/BackButton.js ***!
  \**********************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Edit: () => (/* binding */ Edit),
/* harmony export */   Save: () => (/* binding */ Save)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");





function _Edit({
  attributes,
  setAttributes,
  backgroundColor,
  textColor,
  style
}) {
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    console.log({
      attributes
    });
  }, [attributes]);
  const blockProps = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps)({
    ...style,
    "--button-bg-color": backgroundColor.slug ? `var(--wp--preset--color--${backgroundColor.slug})` : attributes.background,
    "--button-text-color": textColor.slug ? `var(--wp--preset--color--${textColor.slug})` : attributes.color
  });
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    ...blockProps
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.RichText, {
    tagName: "span",
    className: "",
    onChange: content => setAttributes({
      buttonText: content
    }),
    value: attributes.buttonText
  })));
}
const Edit = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.withColors)({
  backgroundColor: "button-bg-color",
  textColor: "button-text-color"
})(_Edit);
function Save({
  attributes
}) {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    ..._wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps.save()
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, attributes.buttonText));
}

/***/ }),

/***/ "./extend-block-editor/src/backbutton/block.json":
/*!*******************************************************!*\
  !*** ./extend-block-editor/src/backbutton/block.json ***!
  \*******************************************************/
/***/ ((module) => {

module.exports = JSON.parse('{"apiVersion":3,"version":"2","name":"membergate/backbutton","title":"Membergate Back Button","description":"Back button form Membergate Overlay","category":"widgets","icon":"admin-comments","keywords":["membergate","back","button"],"editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css","viewScript":"file:./view.js"}');

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
/*!*****************************************************!*\
  !*** ./extend-block-editor/src/backbutton/index.js ***!
  \*****************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _index_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.css */ "./extend-block-editor/src/backbutton/index.css");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _BackButton_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./BackButton.js */ "./extend-block-editor/src/backbutton/BackButton.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./block.json */ "./extend-block-editor/src/backbutton/block.json");





/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_3__.name, {
  attributes: {
    buttonText: {
      type: "string",
      default: "&larr; Back"
    },
    style: {
      default: {
        color: {
          background: "#ffffff",
          text: "#000000"
        }
      }
    }
  },
  supports: {
    color: {
      text: true,
      gradients: true,
      background: true
    }
  },
  category: _block_json__WEBPACK_IMPORTED_MODULE_3__.category,
  title: _block_json__WEBPACK_IMPORTED_MODULE_3__.title,
  edit: _BackButton_js__WEBPACK_IMPORTED_MODULE_2__.Edit,
  save: _BackButton_js__WEBPACK_IMPORTED_MODULE_2__.Save
});
})();

/******/ })()
;
//# sourceMappingURL=index.js.map