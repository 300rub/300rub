!function ($, c) {
	"use strict";

	/**
	 * Object for initialising main configuration
	 *
	 * @constructor
     */
	c.Handler = function () {
		this.init();
	};

	/**
	 * Handler's prototype
	 *
	 * @type {Object}
     */
	c.Handler.prototype = {
		/**
		 * Constructor
		 *
		 * @var {window.Core.Handler}
		 */
		constructor: c.AjaxJson,

		/**
		 * Initialisation
		 */
		init: function () {
			this
				._setTemplates()
				._setAjaxWrapper();
			$("#login-button").on("click", this._onLoginButtonClick);
		},

		/**
		 * Sets templates
		 *
		 * @returns {c.Handler}
		 *
		 * @private
         */
		_setTemplates: function () {
			c.$templates = $('#templates');
			return this;
		},

		/**
		 * Sets ajax wrapper
		 *
		 * @returns {c.Handler}
		 *
		 * @private
         */
		_setAjaxWrapper: function () {
			c.$ajaxWrapper = $('#ajax-wrapper');
			return this;
		},

		/**
		 * Login button click event
		 *
		 * @returns {Boolean}
		 *
         * @private
         */
		_onLoginButtonClick: function () {
			$.window({
				action: "user.window",
				cssClass: "l-window-login"
			});
			return false;
		}
	};

	/**
	 * Adds Handler to jquery
	 *
	 * @returns {Window.Core.Handler}
     */
	$.handler = function() {
		return new c.Handler();
	};

	/**
	 * AjaxJson constructor
	 *
	 * @constructor
	 */
	$.handler.Constructor = c.Handler;

	$(document).ready(function() {
		$.handler();
	});
}(window.jQuery, window.Core);