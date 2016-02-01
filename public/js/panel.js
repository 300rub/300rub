!function ($, c) {
	"use strict";

	/**
	 * Object for working with Panel
	 *
	 * @param {String}  [action]  controller.action
	 * @param {String}  [handler] Panel handler
	 * @param {Integer} [id]      ID
	 *
	 * @constructor
     */
	c.Panel = function (action, handler, id) {
		this.action = action;
		this.handler = handler;

		this.id = 0;
		if (id !== undefined) {
			this.id = parseInt(id);
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
			$ajaxWrapper.find(".j-panel").remove();

			this.$panel = c.$templates.find(".j-panel").clone().appendTo(c.$ajaxWrapper);
			this.$panel.find(".j-close").on("click", $.proxy(this._close, this));

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

			if (this.data.list != undefined) {
				this._setList();
			}

			if (this.data.duplicate != undefined) {
				this._setDuplicate();
			}

			if (this.data.delete != undefined) {
				this._setDelete();
			}
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

		/**
		 * Sets duplicate
		 *
		 * @returns {c.Panel}
		 *
         * @private
         */
		_setDuplicate: function() {
			if (this.id === 0) {
				return this;
			}

			this.$panel.find(".j-duplicate")
				.css("display", "block")
				.attr("data-action", this.data.duplicate.action)
				.attr("data-content", this.data.duplicate.content)
				.attr("data-id", this.data.id)
				.on("click", $.proxy(this._onDuplicate, this));

			return this;
		},

		/**
		 * Duplicate click event
		 *
		 * @private
         */
		_onDuplicate: function() {
			var $duplicate = this.$panel.find(".j-duplicate");

			$.ajaxJson(
				$duplicate.data("action"),
				{
					id: $duplicate.data("id")
				},
				$.proxy(this._onDuplicateBefore, this),
				$.proxy(this._onDuplicateSuccess, this),
				$.proxy(this._onError, this)
			);

			return false;
		},

		/**
		 * Duplicate AJAX before callback function
		 *
		 * @private
		 */
		_onDuplicateBefore: function () {

		},

		/**
		 * Duplicate AJAX success callback function
		 *
		 * @param {Object} [data] Data from server
		 *
		 * @private
		 */
		_onDuplicateSuccess: function (data) {
			var $duplicate = this.$panel.find(".j-duplicate");

			if (parseInt(data.id) !== 0) {
				$.panel($duplicate.data("content"), this.handler, data.id);
			} else {
				// error
			}
		},

		/**
		 * Sets delete
		 *
		 * @returns {c.Panel}
		 *
		 * @private
		 */
		_setDelete: function() {
			if (this.id === 0) {
				return this;
			}

			this.$panel.find(".j-delete")
				.css("display", "block")
				.attr("data-action", this.data.delete.action)
				.attr("data-content", this.data.delete.content)
				.attr("data-id", this.data.id)
				.on("click", $.proxy(this._onDelete, this));

			return this;
		},

		/**
		 * Delete click event
		 *
		 * @private
		 */
		_onDelete: function() {
			var $delete = this.$panel.find(".j-delete");

			if (confirm($delete.data("confirm")) !== true) {
				return false;
			}

			$.ajaxJson(
				$delete.data("action"),
				{
					id: $delete.data("id")
				},
				$.proxy(this._onDeleteBefore, this),
				$.proxy(this._onDeleteSuccess, this),
				$.proxy(this._onError, this)
			);

			return false;
		},

		/**
		 * Delete AJAX before callback function
		 *
		 * @private
		 */
		_onDeleteBefore: function () {

		},

		/**
		 * Delete AJAX success callback function
		 *
		 * @param {Object} [data] Data from server
		 *
		 * @private
		 */
		_onDeleteSuccess: function (data) {
			var $delete = this.$panel.find(".j-delete");

			if (parseInt(data.result) === true) {
				$.panel($delete.data("content"), this.handler);
			} else {
				// error
			}
		}
	};

	/**
	 * Adds Panel to jquery
	 *
	 * @param {String}  [action]  controller.action
	 * @param {String}  [handler] Panel handler
	 * @param {Integer} [id]      ID
	 *
	 * @returns {Window.Core.Panel}
     */
	$.panel = function (action, handler, id) {
		return new c.Panel(action, handler, id);
	};

	/**
	 * Panel constructor
	 *
	 * @constructor
	 */
	$.panel.Constructor = c.Panel;
}(window.jQuery, window.Core);