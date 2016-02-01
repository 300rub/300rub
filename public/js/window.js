!function ($, c) {
	"use strict";

	/**
	 * Object for working with Window
	 *
	 * @param {String} [action]  controller.action
	 * @param {String} [handler] Panel handler
	 *
	 * @constructor
	 */
	c.Window = function (action, handler) {
		this.action = action;
		this.handler = handler;
		this.init();
	};

	/**
	  * Window prototype
	  */
	c.Window.prototype = {
		/**
		 * Constructor
		 *
		 * @var {window.Core.Window}
		 */
		constructor: c.Window,

		/**
		 * DOM-element of window
		 *
		 * @type {HTMLElement}
		 */
		$window: null,

		/**
		 * DOM-element of overlay
		 *
		 * @type {HTMLElement}
		 */
		$overlay: null,

		/**
		 * Data from AJAX request
		 *
		 * @type {Object}
		 */
		data: {},

		/**
		 * Initialization
		 */
		init: function () {
			this.$overlay = c.$templates.find(".j-overlay").clone().appendTo(c.$ajaxWrapper);
			this.$window = c.$templates.find(".j-window").clone().appendTo(c.$ajaxWrapper);

			this.$window.find(".j-_close").on("click", $.proxy(this._close, this));
			this.$overlay.on("click", $.proxy(this._close, this));

			$.ajaxJson(
				this.action,
				{},
				$.proxy(this._onLoadBefore, this),
				$.proxy(this._onLoadSuccess, this),
				$.proxy(this._onError, this)
			);
		},

		/**
		 * Close window click event
		 *
		 * @returns {Boolean}
		 *
		 * @private
		 */
		_close: function () {
			this.$window.remove();
			this.$overlay.remove();

			return false;
		},

		/**
		 * Load AJAX before callback function
		 *
		 * @private
		 */
		_onLoadBefore: function () {

		},

		/**
		 * Load AJAX success callback function
		 *
		 * @param {Object} [data] Data from server
		 *
		 * @private
		 */
		_onLoadSuccess: function (data) {
			this.data = data;

			this.$window.find(".j-header").text(data.title).css("display", "block");
			this.$window.find(".j-footer").css("display", "block");
			this.$window.find(".j-submit").on("click", $.proxy(this._submit, this));

			this[this.handler]();
		},

		/**
		 * AJAX error callback function
		 *
		 * @param {jqXHR}  [jqXHR]       jQuery XMLHttpRequest
		 * @param {String} [textStatus]  Text status
		 * @param {String} [errorThrown] Error thrown
		 *
		 * @private
		 */
		_onError: function (jqXHR, textStatus, errorThrown) {

		},

		/**
		 * Submit click event
		 *
		 * @returns {Boolean}
         *
		 * @private
         */
		_submit: function () {
			$.ajaxJson(
				this.data.action,
				this.$window.find(".j-window-form").serializeObject(),
				$.proxy(this._onSendBefore, this),
				$.proxy(this._onSendSuccess, this),
				$.proxy(this._onError, this)
			);

			return false;
		},

		/**
		 * Send AJAX before callback function
		 *
		 * @returns {Boolean}
		 *
         * @private
         */
		_onSendBefore: function () {
			if ($.validator(this.$window.find(".j-window-form")).validate() === false) {
				return false;
			}
		},

		/**
		 * Send AJAX success callback function
		 *
		 * @param {Object} [data] Data from server
		 *
		 * @private
		 */
		_onSendSuccess: function (data) {
			if (!$.isEmptyObject(data.errors)) {
				console.log(data.errors);
				$.validator(this.$window.find(".j-window-form")).showErrors(data.errors);
				return false;
			}

			if (data.reload === true) {
				location.reload();
			}

			this._close();
		}
	};

	/**
	 * Adds Window to jquery
	 *
	 * @returns {Window.Core.Window}
	 */
	$.window = function (action, handler) {
		return new c.Window(action, handler);
	};

	/**
	 * Window constructor
	 *
	 * @constructor
	 */
	$.window.Constructor = c.Window;
}(window.jQuery, window.Core);