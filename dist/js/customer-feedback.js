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
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _form__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./form */ \"./source/js/form.js\");\nvar __signature__ = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.default.signature : function (a) {\n  return a;\n};\n\n //import Captcha from './captcha'; \n\nwindow.addEventListener('DOMContentLoaded', function (event) {\n  Object(_form__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(); //Captcha(); \n});\n\n//# sourceURL=webpack:///./source/js/app.js?");

/***/ }),

/***/ "./source/js/form.js":
/*!***************************!*\
  !*** ./source/js/form.js ***!
  \***************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* WEBPACK VAR INJECTION */(function(module) {(function () {\n  var enterModule = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.enterModule : undefined;\n  enterModule && enterModule(module);\n})();\n\nvar __signature__ = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.default.signature : function (a) {\n  return a;\n};\n\nvar _default = function _default() {\n  function Form() {\n    this.handleEvents();\n  }\n\n  Form.prototype.submitComment = function (target, answerId, postId, commentType, comment, email, gCaptcha, topic) {\n    var data = {\n      action: 'submit_comment',\n      postid: postId,\n      comment: comment,\n      answerid: answerId,\n      commenttype: commentType,\n      email: email,\n      captcha: gCaptcha,\n      topicid: topic\n    };\n    var $target = target;\n    $.post(ajaxurl, data, function (response) {\n      //Disable loader\n      document.getElementById(\"feedback-loader\").style.display = 'none'; //Handle response\n\n      if (response == 'true') {\n        $target.querySelector('.customer-feedback-comment').style.display = 'none';\n        $target.querySelector('.customer-feedback-thanks').style.display = 'block';\n      } else {\n        $target.querySelector('.customer-feedback-comment').style.display = 'none';\n        $target.querySelector('.customer-feedback-error').style.display = 'block';\n      }\n    });\n  };\n  /**\n   * Submits the initail yes or no response\n   * @param  {integer} postId Post id\n   * @param  {string}  answer Yes or no\n   * @return {void}w\n   */\n\n\n  Form.prototype.submitInitialResponse = function (target, postId, answer) {\n    var data = {\n      action: 'submit_response',\n      postid: postId,\n      answer: answer\n    };\n    document.getElementById(\"feedback-loader\").style.display = 'block';\n    $.post(ajaxurl, data, function (response) {\n      //Status\n      if (response.status != 200) {\n        document.querySelector('.customer-feedback-js-error').style.display = \"block\";\n      }\n\n      if (!isNaN(parseFloat(response)) && isFinite(response)) {\n        //Create id holder\n        var feedBackIdElement = document.createElement(\"input\");\n        feedBackIdElement.type = \"hidden\";\n        feedBackIdElement.name = \"customer-feedback-answer-id\";\n        feedBackIdElement.value = response;\n        document.querySelector('[name=\"customer-feedback-post-id\"]').parentElement.appendChild(feedBackIdElement); //Hide current controls \n        //document.querySelector('.customer-feedback-topics').style.display = \"none\";\n\n        document.querySelector('.customer-feedback-comment-email').parentElement.style.display = \"none\";\n        document.querySelector('.customer-feedback-answers').style.display = \"none\"; //Show comment section\n\n        document.querySelector('.customer-feedback-comment').style.display = \"block\";\n      }\n\n      if (data.answer == 'yes' && !isNaN(parseFloat(response)) && isFinite(response)) {\n        document.querySelector('.feedback-label-yes').style.display = \"block\";\n      }\n\n      if (data.answer == 'no' && !isNaN(parseFloat(response)) && isFinite(response)) {\n        document.querySelector('.feedback-label-no').style.display = \"block\";\n      } //Loading done\n\n\n      document.getElementById(\"feedback-loader\").style.display = 'none';\n    });\n  };\n\n  Form.prototype.handleEvents = function () {\n    var answerButton = document.querySelectorAll('[data-action=customer-feedback-submit-response]');\n    var self = this;\n    answerButton.forEach(function (optionButton) {\n      optionButton.addEventListener('click', function (e) {\n        //Prevent default action\n        e.preventDefault(); //Set pressed event\n\n        this.setAttribute(\"aria-pressed\", true); //Get submission id\n\n        var FeedBackID = document.getElementById(\"customer-feedback-post-id\").value; //Get submission answer\n\n        var Answer = this.getAttribute('value'); //Submit answer\n\n        self.submitInitialResponse(this, FeedBackID, Answer);\n      });\n    }); // Comment submit click\n\n    var submitButton = document.querySelectorAll('[data-action=customer-feedback-submit-comment]');\n    submitButton.forEach(function (Submit) {\n      Submit.addEventListener('click', function (e) {\n        e.preventDefault(); //Target div \n\n        var $target = document.getElementById('customer-feedback'); //Reset state (make fields valid attr)\n\n        $target.querySelector('[name=\"customer-feedback-comment-text\"]').setAttribute('aria-invalid', false);\n        $target.querySelector('[name=\"customer-feedback-comment-topic\"]').setAttribute('aria-invalid', false);\n        $target.querySelector('[name=\"customer-feedback-comment-email\"]').setAttribute('aria-invalid', false); //Reset state (remove messages)\n\n        var errorMessages = $target.querySelectorAll('.feedback-form-dynamic-error');\n        errorMessages.forEach(function (errorMessage) {\n          errorMessage.remove();\n        }); //Get vars \n\n        var commentType = 'comment';\n        var topic = null;\n        var gCaptcha = null;\n        var answerId = $target.querySelector('[name=\"customer-feedback-answer-id\"]').value;\n        var postId = $target.querySelector('[name=\"customer-feedback-post-id\"]').value;\n        var comment = $target.querySelector('[name=\"customer-feedback-comment-text\"]').value;\n        var email = $target.querySelector('[name=\"customer-feedback-comment-email\"]').value;\n        var emailRequired = $target.querySelector('[name=\"customer-feedback-comment-email\"]').getAttribute('required');\n        var valid = true; //Topic\n\n        if ($target.querySelectorAll('[name=\"customer-feedback-comment-topic\"]:checked').length == 1) {\n          topic = $target.querySelector('[name=\"customer-feedback-comment-topic\"]:checked').value;\n        } else {\n          //Create error node\n          var topicErrorMessage = document.createElement('div');\n          topicErrorMessage.id = 'topic-error';\n          topicErrorMessage.classList = 'c-option__input-invalid-message feedback-form-dynamic-error';\n          topicErrorMessage.style.display = 'block';\n          topicErrorMessage.appendChild(document.createTextNode(feedback.select_topic)); //Show invalid notice\n\n          $target.querySelector('[name=\"customer-feedback-comment-topic\"]').setAttribute('aria-invalid', true);\n          $target.querySelector('.customer-feedback-topics .c-option.c-option__radio:last-child').after(topicErrorMessage); //Prohibit submission\n\n          valid = false;\n        } //Get captcha if not logged in\n\n\n        if ($target.querySelector('[name=\"g-recaptcha-response\"]').length && $target.querySelector('[name=\"g-recaptcha-response\"]').value !== '') {//TODO: ERR    gCaptcha = $target.querySelector('[name=\"g-recaptcha-response\"]').value;\n        } //Check length\n\n\n        if (comment.length < 15) {\n          //Create error node\n          var errorMessage = document.createElement('div');\n          errorMessage.id = 'length-error';\n          errorMessage.classList = 'c-textarea-invalid-message feedback-form-dynamic-error';\n          errorMessage.style.display = 'block';\n          errorMessage.appendChild(document.createTextNode(feedback.comment_min_characters)); //Show invalid notice\n\n          $target.querySelector('[name=\"customer-feedback-comment-text\"]').setAttribute('aria-invalid', true);\n          $target.querySelector('[name=\"customer-feedback-comment-text\"]').after(errorMessage); //Prohibit submission\n\n          valid = false;\n        } //Check email if exists \n\n\n        if (email.length === 0 && emailRequired == true) {\n          //Create error node\n          var _errorMessage = document.createElement('div');\n\n          _errorMessage.id = 'email-error';\n          _errorMessage.classList = 'c-input-invalid-message feedback-form-dynamic-error';\n          _errorMessage.style.display = 'block';\n\n          _errorMessage.appendChild(document.createTextNode(feedback.enter_email)); //Show invalid notice\n\n\n          $target.querySelector('[name=\"customer-feedback-comment-email\"]').setAttribute('aria-invalid', true);\n          $target.querySelector('[name=\"customer-feedback-comment-email\"]').after(_errorMessage); //Prohibit submission\n\n          valid = false;\n        } //Return if not valid, else continiue. \n\n\n        if (!valid) {\n          return false;\n        } //Spin\n\n\n        $target.getElementById(\"#feedback-loader\").style.display = 'block'; //Submit\n\n        self.submitComment($target, answerId, postId, commentType, comment, email, gCaptcha, topic);\n      });\n    });\n  }; // Comment submit click\n\n\n  var topicListeners = document.querySelectorAll('[name=\"customer-feedback-comment-topic\"]');\n  topicListeners.forEach(function (topListener) {\n    topListener.addEventListener('change', function (e) {\n      var $target = document.getElementById('customer-feedback');\n    });\n  });\n  /* \n      $('[name=\"customer-feedback-comment-topic\"]').change(function(e) {\n          $target = $(e.target).parents('.customer-feedback-container');\n          $target.find('div.customer-feedback-topics div.danger').remove();\n           if ($(e.target).attr('topic-description')) {\n              $target.find('.topic-description').show().html('<span class=\"text-sm\">' + $(e.target).attr('topic-description') + '</span>');\n          } else {\n              $target.find('.topic-description').hide();\n          }\n           if ($(e.target).attr('feedback-capability')) {\n              $target.find('[name=\"customer-feedback-comment-email\"]')\n                  .prop('required', true)\n                      .parent().show();\n          } else {\n              $target.find('[name=\"customer-feedback-comment-email\"]')\n                  .prop('required', false)\n                      .parent().hide();\n          }\n      });\n  };    */\n\n  return new Form();\n};\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (_default);\n;\n\n(function () {\n  var reactHotLoader = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.default : undefined;\n\n  if (!reactHotLoader) {\n    return;\n  }\n\n  reactHotLoader.register(_default, \"default\", \"/Users/seno1000/www/public/developement.local/wp-content/plugins/Customer-feedback/source/js/form.js\");\n})();\n\n;\n\n(function () {\n  var leaveModule = typeof reactHotLoaderGlobal !== 'undefined' ? reactHotLoaderGlobal.leaveModule : undefined;\n  leaveModule && leaveModule(module);\n})();\n/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../node_modules/webpack/buildin/harmony-module.js */ \"./node_modules/webpack/buildin/harmony-module.js\")(module)))\n\n//# sourceURL=webpack:///./source/js/form.js?");

/***/ })

/******/ });