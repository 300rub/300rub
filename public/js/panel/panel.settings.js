!function ($, c) {
	"use strict";

	/**
	 * Panel settings handler
	 */
	c.Panel.prototype.settingsInit = function() {
		this.$_settingsDuplicate = c.$templates.find(".j-panel-settings-duplicate").clone();
		this.$_settingsDelete = c.$templates.find(".j-panel-settings-delete").clone();
		this.$_settingsSubmit = c.$templates.find(".j-panel-settings-submit").clone();

		this._setSettingsDuplicate()._setSettingsDelete()._setSettingsSubmit();
	};

	/**
	 * DOM-element of duplicate button
	 *
	 * @type {Object}
	 */
	c.Panel.prototype.$_settingsDuplicate = null;

	/**
	 * DOM-element of delete button
	 *
	 * @type {Object}
	 */
	c.Panel.prototype.$_settingsDelete = null;

	/**
	 * DOM-element of submit
	 *
	 * @type {Object}
     */
	c.Panel.prototype.$_settingsSubmit = null;

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

		this.$_settingsDuplicate
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
			$.proxy(this.onError, this)
		);

		return false;
	};

	/**
	 * Duplicate AJAX before callback function
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsDuplicateBefore = function () {
		this.$_settingsDuplicate.find(".j-label").addClass("j-hide");
		this.$_settingsDuplicate.find(".j-loader").removeClass("j-hide");
	};

	/**
	 * Duplicate AJAX success callback function
	 *
	 * @param {Object} [data] Data from server
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsDuplicateSuccess = function (data) {
		this.$_settingsDuplicate.find(".j-label").removeClass("j-hide");
		this.$_settingsDuplicate.find(".j-loader").addClass("j-hide");

		if (parseInt(data.id) !== 0) {
			$.panel(this.data.duplicate.content, data.id);
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

		this.$_settingsDelete
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
			$.proxy(this.onError, this)
		);

		return false;
	};

	/**
	 * Delete AJAX before callback function
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsDeleteBefore = function () {
		this.$_settingsDelete.find(".j-label").addClass("j-hide");
		this.$_settingsDelete.find(".j-loader").removeClass("j-hide");
	};

	/**
	 * Delete AJAX success callback function
	 *
	 * @param {Object} [data] Data from server
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsDeleteSuccess = function (data) {
		this.$_settingsDelete.find(".j-label").removeClass("j-hide");
		this.$_settingsDelete.find(".j-loader").addClass("j-hide");

		if (parseInt(data.result) === true) {
			if (parseInt(this.id) === c.sectionId || c.sectionId === 0) {
				location.href = "/" + c.language + "/";
			} else {
				$.panel(this.data.delete.content);
			}
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
		this.$_settingsSubmit
			.on("click", $.proxy(this._onSettingsSubmit, this))
			.appendTo(this.$panel.find(".j-footer"));
	};

	/**
	 * Delete click event
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsSubmit = function() {
		$.ajaxJson(
			this.data.submit.action,
			$.extend({}, this.$panel.find(".j-panel-form").serializeObject(), {id: this.id}),
			$.proxy(this._onSettingsSubmitBefore, this),
			$.proxy(this._onSettingsSubmitSuccess, this),
			$.proxy(this.onError, this)
		);

		return false;
	};

	/**
	 * Submit AJAX before callback function
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsSubmitBefore = function () {
		this.$_settingsSubmit.find(".j-label").addClass("j-hide");
		this.$_settingsSubmit.find(".j-loader").removeClass("j-hide");
	};

	/**
	 * Submit AJAX success callback function
	 *
	 * @param {Object} [data] Data from server
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsSubmitSuccess = function (data) {
		this.$_settingsSubmit.find(".j-label").removeClass("j-hide");
		this.$_settingsSubmit.find(".j-loader").addClass("j-hide");

		if (data.errors !== undefined || data.errors.count === 0) {
			$.panel(this.data.submit.content);
		} else {
			// error
		}
	};

}(window.jQuery, window.Core);