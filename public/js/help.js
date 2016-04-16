!function ($, c) {
	"use strict";

	/**
	 * Object for working with Help
	 *
	 * @param {String} [category] Category
	 * @param {String} [name]     Name
	 *
	 * @constructor
	 */
	c.Help = function (category, name) {
		this.category = category;
		this.name = name;

		this.init();
	};

	/**
	 * Help prototype
	 */
	c.Help.prototype = {
		/**
		 * Constructor
		 *
		 * @var {window.Core.Help}
		 */
		constructor: c.Help,

		/**
		 * DOM-element of Help's window
		 *
		 * @type {Object}
		 */
		$_help: null,

		/**
		 * DOM-element of window's container
		 *
		 * @type {Object}
		 */
		$_container: null,

		/**
		 * DOM-element of overlay
		 *
		 * @type {Object}
		 */
		$_overlay: null,

		/**
		 * Initialization
		 */
		init: function () {
			this.$_overlay = c.$templates.find(".j-help-overlay").clone().appendTo(c.$ajaxWrapper);
			this.$_help = c.$templates.find(".j-help").clone().appendTo(c.$ajaxWrapper);
			this.$_container = this.$_help.find(".j-container");

			this.$_help.find(".j-close").on("click", $.proxy(this._close, this));
			this.$_overlay.on("click", $.proxy(this._close, this));

			$.ajaxJson(
				"help.load",
				{
					id: this.id,
					category: this.category,
					name: this.name
				},
				$.proxy(this._onLoadBefore, this),
				$.proxy(this._onLoadSuccess, this),
				$.proxy(this._onError, this)
			);
		},

		/**
		 * Close help window click event
		 *
		 * @returns {Boolean}
		 *
		 * @private
		 */
		close: function () {
			this.$_help.remove();
			this.$_overlay.remove();

			return false;
		},

		/**
		 * Load AJAX before callback function
		 *
		 * @private
		 */
		_onLoadBefore: function () {
			this.$_container.find(".j-loader").removeClass("j-hide");
		},

		/**
		 * Load AJAX success callback function
		 *
		 * @param {Object} [data] Data from server
		 *
		 * @private
		 */
		_onLoadSuccess: function (data) {
			this.$_container.find(".j-loader").addClass("j-hide");
			this.$_container.find(".j-content").html(data);
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
			this.$_container.find(".j-loader").addClass("j-hide");
			alert("error");
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);
		}
	};

	/**
	 * Adds Window to jquery
	 *
	 * @param {String} [category] Category
	 * @param {String} [name]     Name
	 *
	 * @returns {Window.Core.Help}
	 */
	$.help = function (category, name) {
		return new c.Help(category, name);
	};

	/**
	 * Help constructor
	 *
	 * @constructor
	 */
	$.help.Constructor = c.Help;
}(window.jQuery, window.Core);