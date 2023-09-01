/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/modal-editor/src/styles.css":
/*!********************************************!*\
  !*** ./assets/modal-editor/src/styles.css ***!
  \********************************************/
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

/***/ "@wordpress/block-library":
/*!**************************************!*\
  !*** external ["wp","blockLibrary"] ***!
  \**************************************/
/***/ ((module) => {

module.exports = window["wp"]["blockLibrary"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

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

/***/ "@wordpress/format-library":
/*!***************************************!*\
  !*** external ["wp","formatLibrary"] ***!
  \***************************************/
/***/ ((module) => {

module.exports = window["wp"]["formatLibrary"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "@wordpress/keyboard-shortcuts":
/*!*******************************************!*\
  !*** external ["wp","keyboardShortcuts"] ***!
  \*******************************************/
/***/ ((module) => {

module.exports = window["wp"]["keyboardShortcuts"];

/***/ }),

/***/ "@wordpress/media-utils":
/*!************************************!*\
  !*** external ["wp","mediaUtils"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["mediaUtils"];

/***/ }),

/***/ "./assets/modal-editor/src/OverlayEditor.js":
/*!**************************************************!*\
  !*** ./assets/modal-editor/src/OverlayEditor.js ***!
  \**************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_keyboard_shortcuts__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/keyboard-shortcuts */ "@wordpress/keyboard-shortcuts");
/* harmony import */ var _components_notices_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/notices.js */ "./assets/modal-editor/src/components/notices.js");
/* harmony import */ var _components_header_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/header.js */ "./assets/modal-editor/src/components/header.js");
/* harmony import */ var _components_Sidebar_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./components/Sidebar.js */ "./assets/modal-editor/src/components/Sidebar.js");
/* harmony import */ var _components_block_editor_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./components/block-editor.js */ "./assets/modal-editor/src/components/block-editor.js");
/* harmony import */ var _components_footer_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./components/footer.js */ "./assets/modal-editor/src/components/footer.js");

/**
 * WordPress dependencies
 */


// import { FullscreenMode, InterfaceSkeleton } from '@wordpress/interface';


/**
 * Internal dependencies
 */





function OverlayEditor({
  settings,
  closeModal
}) {
  const [overlaySettings, _setOverlaySettings] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)({});
  async function setOverlaySettings(settings) {
    _setOverlaySettings(settings);
    window.initialOverlaySettings = settings;
  }
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    _setOverlaySettings(window.initialOverlaySettings);
  }, []);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.StrictMode, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_keyboard_shortcuts__WEBPACK_IMPORTED_MODULE_2__.ShortcutProvider, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.SlotFillProvider, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "overlay-editor-layout p-5"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_header_js__WEBPACK_IMPORTED_MODULE_4__["default"], {
    closeAction: closeModal
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_Sidebar_js__WEBPACK_IMPORTED_MODULE_5__["default"], {
    modalSettings: overlaySettings,
    setModalSettings: setOverlaySettings
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_notices_js__WEBPACK_IMPORTED_MODULE_3__["default"], null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_block_editor_js__WEBPACK_IMPORTED_MODULE_6__["default"], {
    settings: settings
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_footer_js__WEBPACK_IMPORTED_MODULE_7__["default"], null)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Popover.Slot, null)))));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (OverlayEditor);

/***/ }),

/***/ "./assets/modal-editor/src/components/OverlaySettingsPanel.js":
/*!********************************************************************!*\
  !*** ./assets/modal-editor/src/components/OverlaySettingsPanel.js ***!
  \********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");


function size(value, unit) {
  return {
    value,
    unit
  };
}
function sizeToCss(size) {
  return `${size.value}${size.unit}`;
}
function OverlaySettingsPanel({}) {
  const [bgColor, setBgColor] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)("");
  const [textColor, setTextColor] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)("");
  const [maxWidth, setMaxWidth] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(size(900, "px"));
  const [padding, setPadding] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)({
    top: size(0, "px"),
    right: size(0, "px"),
    bottom: size(0, "px"),
    left: size(0, "px")
  });
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    const initialOverlaySettings = window.membergate.OverlayEditor.overlaySettings;
    setBgColor(initialOverlaySettings.bgColor);
    setTextColor(initialOverlaySettings.textColor);
    setMaxWidth(initialOverlaySettings.maxWidth);
    setPadding(initialOverlaySettings.padding);
  }, []);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    window.membergate.OverlayEditor.overlaySettings.bgColor = bgColor;
    document.querySelector("#overlay-editor-root").style.setProperty("--bgColor", bgColor);
  }, [bgColor]);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    window.membergate.OverlayEditor.overlaySettings.textColor = textColor;
    document.querySelector("#overlay-editor-root").style.setProperty("--textColor", textColor);
  }, [textColor]);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    window.membergate.OverlayEditor.overlaySettings.maxWidth = maxWidth;
    document.querySelector("#overlay-editor-root").style.setProperty("--maxWidth", sizeToCss(maxWidth));
  }, [maxWidth]);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    window.membergate.OverlayEditor.overlaySettings.padding = padding;
    document.querySelector("#overlay-editor-root").style.setProperty("--overlayPadding", `${sizeToCss(padding.top)} ${sizeToCss(padding.right)} ${sizeToCss(padding.bottom)} ${sizeToCss(padding.left)}`);
  }, [padding]);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "components-panel__body"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h3", null, "Overlay Settings"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, "Background Color"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    type: "color",
    value: bgColor,
    onChange: e => setBgColor(e.target.value)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, "Text Color"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    type: "color",
    value: textColor,
    onChange: e => setTextColor(e.target.value)
  })));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (OverlaySettingsPanel);

/***/ }),

