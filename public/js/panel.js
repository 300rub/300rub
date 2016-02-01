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

			this.$panel.find(".j-title").text(this.data.title);
			this.$panel.find(".j-description").text(this.data.description);
			this.$panel.find(".j-header").css("display", "block");
			this.$panel.find(".j-footer").css("display", "block");

			this._setContent();
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
		 * Sets content
		 *
		 * @returns {c.Panel}
		 *
         * @private
         */
		_setContent: function() {
			if (this.data.list != undefined) {
				this._setList();
			}

			if (this.data.duplicate != undefined) {
				this._setDuplicate();
			}

			return this;
		},

		/**
		 * Sets list
		 *
		 * @returns {c.Panel}
		 *
         * @private
         */
		_setList: function() {
			var $itemTemplate, $clone;

			$itemTemplate = $templates.find(".j-panel-item").clone();

			if (this.data.design !== undefined) {
				$itemTemplate.find(".j-design").css("display", "block");
				this.$panel.attr("data-design", this.data.design);
			}

			if (this.data.settings !== undefined) {
				$itemTemplate.find(".j-settings").css("display", "block");
				this.$panel.attr("data-settings", this.data.settings);
			}

			if (this.data.content !== undefined) {
				this.$panel.attr("data-content", this.data.content);
			}

			$.each(data.list.items, $.proxy(function (i, item) {
				$clone = $itemTemplate.clone();

				if (item.icon !== undefined) {
					$clone.find(".j-icon").css("display", "block").addClass("l-icon-" + item.icon);
				} else if (this.data.icon !== undefined) {
					$clone.find(".j-icon").css("display", "block").addClass("l-icon-" + this.data.icon);
				}

				$clone.attr("data-id", item.id);
				$clone.find(".j-label").text(item.label);
				$clone.appendTo(this.$panel.find(".j-container"));
			}, this));

			return this;
		},

		_setDuplicate: function() {
			this.$panel.find(".duplicate")
				.css("display", "block")
				.attr("data-action", this.data.duplicate.action)
				.attr("data-content", this.data.duplicate.content)
				.on("click", this._onDuplicate);
		},

		_onDuplicate: function() {
			var action = $(this).data("action");
			var content = $(this).data("content");

			$.ajaxJson(
				action,
				{},
				$.proxy(this._onLoadBefore, this),
				$.proxy(this._onLoadSuccess, this),
				$.proxy(this._onError, this)
			);
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