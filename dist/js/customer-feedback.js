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

/***/ "./source/js/app.js":
/*!**************************!*\
  !*** ./source/js/app.js ***!
  \**************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _form__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./form */ \"./source/js/form.js\");\nvar __signature__ = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.default.signature : function (a) {\n  return a;\n};\n\n\nwindow.addEventListener('DOMContentLoaded', function (event) {\n  Object(_form__WEBPACK_IMPORTED_MODULE_0__[\"default\"])();\n});\n\n//# sourceURL=webpack:///./source/js/app.js?");

/***/ }),

/***/ "./source/js/form.js":
/*!***************************!*\
  !*** ./source/js/form.js ***!
  \***************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* WEBPACK VAR INJECTION */(function(module) {var _this = undefined;\n\n(function () {\n  var enterModule = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.enterModule : undefined;\n  enterModule && enterModule(module);\n})();\n\nfunction _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === \"undefined\" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === \"number\") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError(\"Invalid attempt to iterate non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\"); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it.return != null) it.return(); } finally { if (didErr) throw err; } } }; }\n\nfunction _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === \"string\") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === \"Object\" && o.constructor) n = o.constructor.name; if (n === \"Map\" || n === \"Set\") return Array.from(o); if (n === \"Arguments\" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }\n\nfunction _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }\n\nvar __signature__ = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.default.signature : function (a) {\n  return a;\n};\n\nvar _default = function _default() {\n  var feedbackResponse = false;\n\n  function Form() {\n    this.handleEvents();\n  }\n\n  Form.prototype.submitComment = function (target, answerId, postId, commentType, comment, email, gCaptcha, topic) {\n    var data = {\n      action: 'submit_comment',\n      postid: postId,\n      comment: comment,\n      answerid: answerId,\n      commenttype: commentType,\n      email: email,\n      captcha: gCaptcha,\n      topicid: topic\n    };\n    var $target = target;\n    fetch(ajaxurl, {\n      method: 'POST',\n      credentials: 'same-origin',\n      headers: {\n        'Content-Type': 'application/x-www-form-urlencoded',\n        'Cache-Control': 'no-cache'\n      },\n      body: new URLSearchParams(data)\n    }).then(function (response) {\n      if (response.status != 200) {\n        document.querySelector('.customer-feedback-js-error').style.display = \"block\";\n        return false;\n      }\n\n      return response.json();\n    }).then(function (response) {\n      //Disable loader\n      $target.querySelector(\"#feedback-loader\").style.display = 'none'; //Handle response\n\n      if (response == true) {\n        $target.querySelector('.customer-feedback-comment').style.display = 'none';\n        $target.querySelector('.customer-feedback-thanks').style.display = 'block';\n      } else {\n        $target.querySelector('.customer-feedback-comment').style.display = 'none';\n        $target.querySelector('.customer-feedback-error').style.display = 'block';\n      }\n    }).catch(function (err) {\n      document.querySelector('.customer-feedback-js-error').style.display = \"block\";\n      return false;\n    });\n  };\n  /**\n   * Submits the initail yes or no response\n   * @param  {integer} postId Post id\n   * @param  {string}  answer Yes or no\n   * @return {void}w\n   */\n\n\n  Form.prototype.submitInitialResponse = function (target, postId, answer) {\n    var data = {\n      action: 'submit_response',\n      postid: postId,\n      answer: answer\n    };\n    document.querySelector(\"#feedback-loader\").style.display = 'block';\n    fetch(ajaxurl, {\n      method: 'POST',\n      credentials: 'same-origin',\n      headers: {\n        'Content-Type': 'application/x-www-form-urlencoded',\n        'Cache-Control': 'no-cache'\n      },\n      body: new URLSearchParams(data)\n    }).then(function (response) {\n      if (response.status != 200) {\n        document.querySelector('.customer-feedback-js-error').style.display = \"block\";\n        return false;\n      }\n\n      return response.json();\n    }).then(function (response) {\n      if (response === false) {\n        return false;\n      }\n\n      if (!isNaN(parseFloat(response)) && isFinite(response)) {\n        //Create id holder\n        var feedBackIdElement = document.createElement(\"input\");\n        feedBackIdElement.type = \"hidden\";\n        feedBackIdElement.name = \"customer-feedback-answer-id\";\n        feedBackIdElement.value = response;\n        document.querySelector('[name=\"customer-feedback-post-id\"]').parentElement.appendChild(feedBackIdElement); //Hide current controls \n\n        document.querySelector('.customer-feedback-comment-email').parentElement.style.display = \"none\";\n        document.querySelector('.customer-feedback-answers').style.display = \"none\"; //Show comment section\n\n        document.querySelector('.customer-feedback-comment').style.display = \"block\";\n      }\n\n      if (data.answer === 'yes' && !isNaN(parseFloat(response)) && isFinite(response)) {\n        document.querySelector('.feedback-answer-yes').style.display = \"block\";\n        feedbackResponse = true;\n      }\n\n      if (data.answer === 'no' && !isNaN(parseFloat(response)) && isFinite(response)) {\n        var _iterator = _createForOfIteratorHelper(document.querySelectorAll('.feedback-answer-no')),\n            _step;\n\n        try {\n          for (_iterator.s(); !(_step = _iterator.n()).done;) {\n            var negativeAnswer = _step.value;\n            negativeAnswer.style.display = \"block\";\n            feedbackResponse = false;\n          }\n        } catch (err) {\n          _iterator.e(err);\n        } finally {\n          _iterator.f();\n        }\n      } //Loading done\n\n\n      document.getElementById(\"feedback-loader\").style.display = 'none';\n    }).catch(function (err) {\n      document.querySelector('.customer-feedback-js-error').style.display = \"block\";\n      return false;\n    });\n  };\n\n  Form.prototype.removeJsErrorMessages = function () {\n    //Target div \n    var $target = document.getElementById('customer-feedback'); //Reset state (remove messages)\n\n    var errorMessages = $target.querySelectorAll('.feedback-form-dynamic-error');\n    errorMessages.forEach(function (errorMessage) {\n      errorMessage.remove();\n    });\n  };\n\n  Form.prototype.handleEvents = function () {\n    var answerButton = document.querySelectorAll('[data-action=customer-feedback-submit-response]');\n    var self = this;\n    answerButton.forEach(function (answerButton) {\n      answerButton.addEventListener('click', function (e) {\n        //Prevent default action\n        e.preventDefault();\n        e.stopPropagation(); //Set pressed event\n\n        this.setAttribute(\"aria-pressed\", true); //Get submission id\n\n        var FeedBackID = document.getElementById(\"customer-feedback-post-id\").value; //Get submission answer\n\n        var Answer = this.getAttribute('value'); //Submit answer\n\n        self.submitInitialResponse(this, FeedBackID, Answer);\n      });\n    }); // Comment submit click\n\n    var submitButton = document.querySelectorAll('[data-action=customer-feedback-submit-comment]');\n    submitButton.forEach(function (Submit) {\n      Submit.addEventListener('click', function (e) {\n        e.preventDefault(); //Target div \n\n        var $target = document.getElementById('customer-feedback'); //Reset state (make fields valid attr)\n\n        $target.querySelector('[name=\"customer-feedback-comment-text\"]').setAttribute('aria-invalid', false);\n        $target.querySelector('[name=\"customer-feedback-comment-topic\"]').setAttribute('aria-invalid', false);\n        $target.querySelector('[name=\"customer-feedback-comment-email\"]').setAttribute('aria-invalid', false); //Remove all js error messages\n\n        self.removeJsErrorMessages(); //Get vars \n\n        var commentType = 'comment';\n        var topic = null;\n        var gCaptcha = null;\n        var answerId = $target.querySelector('[name=\"customer-feedback-answer-id\"]').value;\n        var postId = $target.querySelector('[name=\"customer-feedback-post-id\"]').value;\n        var comment = $target.querySelector('[name=\"customer-feedback-comment-text\"]').value;\n        var email = $target.querySelector('[name=\"customer-feedback-comment-email\"]').value;\n        var emailRequired = $target.querySelector('[name=\"customer-feedback-comment-email\"]').getAttribute('required');\n        var valid = true; //Topic\n\n        if (!feedbackResponse) {\n          if ($target.querySelectorAll('[name=\"customer-feedback-comment-topic\"]:checked').length == 1) {\n            topic = $target.querySelector('[name=\"customer-feedback-comment-topic\"]:checked').value;\n          } else {\n            //Create error node\n            var topicErrorMessage = document.createElement('div');\n            topicErrorMessage.id = 'topic-error';\n            topicErrorMessage.classList = 'c-option__input-invalid-message feedback-form-dynamic-error';\n            topicErrorMessage.style.display = 'block';\n            topicErrorMessage.appendChild(document.createTextNode(feedback.select_topic));\n            $target.querySelector('[name=\"customer-feedback-comment-text\"]').setAttribute('aria-invalid', true); //Show invalid notice\n\n            $target.querySelector('.customer-feedback-topics').after(topicErrorMessage); //Prohibit submission\n\n            valid = false;\n          }\n        } //Get captcha if not logged in\n\n\n        if (feedback.site_key) {\n          if ($target.querySelector('[name=\"g-recaptcha-response\"]') && $target.querySelector('[name=\"g-recaptcha-response\"]').value !== '') {\n            gCaptcha = $target.querySelector('[name=\"g-recaptcha-response\"]').value;\n          }\n        } //Check length\n\n\n        if (comment.length < 15) {\n          //Create error node\n          var errorMessage = document.createElement('div');\n          errorMessage.id = 'length-error';\n          errorMessage.classList = 'c-textarea-invalid-message feedback-form-dynamic-error';\n          errorMessage.style.display = 'block'; // Remove label\n\n          if ($target.querySelector('.c-textarea label')) {\n            $target.querySelector('.c-textarea label').remove();\n          }\n\n          errorMessage.appendChild(document.createTextNode(feedback.comment_min_characters)); //Show invalid notice\n\n          $target.querySelector('[name=\"customer-feedback-comment-text\"]').setAttribute('aria-invalid', true);\n          $target.querySelector('[name=\"customer-feedback-comment-text\"]').after(errorMessage); //Prohibit submission\n\n          valid = false;\n        } //Check email if exists \n\n\n        if (email.length === 0 && emailRequired == \"true\") {\n          //Create error node\n          var _errorMessage = document.createElement('div');\n\n          _errorMessage.id = 'email-error';\n          _errorMessage.classList = 'c-field__input-invalid-message feedback-form-dynamic-error';\n          _errorMessage.style.display = 'block';\n          _errorMessage.style.marginTop = '0px';\n\n          _errorMessage.appendChild(document.createTextNode(feedback.enter_email)); //Show invalid notice\n\n\n          $target.querySelector('[name=\"customer-feedback-comment-email\"]').setAttribute('aria-invalid', true);\n          $target.querySelector('[name=\"customer-feedback-comment-email\"]').after(_errorMessage); //Prohibit submission\n\n          valid = false;\n        } //Return if not valid, else continiue. \n\n\n        if (!valid) {\n          return false;\n        } //Spin\n\n\n        $target.querySelector(\"#feedback-loader\").style.display = 'block'; //Submit\n\n        self.submitComment($target, answerId, postId, commentType, comment, email, gCaptcha, topic);\n      });\n    });\n  }; // Comment submit click\n\n\n  var topicListeners = document.querySelectorAll('[name=\"customer-feedback-comment-topic\"]');\n  var self = _this;\n  topicListeners.forEach(function (topListener) {\n    topListener.addEventListener('change', function (e) {\n      //Container \n      var $container = document.querySelector('#customer-feedback');\n\n      if (e.target.getAttribute('feedback-capability')) {\n        $container.querySelector('[name=\"customer-feedback-comment-email\"]').setAttribute('required', true);\n        $container.querySelector('.customer-feedback-comment-email').style.display = 'block';\n      } else {\n        $container.querySelector('[name=\"customer-feedback-comment-email\"]').setAttribute('required', false);\n        $container.querySelector('.customer-feedback-comment-email').style.display = 'none';\n      }\n    });\n  });\n  return new Form();\n};\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (_default);\n;\n\n(function () {\n  var reactHotLoader = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.default : undefined;\n\n  if (!reactHotLoader) {\n    return;\n  }\n\n  reactHotLoader.register(_default, \"default\", \"/Users/johan/DEVELOPMENT/HELSINGBORG-STAD/HBG-VALET/Sites/helsingborg/wp-content/plugins/Customer-feedback/source/js/form.js\");\n})();\n\n;\n\n(function () {\n  var leaveModule = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.leaveModule : undefined;\n  leaveModule && leaveModule(module);\n})();\n/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../node_modules/webpack/buildin/harmony-module.js */ \"./node_modules/webpack/buildin/harmony-module.js\")(module)))\n\n//# sourceURL=webpack:///./source/js/form.js?");

/***/ })

/******/ });