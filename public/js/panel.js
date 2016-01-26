!function ($, c) {
	"use strict";

	/**
	 * Object for working with Panel
	 *
	 * @param {String} [action]  controller.action
	 * @param {String} [handler] Panel handler
	 *
	 * @constructor
     */
	c.Panel = function (action, handler) {
		this.action = action;
		this.handler = handler;
		this.init();
	};

	/**
	  * Panel prototype
	  */
	c.Panel.prototype = {
		/**
		 * Constructor
		 *
		 * @var {window.Core.Panel}
		 */
		constructor: c.Panel,

		/**
		 * DOM-element of panel
		 *
		 * @type {HTMLElement}
		 */
		$panel: null,

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
			this.$panel = c.$templates.find(".j-panel").clone().appendTo(c.$ajaxWrapper);
			this.$panel.find(".j-close").on("click", $.proxy(this._close, this));

			$.ajaxJson(
				this.action,
				{},
				$.proxy(this._onLoadBefore, this),
				$.proxy(this._onLoadSuccess, this),
				$.proxy(this._onError, this)
			);
		},

		/**
		 * Close panel click event
		 *
		 * @returns {Boolean}
		 *
         * @private
         */
		_close: function() {
			this.$panel.remove();
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

			this.$panel.find(".j-title").text(data.title);
			this.$panel.find(".j-description").text(data.description);
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
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);
		}
	};

	/**
	 * Adds Panel to jquery
	 *
	 * @returns {Window.Core.Panel}
	 */
	$.panel = function (action, handler) {
		return new c.Panel(action, handler);
	};

	/**
	 * Panel constructor
	 *
	 * @constructor
	 */
	$.panel.Constructor = c.Panel;
}(window.jQuery, window.Core);