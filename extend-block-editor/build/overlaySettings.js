/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./extend-block-editor/src/overlaySettings/editor.css":
/*!************************************************************!*\
  !*** ./extend-block-editor/src/overlaySettings/editor.css ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/compose":
/*!*********************************!*\
  !*** external ["wp","compose"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["compose"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/editor":
/*!********************************!*\
  !*** external ["wp","editor"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["editor"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/plugins":
/*!*********************************!*\
  !*** external ["wp","plugins"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["plugins"];

/***/ }),

/***/ "./extend-block-editor/src/components/ColorPicker.js":
/*!***********************************************************!*\
  !*** ./extend-block-editor/src/components/ColorPicker.js ***!
  \***********************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ MyColorPicker)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");



function MyColorPicker({
  color,
  updateColor,
  label
}) {
  const [anchorEl, setAnchorEl] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
  const [isShowingPicker, setIsShowingPicker] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    ref: setAnchorEl,
    onClick: () => setIsShowingPicker(s => !s),
    style: {
      minHeight: 40,
      textAlign: "left",
      display: "flex",
      alignItems: "center",
      appearance: "none",
      background: "transparent",
      border: "1px solid #ccc",
      gap: ".5rem",
      padding: ".25rem",
      borderRadius: ".25rem",
      width: "100%",
      color: "#363F53"
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    style: {
      width: "max-content",
      aspectRatio: 1
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ColorIndicator, {
    colorValue: color
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, label)), isShowingPicker && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Popover, {
    anchor: anchorEl,
    onFocusOutside: () => setIsShowingPicker(false),
    placement: "left-start",
    offset: 10,
    resize: true,
    shift: true,
    onClose: () => setIsShowingPicker(false),
    noArrow: false,
    headerTitle: `Setting ${label}'s Color`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    style: {
      padding: ".25rem"
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ColorPicker, {
    color: color,
    onChange: newColor => {
      updateColor(newColor);
    }
  }))));
}

/***/ }),

/***/ "./extend-block-editor/src/overlaySettings/OverlaySettings.js":
/*!********************************************************************!*\
  !*** ./extend-block-editor/src/overlaySettings/OverlaySettings.js ***!
  \********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/compose */ "@wordpress/compose");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/editor */ "@wordpress/editor");
/* harmony import */ var _components_ColorPicker_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../components/ColorPicker.js */ "./extend-block-editor/src/components/ColorPicker.js");
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./utils.js */ "./extend-block-editor/src/overlaySettings/utils.js");








function OverlaySettings({
  meta,
  setMeta
}) {
  const {
    membergate_overlay_settings: settings
  } = meta;
  const setSettings = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useCallback)((key, value) => {
    setMeta({
      ...settings,
      [key]: value
    }, "membergate_overlay_settings");
  }, [settings]);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    (0,_utils_js__WEBPACK_IMPORTED_MODULE_6__.updateCSSVars)(settings);
  }, [settings]);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_editor__WEBPACK_IMPORTED_MODULE_4__.PluginDocumentSettingPanel, {
    className: "membergate-overlay-settings",
    title: "Overlay Settings",
    name: "overlay-settings",
    isOpen: true
  }, settings && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, Object.entries(settings).map(([key, value]) => {
    if (key === "padding") return null;
    if (key.includes("Color")) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_ColorPicker_js__WEBPACK_IMPORTED_MODULE_5__["default"], {
        color: value,
        updateColor: newColor => setSettings(key, newColor),
        label: key
      });
    }
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalNumberControl, {
      value: value.split("px")[0],
      onChange: newValue => setSettings(key, newValue.toString() + "px"),
      label: key
    }));
  })));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ((0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_2__.compose)((0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.withSelect)(select => {
  const postMeta = select("core/editor").getEditedPostAttribute("meta");
  const oldPostMeta = select("core/editor").getCurrentPostAttribute("meta");
  return {
    meta: {
      ...oldPostMeta,
      ...postMeta
    }
  };
}), (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.withDispatch)(dispatch => ({
  setMeta: (value, field) => dispatch("core/editor").editPost({
    meta: {
      [field]: value
    }
  })
})))(OverlaySettings));

/***/ }),

/***/ "./extend-block-editor/src/overlaySettings/utils.js":
/*!**********************************************************!*\
  !*** ./extend-block-editor/src/overlaySettings/utils.js ***!
  \**********************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   updateCSSVars: () => (/* binding */ updateCSSVars)
/* harmony export */ });
function updateCSSVars(settings) {
  const blocks = document.querySelector(".block-editor-block-list__layout");
  if (!blocks) return;
  blocks.style.setProperty(`--membergate-overlay-maxWidth`, settings.maxWidth);
  blocks.style.setProperty(`--membergate-overlay-position`, settings.position);
}

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
/*!**********************************************************!*\
  !*** ./extend-block-editor/src/overlaySettings/index.js ***!
  \**********************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/plugins */ "@wordpress/plugins");
/* harmony import */ var _OverlaySettings_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./OverlaySettings.js */ "./extend-block-editor/src/overlaySettings/OverlaySettings.js");
/* harmony import */ var _editor_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./editor.css */ "./extend-block-editor/src/overlaySettings/editor.css");



(0,_wordpress_plugins__WEBPACK_IMPORTED_MODULE_0__.registerPlugin)("membergate-overlay-settings", {
  render: _OverlaySettings_js__WEBPACK_IMPORTED_MODULE_1__["default"]
});
})();

/******/ })()
;
//# sourceMappingURL=overlaySettings.js.map