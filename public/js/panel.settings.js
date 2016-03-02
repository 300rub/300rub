!function ($, c) {
	"use strict";

	/**
	 * Panel settings handler
	 */
	c.Panel.prototype.settings = function() {
		this._setDuplicate()._setDelete()._setSettingsSubmit();
	};

	/**
	 * Sets duplicate
	 *
	 * @returns {c.Panel}
	 *
	 * @private
	 */
	c.Panel.prototype._setDuplicate = function() {
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
	};

	/**
	 * Duplicate click event
	 *
	 * @private
	 */
	c.Panel.prototype._onDuplicate = function() {
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
	};

	/**
	 * Duplicate AJAX before callback function
	 *
	 * @private
	 */
	c.Panel.prototype._onDuplicateBefore = function () {

	};

	/**
	 * Duplicate AJAX success callback function
	 *
	 * @param {Object} [data] Data from server
	 *
	 * @private
	 */
	c.Panel.prototype._onDuplicateSuccess = function (data) {
		var $duplicate = this.$panel.find(".j-duplicate");

		if (parseInt(data.id) !== 0) {
			$.panel($duplicate.data("content"), this.handler, data.id);
		} else {
			// error
		}
	};

	/**
	 * Sets delete
	 *
	 * @returns {c.Panel}
	 *
	 * @private
	 */
	c.Panel.prototype._setDelete = function() {
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
	};

	/**
	 * Delete click event
	 *
	 * @private
	 */
	c.Panel.prototype._onDelete = function() {
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
	};

	/**
	 * Delete AJAX before callback function
	 *
	 * @private
	 */
	c.Panel.prototype._onDeleteBefore = function () {

	};

	/**
	 * Delete AJAX success callback function
	 *
	 * @param {Object} [data] Data from server
	 *
	 * @private
	 */
	c.Panel.prototype._onDeleteSuccess = function (data) {
		var $delete = this.$panel.find(".j-delete");

		if (parseInt(data.result) === true) {
			$.panel($delete.data("content"), this.handler);
		} else {
			// error
		}
	};

	/**
	 * Sets submit events
	 *
	 * @private
     */
	c.Panel.prototype._setSettingsSubmit = function() {
		this.$panel.find(".j-footer .j-submit")
	}

}(window.jQuery, window.Core);