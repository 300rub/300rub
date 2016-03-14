!function ($, c) {
	"use strict";

	/**
	 * Panel settings handler
	 */
	c.Panel.prototype.settingsInit = function() {
		this._setSettingsDuplicate()._setSettingsDelete()._setSettingsSubmit();
	};

	/**
	 * Sets duplicate
	 *
	 * @returns {c.Panel}
	 *
	 * @private
	 */
	c.Panel.prototype._setSettingsDuplicate = function() {
		if (this.id === 0) {
			return this;
		}

		this.$panel.find(".j-panel-settings-duplicate")
			.on("click", $.proxy(this._onSettingsDuplicate, this))
			.appendTo(this.$panel.find(".j-header"));

		return this;
	};

	/**
	 * Duplicate click event
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsDuplicate = function() {
		$.ajaxJson(
			this.data.duplicate.action,
			{
				id: this.data.id
			},
			$.proxy(this._onSettingsDuplicateBefore, this),
			$.proxy(this._onSettingsDuplicateSuccess, this),
			$.proxy(this._onError, this)
		);

		return false;
	};

	/**
	 * Duplicate AJAX before callback function
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsDuplicateBefore = function () {

	};

	/**
	 * Duplicate AJAX success callback function
	 *
	 * @param {Object} [data] Data from server
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsDuplicateSuccess = function (data) {
		if (parseInt(data.id) !== 0) {
			$.panel(this.data.duplicate.content, this.handler, data.id);
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
	c.Panel.prototype._setSettingsDelete = function() {
		if (this.id === 0) {
			return this;
		}

		this.$panel.find(".j-delete")
			.on("click", $.proxy(this._onSettingsDelete, this))
			.appendTo(this.$panel.find(".j-header"));

		return this;
	};

	/**
	 * Delete click event
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsDelete = function() {
		if (confirm(this.data.delete.confirm) !== true) {
			return false;
		}

		$.ajaxJson(
			this.data.delete.action,
			{
				id: this.data.id
			},
			$.proxy(this._onSettingsDeleteBefore, this),
			$.proxy(this._onSettingsDeleteSuccess, this),
			$.proxy(this._onError, this)
		);

		return false;
	};

	/**
	 * Delete AJAX before callback function
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsDeleteBefore = function () {

	};

	/**
	 * Delete AJAX success callback function
	 *
	 * @param {Object} [data] Data from server
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsDeleteSuccess = function (data) {
		if (parseInt(data.result) === true) {
			$.panel(this.data.delete.content, this.data.delete.handler);
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
		this.$panel.find(".j-panel-settings-submit")
			.on("click", $.proxy(this._onSettingsSubmit, this))
			.appendTo(this.$panel.find(".j-header"));
	};

	/**
	 * Delete click event
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsSubmit = function() {
		$.ajaxJson(
			this.data.submit.action,
			this.$panel.find(".j-panel-form").serializeObject(),
			$.proxy(this._onSettingsSubmitBefore, this),
			$.proxy(this._onSettingsSubmitSuccess, this),
			$.proxy(this._onError, this)
		);

		return false;
	};

	/**
	 * Submit AJAX before callback function
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsSubmitBefore = function () {

	};

	/**
	 * Submit AJAX success callback function
	 *
	 * @param {Object} [data] Data from server
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsSubmitSuccess = function (data) {
		if (!data.errors) {
			$.panel(this.data.submit.content, this.data.submit.handler);
		} else {
			// error
		}
	};

}(window.jQuery, window.Core);