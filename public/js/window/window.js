!function ($, c) {
	"use strict";

	/**
	 * Object for working with Window
	 *
	 * @param {String} [action] controller.action
	 * @param {int}    [id]     ID
	 *
	 * @constructor
	 */
	c.Window = function (action, id) {
		this.action = action;

		if (id !== undefined) {
			this.id = parseInt(id);
		} else {
			this.id = 0;
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
		 * @type {Object}
		 */
		$window: null,

		/**
		 * DOM-element of window's container
		 *
		 * @type {Object}
		 */
		$container: null,

		/**
		 * DOM-element of window's submit
		 *
		 * @type {Object}
		 */
		$submit: null,

		/**
		 * DOM-element of overlay
		 *
		 * @type {Object}
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
			this.$container = this.$window.find(".j-container");
			this.$submit = this.$window.find(".j-submit");

			this.$window.find(".j-close").on("click", $.proxy(this.close, this));
			this.$overlay.on("click", $.proxy(this.close, this));

			$.ajaxJson(
				this.action,
				{
					id: this.id
				},
				$.proxy(this._onLoadBefore, this),
				$.proxy(this._onLoadSuccess, this),
				$.proxy(this.onError, this)
			);
		},

		/**
		 * Close window click event
		 *
		 * @returns {Boolean}
		 *
		 * @private
		 */
		close: function () {
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
			this.$container.find(".j-loader").removeClass("j-hide");
		},

		/**
		 * Load AJAX success callback function
		 *
		 * @param {Object} [data] Data from server
		 *
		 * @private
		 */
		_onLoadSuccess: function (data) {
			this.$container.find(".j-loader").addClass("j-hide");

			this.data = data;

			this.$window.find(".j-header").text(data.title).css("display", "block");
			this.$window.find(".j-footer").css("display", "block");

			if (this.data.button !== undefined) {
				this.$submit.find(".j-label").text(this.data.button.label);
				this.$submit.find(".j-icon").addClass(this.data.button.icon);
			}
			this.$submit.on("click", $.proxy(this._submit, this));
			
			this[this.data.handler]();
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
		onError: function (jqXHR, textStatus, errorThrown) {
			this.$container.find(".j-loader").addClass("j-hide");
			alert("error");
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);
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
				$.proxy(this.onError, this)
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

			this.$submit.find(".j-icon").addClass("j-hide");
			this.$submit.find(".j-loader").removeClass("j-hide");
		},

		/**
		 * Submit AJAX success callback function
		 *
		 * @param {Object} [data] Data from server
		 *
		 * @private
		 */
		_onSubmitSuccess: function (data) {
			this.$submit.find(".j-icon").removeClass("j-hide");
			this.$submit.find(".j-loader").addClass("j-hide");

			if (!$.isEmptyObject(data.errors)) {
				$.validator(this.$window.find(".j-window-form")).showErrors(data.errors);
				return false;
			}

			if (data.reload === true) {
				location.reload();
			}

			this.close();
		}
	};

	/**
	 * Adds Window to jquery
	 *
	 * @param {String} [action] controller.action
	 * @param {int}    [id]     ID
	 *
	 * @returns {Window.Core.Window}
	 */
	$.window = function (action, id) {
		return new c.Window(action, id);
	};

	/**
	 * Window constructor
	 *
	 * @constructor
	 */
	$.window.Constructor = c.Window;
}(window.jQuery, window.Core);