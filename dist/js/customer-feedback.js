/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./source/js/app.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/webpack/buildin/harmony-module.js":
/*!*******************************************!*\
  !*** (webpack)/buildin/harmony-module.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("module.exports = function(originalModule) {\n\tif (!originalModule.webpackPolyfill) {\n\t\tvar module = Object.create(originalModule);\n\t\t// module.parent = undefined by default\n\t\tif (!module.children) module.children = [];\n\t\tObject.defineProperty(module, \"loaded\", {\n\t\t\tenumerable: true,\n\t\t\tget: function() {\n\t\t\t\treturn module.l;\n\t\t\t}\n\t\t});\n\t\tObject.defineProperty(module, \"id\", {\n\t\t\tenumerable: true,\n\t\t\tget: function() {\n\t\t\t\treturn module.i;\n\t\t\t}\n\t\t});\n\t\tObject.defineProperty(module, \"exports\", {\n\t\t\tenumerable: true\n\t\t});\n\t\tmodule.webpackPolyfill = 1;\n\t}\n\treturn module;\n};\n\n\n//# sourceURL=webpack:///(webpack)/buildin/harmony-module.js?");

/***/ }),

/***/ "./node_modules/webpack/buildin/module.js":
/*!***********************************!*\
  !*** (webpack)/buildin/module.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("module.exports = function(module) {\n\tif (!module.webpackPolyfill) {\n\t\tmodule.deprecate = function() {};\n\t\tmodule.paths = [];\n\t\t// module.parent = undefined by default\n\t\tif (!module.children) module.children = [];\n\t\tObject.defineProperty(module, \"loaded\", {\n\t\t\tenumerable: true,\n\t\t\tget: function() {\n\t\t\t\treturn module.l;\n\t\t\t}\n\t\t});\n\t\tObject.defineProperty(module, \"id\", {\n\t\t\tenumerable: true,\n\t\t\tget: function() {\n\t\t\t\treturn module.i;\n\t\t\t}\n\t\t});\n\t\tmodule.webpackPolyfill = 1;\n\t}\n\treturn module;\n};\n\n\n//# sourceURL=webpack:///(webpack)/buildin/module.js?");

/***/ }),

/***/ "./source/js/app.js":
/*!**************************!*\
  !*** ./source/js/app.js ***!
  \**************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _form__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./form */ \"./source/js/form.js\");\n/* harmony import */ var _captcha__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./captcha */ \"./source/js/captcha.js\");\n/* harmony import */ var _captcha__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_captcha__WEBPACK_IMPORTED_MODULE_1__);\nvar __signature__ = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.default.signature : function (a) {\n  return a;\n};\n\n\n\nwindow.addEventListener('DOMContentLoaded', function (event) {\n  Object(_form__WEBPACK_IMPORTED_MODULE_0__[\"default\"])();\n  _captcha__WEBPACK_IMPORTED_MODULE_1___default()();\n});\n\n//# sourceURL=webpack:///./source/js/app.js?");

/***/ }),

