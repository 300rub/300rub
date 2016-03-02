!function ($, c) {
	"use strict";

	/**
	 * Object for working with Window
	 *
	 * @param {String}  [action]  controller.action
	 * @param {String}  [handler] Panel handler
	 * @param {Integer} [id]      ID
	 *
	 * @constructor
	 */
	c.Window = function (action, handler, id) {
		this.action = action;
		this.handler = handler;

		this.id = 0;
		if (id !== undefined) {
			this.id = parseInt(id);
		}

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
				{
					id: this.id
				},
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
				$.proxy(this._onSubmitBefore, this),
				$.proxy(this._onSubmitSuccess, this),
				$.proxy(this._onError, this)
			);

			return false;
		},

		/**
		 * Submit AJAX before callback function
		 *
		 * @returns {Boolean}
		 *
         * @private
         */
		_onSubmitBefore: function () {
			if ($.validator(this.$window.find(".j-window-form")).validate() === false) {
				return false;
			}
		},

		/**
		 * Submit AJAX success callback function
		 *
		 * @param {Object} [data] Data from server
		 *
		 * @private
		 */
		_onSubmitSuccess: function (data) {
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
	 * @param {String}  [action]  controller.action
	 * @param {String}  [handler] Window handler
	 * @param {Integer} [id]      ID
	 *
	 * @returns {Window.Core.Window}
	 */
	$.window = function (action, handler, id) {
		return new c.Window(action, handler, id);
	};

	/**
	 * Window constructor
	 *
	 * @constructor
	 */
	$.window.Constructor = c.Window;
}(window.jQuery, window.Core);