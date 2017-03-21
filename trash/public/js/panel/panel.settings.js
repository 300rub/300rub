!function ($, c) {
	"use strict";

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
	 * DOM-element of delete confirmation
	 *
	 * @type {Object}
	 */
	c.Panel.prototype.$_settingsDeleteConfirmation = null;

	/**
	 * DOM-element of submit
	 *
	 * @type {Object}
	 */
	c.Panel.prototype.$_settingsSubmit = null;

	/**
	 * Panel settings handler
	 */
	c.Panel.prototype.settingsInit = function() {
		this.$_settingsDuplicate = c.$templates.find(".j-panel-settings-duplicate").clone();
		this.$_settingsDelete = c.$templates.find(".j-panel-settings-delete").clone();
		this.$_settingsDeleteConfirmation =
			c.$templates.find(".j-panel-settings-delete-confirmation").clone();
		this.$_settingsSubmit = c.$templates.find(".j-panel-submit").clone();

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
		this.$_settingsDuplicate.find(".j-icon").addClass("d-hide");
		this.$_settingsDuplicate.find(".j-loader").removeClass("d-hide");
	};

	/**
	 * Duplicate AJAX success callback function
	 *
	 * @param {Object} [data] Data from server
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsDuplicateSuccess = function (data) {
		this.$_settingsDuplicate.find(".j-icon").removeClass("d-hide");
		this.$_settingsDuplicate.find(".j-loader").addClass("d-hide");

		if (parseInt(data.result) !== 0) {
			$.panel({
				action: this.data.duplicate.content,
				id: data.result
			});
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
		this.$_settingsDeleteConfirmation.appendTo(this.$panel.find(".j-header"));

		this.$_settingsDeleteConfirmation.find(".j-cancel").on("click", $.proxy(function() {
			this.$_settingsDeleteConfirmation.remove();
			this.$_settingsDeleteConfirmation =
				c.$templates.find(".j-panel-settings-delete-confirmation").clone();
		}, this));

		this.$_settingsDeleteConfirmation.find(".j-delete").on("click", $.proxy(function() {
			$.ajaxJson(
				this.data.delete.action,
				{
					id: this.data.id
				},
				$.proxy(this._onSettingsDeleteBefore, this),
				$.proxy(this._onSettingsDeleteSuccess, this),
				$.proxy(this.onError, this)
			);
		}, this));

		return false;
	};

	/**
	 * Delete AJAX before callback function
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsDeleteBefore = function () {
		this.$_settingsDeleteConfirmation.find(".j-icon").addClass("d-hide");
		this.$_settingsDeleteConfirmation.find(".j-loader").removeClass("d-hide");
	};

	/**
	 * Delete AJAX success callback function
	 *
	 * @param {Object} [data] Data from server
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsDeleteSuccess = function (data) {
		this.$_settingsDeleteConfirmation.find(".j-icon").removeClass("d-hide");
		this.$_settingsDeleteConfirmation.find(".j-loader").addClass("d-hide");

		var methodName = this.data.handler + "OnDelete";
		if ($.type(this[methodName]) === "function") {
			this[methodName](data);
		}
	};

	/**
	 * Sets submit events
	 *
	 * @private
     */
	c.Panel.prototype._setSettingsSubmit = function() {
		this.$_settingsSubmit.find(".j-label").text(this.data.submit.label);
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
		if ($.validator(this.$panel.find(".j-panel-form")).validate() === false) {
			return false;
		}

		this.$_settingsSubmit.find(".j-icon").addClass("d-hide");
		this.$_settingsSubmit.find(".j-loader").removeClass("d-hide");
	};

	/**
	 * Submit AJAX success callback function
	 *
	 * @param {Object} [data] Data from server
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsSubmitSuccess = function (data) {
		this.$_settingsSubmit.find(".j-icon").removeClass("d-hide");
		this.$_settingsSubmit.find(".j-loader").addClass("d-hide");

		if ($.type(data.errors) === "array" && data.errors.length === 0) {
			$.panel({
				action: this.data.submit.content
			});
		} else {
			$.validator(this.$panel.find(".j-panel-form")).showErrors(data.errors);
		}
	};

}(window.jQuery, window.Core);