/***/ "./assets/modal-editor/src/components/Sidebar.js":
/*!*******************************************************!*\
  !*** ./assets/modal-editor/src/components/Sidebar.js ***!
  \*******************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _OverlaySettingsPanel_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./OverlaySettingsPanel.js */ "./assets/modal-editor/src/components/OverlaySettingsPanel.js");





// import ModalSettings from "./ModalSettings"

/**
 * @type OverlaySettingsT = {
 * bgColor:string;
 * textColor:string;
 * maxWidth:Size;
 * padding:{
 * 		top:Size;
 * 		right:Size;
 * 		bottom:Size;
 * 		left:Size;
 * 	};
 * 	borderRadius:number;
 * 	}
 **/
const {
  Slot: InspectorSlot,
  Fill: InspectorFill
} = (0,_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.createSlotFill)("MembergateOverlaySidbarInspector");
function Sidebar({
  modalSettings,
  setModalSettings
}) {
  const [activeTab, setActiveTab] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)("Document");
  function setDocumentTab() {
    setActiveTab("Document");
  }
  function setInspectorTab() {
    setActiveTab("Inspector");
  }
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "overlay-editor-sidebar sticky top-12",
    role: "region",
    "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)(" Overlay Editor advanced settings."),
    tabIndex: "-1"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "h-12 flex"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    className: `${activeTab == "Document" ? "border-b-cyan-600" : "border-b-transparent"} flex-1 border-b-2 hover:border-b-cyan-600 hover:bg-slate-50`,
    onClick: setDocumentTab
  }, "Document"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    className: `${activeTab == "Inspector" ? "border-b-cyan-600" : "border-b-transparent"} flex-1 border-b-2 hover:border-b-cyan-600 hover:bg-slate-50`,
    onClick: setInspectorTab
  }, "Inspector")), activeTab == "Inspector" ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Panel, {
    header: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("⭐ Inspector")
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InspectorSlot, {
    bubblesVirtually: true
  })) : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Panel, {
    header: "Document",
    className: "border-0"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_OverlaySettingsPanel_js__WEBPACK_IMPORTED_MODULE_3__["default"], null)));
}
Sidebar.InspectorFill = InspectorFill;
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Sidebar);

/***/ }),

/***/ "./assets/modal-editor/src/components/block-editor.js":
/*!************************************************************!*\
  !*** ./assets/modal-editor/src/components/block-editor.js ***!
  \************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/editor */ "@wordpress/editor");
/* harmony import */ var _wordpress_format_library__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/format-library */ "@wordpress/format-library");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_media_utils__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/media-utils */ "@wordpress/media-utils");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _Sidebar_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./Sidebar.js */ "./assets/modal-editor/src/components/Sidebar.js");
/* harmony import */ var _footer_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./footer.js */ "./assets/modal-editor/src/components/footer.js");

 // This shouldn't be necessary







/**
 * Internal dependencies
 */

//import { saveModal } from "../saveModal";