/***/ "./source/js/captcha.js":
/*!******************************!*\
  !*** ./source/js/captcha.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("/* WEBPACK VAR INJECTION */(function(module) {(function () {\n  var enterModule = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.enterModule : undefined;\n  enterModule && enterModule(module);\n})();\n\nvar __signature__ = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.default.signature : function (a) {\n  return a;\n};\n\nvar CustomerFeedback = {};\n\nvar CaptchaCallback = function CaptchaCallback() {\n  jQuery('.g-recaptcha').each(function (index, el) {\n    grecaptcha.render(el, {\n      'sitekey': feedback.site_key\n    });\n  });\n};\n\n;\n\n(function () {\n  var reactHotLoader = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.default : undefined;\n\n  if (!reactHotLoader) {\n    return;\n  }\n\n  reactHotLoader.register(CustomerFeedback, \"CustomerFeedback\", \"/Users/seno1000/www/public/developement.local/wp-content/plugins/Customer-feedback/source/js/captcha.js\");\n  reactHotLoader.register(CaptchaCallback, \"CaptchaCallback\", \"/Users/seno1000/www/public/developement.local/wp-content/plugins/Customer-feedback/source/js/captcha.js\");\n})();\n\n;\n\n(function () {\n  var leaveModule = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.leaveModule : undefined;\n  leaveModule && leaveModule(module);\n})();\n/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../node_modules/webpack/buildin/module.js */ \"./node_modules/webpack/buildin/module.js\")(module)))\n\n//# sourceURL=webpack:///./source/js/captcha.js?");

/***/ }),

/***/ "./source/js/form.js":
/*!***************************!*\
  !*** ./source/js/form.js ***!
  \***************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* WEBPACK VAR INJECTION */(function(module) {(function () {\n  var enterModule = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.enterModule : undefined;\n  enterModule && enterModule(module);\n})();\n\nvar __signature__ = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.default.signature : function (a) {\n  return a;\n};\n\nvar _default = function _default() {\n  function Form() {\n    this.handleEvents();\n  }\n\n  Form.prototype.submitComment = function (target, answerId, postId, commentType, comment, email, gCaptcha, topic) {\n    var data = {\n      action: 'submit_comment',\n      postid: postId,\n      comment: comment,\n      answerid: answerId,\n      commenttype: commentType,\n      email: email,\n      captcha: gCaptcha,\n      topicid: topic\n    };\n    var $target = target;\n    $.post(ajaxurl, data, function (response) {\n      if (response == 'true') {\n        $target.find('.customer-feedback-comment').remove();\n        $target.find('.customer-feedback-thanks').show();\n      } else {\n        $target.find('.customer-feedback-comment').remove();\n        $target.find('.customer-feedback-error').show();\n      }\n    });\n  };\n  /**\n   * Submits the initail yes or no response\n   * @param  {integer} postId Post id\n   * @param  {string}  answer Yes or no\n   * @return {void}w\n   */\n\n\n  Form.prototype.submitInitialResponse = function (target, postId, answer) {\n    var $target = target;\n    var data = {\n      action: 'submit_response',\n      postid: postId,\n      answer: answer\n    };\n    $.post(ajaxurl, data, function (response) {\n      if (data.answer == 'yes' && !isNaN(parseFloat(response)) && isFinite(response)) {\n        console.log();\n        document.querySelector('.customer-feedback-topics').style.display = \"none\";\n        document.querySelector('[name=\"customer-feedback-comment-email\"]').parentElement.style.display = \"none\";\n        document.querySelector('.customer-feedback-answers').remove();\n        document.querySelector('.customer-feedback-comment').style.display = \"block\";\n        document.querySelector('.feedback-label-yes').style.display = \"block\";\n        /*$target.querySelector('[name=\"customer-feedback-post-id\"]').after('<input type=\"hidden\" name=\"customer-feedback-answer-id\" value=\"' + response + '\">');\n        */\n      }\n\n      if (data.answer == 'no' && !isNaN(parseFloat(response)) && isFinite(response)) {\n        $target.querySelector('[name=\"customer-feedback-post-id\"]').after('<input type=\"hidden\" name=\"customer-feedback-answer-id\" value=\"' + response + '\">');\n        $target.querySelector('.customer-feedback-answers').remove();\n        $target.querySelector('.customer-feedback-comment').show().querySelector('.feedback-label-no').show();\n      }\n    });\n  };\n\n  Form.prototype.handleEvents = function () {\n    var AnswerButton = document.querySelectorAll('[data-action=customer-feedback-submit-response]');\n    var self = this;\n    AnswerButton.forEach(function (Button) {\n      Button.addEventListener('click', function (e) {\n        //Prevent default action\n        e.preventDefault(); //Set pressed event\n\n        this.setAttribute(\"aria-pressed\", true); //Get submission id\n\n        var FeedBackID = document.getElementById(\"customer-feedback-post-id\").value; //Get submission answer\n\n        var Answer = this.getAttribute('value'); //Submit answer\n\n        self.submitInitialResponse(this, FeedBackID, Answer);\n      });\n    }); // Comment submit click\n\n    $('[data-action=\"customer-feedback-submit-comment\"]').on('click', function (e) {\n      e.preventDefault();\n      $target = $(e.target).parents('.customer-feedback-container');\n      $target.find('[name=\"customer-feedback-comment-text\"]').removeClass('invalid');\n      $target.find('div.danger').remove();\n      var commentType = 'comment';\n      var answerId = $target.find('[name=\"customer-feedback-answer-id\"]').val();\n      var postId = $target.find('[name=\"customer-feedback-post-id\"]').val();\n      var comment = $target.find('[name=\"customer-feedback-comment-text\"]').val();\n      var gCaptcha = $target.find('[name=\"g-recaptcha-response\"]').val();\n      var email = $target.find('[name=\"customer-feedback-comment-email\"]').val();\n      var emailRequired = $target.find('[name=\"customer-feedback-comment-email\"]').prop('required');\n      var topic = $target.find('[name=\"customer-feedback-comment-topic\"]:checked').val();\n      var valid = true;\n\n      if ($('div.customer-feedback-topics').is(\":visible\") && !topic) {\n        $target.find('[name=\"customer-feedback-comment-topic\"]:last').parent().after('<div class=\"clearfix\"></div><div style=\"margin-top: 5px;\" class=\"notice notice-sm danger\">' + feedback.select_topic + '</div>');\n        valid = false;\n      }\n\n      if (comment.length < 15) {\n        $target.find('[name=\"customer-feedback-comment-text\"]').addClass('invalid');\n        $target.find('[name=\"customer-feedback-comment-text\"]').after('<div class=\"clearfix\"></div><div style=\"margin-top: 5px;\" class=\"notice notice-sm danger\">' + feedback.comment_min_characters + '</div>');\n        valid = false;\n      }\n\n      if (email.length === 0 && emailRequired == true) {\n        valid = false;\n      }\n\n      if (!valid) {\n        return false;\n      }\n\n      $(e.target).html('<i class=\"spinner spinner-dark\"></i>');\n      this.submitComment($target, answerId, postId, commentType, comment, email, gCaptcha, topic);\n    }.bind(this));\n    $('[name=\"customer-feedback-comment-topic\"]').change(function (e) {\n      $target = $(e.target).parents('.customer-feedback-container');\n      $target.find('div.customer-feedback-topics div.danger').remove();\n\n      if ($(e.target).attr('topic-description')) {\n        $target.find('.topic-description').show().html('<span class=\"text-sm\">' + $(e.target).attr('topic-description') + '</span>');\n      } else {\n        $target.find('.topic-description').hide();\n      }\n\n      if ($(e.target).attr('feedback-capability')) {\n        $target.find('[name=\"customer-feedback-comment-email\"]').prop('required', true).parent().show();\n      } else {\n        $target.find('[name=\"customer-feedback-comment-email\"]').prop('required', false).parent().hide();\n      }\n    });\n  };\n\n  return new Form();\n};\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (_default);\n;\n\n(function () {\n  var reactHotLoader = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.default : undefined;\n\n  if (!reactHotLoader) {\n    return;\n  }\n\n  reactHotLoader.register(_default, \"default\", \"/Users/seno1000/www/public/developement.local/wp-content/plugins/Customer-feedback/source/js/form.js\");\n})();\n\n;\n\n(function () {\n  var leaveModule = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.leaveModule : undefined;\n  leaveModule && leaveModule(module);\n})();\n/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../node_modules/webpack/buildin/harmony-module.js */ \"./node_modules/webpack/buildin/harmony-module.js\")(module)))\n\n//# sourceURL=webpack:///./source/js/form.js?");

/***/ })

/******/ });