!function ($, c) {
	"use strict";

	/**
	 * Object for working with Panel
	 *
	 * @param {String} [action] controller.action
	 * @param {int}    [id]     ID
	 *
	 * @constructor
     */
	c.Panel = function (action, id) {
		this.action = action;
		if (id !== undefined) {
			this.id = parseInt(id);
		} else {
			this.id = 0;
		}

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
		 * @type {Object}
		 */
		$panel: null,

		/**
		 * DOM-element of panel's container
		 *
		 * @type {Object}
		 */
		$container: null,

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
			c.$ajaxWrapper.find(".j-panel").remove();

			this.$panel = c.$templates.find(".j-panel").clone().appendTo(c.$ajaxWrapper);
			this.$container = this.$panel.find(".j-container");
			this.$panel.find(".j-close").on("click", $.proxy(this.close, this));

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
		 * Sets container's max-height
		 *
		 * @private
         */
		_setHeight: function() {
			this.$container.css("max-height", $.proxy(function () {
				return $(window).outerHeight()
					- 40
					- this.$panel.find(".j-header").outerHeight()
					- this.$panel.find(".j-footer").outerHeight();
			}, this));
		},

		/**
		 * Close panel click event
		 *
		 * @returns {Boolean}
		 *
         * @private
         */
		close: function() {
			this.$panel.remove();
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

			this.setBack();
			this.$panel.find(".j-title").text(this.data.title);
			this.$panel.find(".j-description").text(this.data.description);
			this.$panel.find(".j-header").css("display", "block");
			this.$panel.find(".j-footer").css("display", "block");

			this._setHeight();
			$(window).resize($.proxy(function () {
				this._setHeight();
			}, this));

			this[this.data.handler]();
		},

		/**
		 * Sets back link
		 *
		 * @returns {c.Panel}
		 *
         * @private
         */
		setBack: function() {
			if (this.data.back !== undefined) {
				this.$panel.find(".j-back")
					.css("display", "block")
					.on("click", $.proxy(function() {
						$.panel(this.data.back);
						return false;
					}, this));
			}

			return this;
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
		}
	};

	/**
	 * Adds Panel to jquery
	 *
	 * @param {String} [action] controller.action
	 * @param {int}    [id]     ID
	 *
	 * @returns {Window.Core.Panel}
     */
	$.panel = function (action, id) {
		return new c.Panel(action, id);
	};

	/**
	 * Panel constructor
	 *
	 * @constructor
	 */
	$.panel.Constructor = c.Panel;
}(window.jQuery, window.Core);