function BlockEditor({
  settings: _settings
}) {
  const [blocks, updateBlocks] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);
  const {
    createInfoNotice
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useDispatch)("core/notices");
  const canUserCreateMedia = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useSelect)(select => {
    const _canUserCreateMedia = select("core").canUser("create", "media");
    return _canUserCreateMedia || _canUserCreateMedia !== false;
  }, []);
  const settings = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => {
    if (!canUserCreateMedia) {
      return _settings;
    }
    return {
      ..._settings,
      mediaUpload({
        onError,
        ...rest
      }) {
        (0,_wordpress_media_utils__WEBPACK_IMPORTED_MODULE_5__.uploadMedia)({
          wpAllowedMimeTypes: _settings.allowedMimeTypes,
          onError: ({
            message
          }) => onError(message),
          ...rest
        });
      }
    };
  }, [canUserCreateMedia, _settings]);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    const storedBlocks = window.membergate.OverlayEditor.blocks;
    console.log(storedBlocks);
    if (storedBlocks?.length) {
      handleUpdateBlocks(() => (0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_4__.parse)(storedBlocks));
      createInfoNotice("Blocks loaded", {
        type: "snackbar",
        isDismissible: true
      });
    }
  }, []);

  /**
   * Wrapper for updating blocks. Required as `onInput` callback passed to
   * `BlockEditorProvider` is now called with more than 1 argument. Therefore
   * attempting to setState directly via `updateBlocks` will trigger an error
   * in React.
   *
   * @param  blocks
   * @param  _blocks
   */
  function handleUpdateBlocks(_blocks) {
    updateBlocks(_blocks);
    if (typeof _blocks == "function") {
      window.membergate.OverlayEditor.blockObjects = _blocks();
    } else {
      window.membergate.OverlayEditor.blockObjects = _blocks;
    }
  }
  async function handlePersistBlocks(newBlocks) {
    updateBlocks(newBlocks);
    window.membergate.OverlayEditor.blockObjects = newBlocks;
  }
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "overlay-editor-blocks z-50 border-r",
    style: {
      background: "var(--bgColor, white)",
      color: "var(--textColor,black)",
      padding: "var(--overlayPadding)"
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__.BlockEditorProvider, {
    value: blocks,
    onInput: handleUpdateBlocks,
    onChange: handlePersistBlocks,
    settings: settings
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_Sidebar_js__WEBPACK_IMPORTED_MODULE_7__["default"].InspectorFill, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__.BlockInspector, {
    showNoBlockSelectedMessage: false
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "editor-styles-wrapper  bg-inherit"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__.BlockEditorKeyboardShortcuts.Register, null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__.BlockTools, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__.WritingFlow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__.ObserveTyping, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__.BlockList, {
    className: "overlay-block-list overflow-x-auto px-1 text-inherit mx-auto max-w-[var(--maxWidth)]"
  }))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_footer_js__WEBPACK_IMPORTED_MODULE_8__["default"].InspectorFill, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__.BlockBreadcrumb, null))));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (BlockEditor);

/***/ }),

/***/ "./assets/modal-editor/src/components/footer.js":
/*!******************************************************!*\
  !*** ./assets/modal-editor/src/components/footer.js ***!
  \******************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");




const {
  Slot: InspectorSlot,
  Fill: InspectorFill
} = (0,_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.createSlotFill)("WPModalFooter");
function Footer() {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "overlay-editor-footer border-t"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InspectorSlot, {
    bubblesVirtually: true
  }));
}
Footer.InspectorFill = InspectorFill;
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Footer);

/***/ }),

/***/ "./assets/modal-editor/src/components/header.js":
/*!******************************************************!*\
  !*** ./assets/modal-editor/src/components/header.js ***!
  \******************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Header)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");


function Header({
  closeAction
}) {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "overlay-editor-header sticky top-[-1px] bg-white z-50 flex justify-between items-center border-b ",
    role: "region",
    "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Overlay Editor top bar.', 'membergate'),
    tabIndex: "-1"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h1", {
    className: "text-lg"
  }, "Overlay Editor"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    className: "h-full aspect-square leading-none text-2xl bg-transparent border-0 hover:bg-slate-100 w-12",
    onClick: closeAction
  }, "\xD7"));
}

/***/ }),

/***/ "./assets/modal-editor/src/components/notices.js":
/*!*******************************************************!*\
  !*** ./assets/modal-editor/src/components/notices.js ***!
  \*******************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Notices)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");



function Notices() {
  const notices = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useSelect)(select => select('core/notices').getNotices().filter(notice => notice.type === 'snackbar'), []);
  const {
    removeNotice
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useDispatch)('core/notices');
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.SnackbarList, {
    className: "fixed bottom-20 left-5",
    notices: notices,
    onRemove: removeNotice
  });
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
/*!******************************************!*\
  !*** ./assets/modal-editor/src/index.js ***!
  \******************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_block_library__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-library */ "@wordpress/block-library");
/* harmony import */ var _OverlayEditor_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./OverlayEditor.js */ "./assets/modal-editor/src/OverlayEditor.js");
/* harmony import */ var _styles_css__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./styles.css */ "./assets/modal-editor/src/styles.css");





(0,_wordpress_block_library__WEBPACK_IMPORTED_MODULE_1__.registerCoreBlocks)();
// Build Dialog Mechanism
window.addEventListener("DOMContentLoaded", createDialogAndReactRoot);
function createDialogAndReactRoot() {
  const rootWrapper = document.querySelector(".overlay-editor-wrapper");
  document.body.addEventListener("click", function (e) {
    if (!e.target.matches("#show-overlay-editor")) return;
    rootWrapper.dataset.active = "true";
    mountEditor(() => {
      const root = rootWrapper.querySelector("#overlay-editor-root");
      root.classList.add("hiding");
      setTimeout(() => {
        rootWrapper.dataset.active = "false";
        root.classList.remove("hiding");
      }, 400);
    });
  });
}
function mountEditor(closeFn) {
  const settings = window.membergate.OverlayEditor.editorSettings;
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.render)((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_OverlayEditor_js__WEBPACK_IMPORTED_MODULE_2__["default"], {
    settings: settings,
    closeModal: closeFn
  }), document.querySelector("#overlay-editor-root"));
  console.log("hi");
}
})();

/******/ })()
;
//# sourceMappingURL=index.js.map