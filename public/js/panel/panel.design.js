!function ($, c) {
	"use strict";

	/**
	 * DOM-element of submit
	 *
	 * @type {Object}
	 */
	c.Panel.prototype.$_designSubmit = null;

	/**
	 * Design instances
	 *
	 * @type {Array}
	 */
	c.Panel.prototype._designInstances = [];
	
	/**
	 * Panel design handler
	 */
	c.Panel.prototype.design = function() {
		if ($.type(this.data.design) !== "array") {
			return false;
		}

		this.$_designSubmit = c.$templates.find(".j-panel-submit").clone();

		this
			._setDesignInstances()
			._appendDesignEditors()
			._setDesignBack()
			._setDesignClose()
			._setDesignPanelButtons()
			._setDesignSubmit();
	};

	/**
	 * Sets design instances
	 *
	 * @returns {c.Panel}
	 *
	 * @private
     */
	c.Panel.prototype._setDesignInstances = function() {
		$.each(this.data.design, $.proxy(function(i, block) {
			$.each(block.forms, $.proxy(function(j, form) {
				this._designInstances.push({
					"title": block.title,
					"design": $.design(form.id, form.type, form.values)
				});
			}, this));
		}, this));

		return this;
	};

	/**
	 * Adds editors to container
	 *
	 * @returns {c.Panel}
	 *
	 * @private
     */
	c.Panel.prototype._appendDesignEditors = function() {
		$.each(this._designInstances, $.proxy(function(i, item) {
			this.$container.append("<div>" + item.title + "</div>");
			this.$container.append(item.design.getEditor());
		}, this));

		return this;
	};

	/**
	 * Sets design back link
	 *
	 * @returns {c.Panel}
	 *
	 * @private
     */
	c.Panel.prototype._setDesignBack = function() {
		this.$panel.find(".j-back").off().on("click", $.proxy(function() {
			$.each(this._designInstances, function(i, item) {
				item.design.reset();
			});

			$.panel(this.data.back);

			return false;
		}, this));

		return this;
	};

	/**
	 * Sets design close panel
	 *
	 * @returns {c.Panel}
	 *
	 * @private
     */
	c.Panel.prototype._setDesignClose = function() {
		this.$panel.find(".j-close").off().on("click", $.proxy(function() {
			$.each(this._designInstances, function(i, item) {
				item.design.reset();
			});

			this.close();

			return false;
		}, this));

		return this;
	};

	/**
	 * Sets click on panel buttons
	 *
	 * @returns {c.Panel}
	 *
	 * @private
     */
	c.Panel.prototype._setDesignPanelButtons = function() {
		$("#panel-buttons").find("a").off().on("click", function() {
			$.each(this._designInstances, function(i, item) {
				item.design.reset();
			});

			$.panel($(this).data("action"));

			return false;
		});

		return this;
	};

	/**
	 * Sets submit events
	 *
	 * @returns {c.Panel}
	 *
	 * @private
	 */
	c.Panel.prototype._setDesignSubmit = function() {
		this.$_designSubmit
			.on("click", $.proxy(this._onDesignSubmit, this))
			.appendTo(this.$panel.find(".j-footer"));

		return this;
	};

	/**
	 * Delete click event
	 *
	 * @private
	 */
	c.Panel.prototype._onDesignSubmit = function() {
		$.ajaxJson(
			this.data.submit.action,
			$.extend({}, this.$panel.find(".j-panel-form").serializeObject(), {id: this.id}),
			$.proxy(this._onDesignSubmitBefore, this),
			$.proxy(this._onDesignSubmitSuccess, this),
			$.proxy(this.onError, this)
		);

		return false;
	};

	/**
	 * Submit AJAX before callback function
	 *
	 * @private
	 */
	c.Panel.prototype._onDesignSubmitBefore = function () {
		this.$_designSubmit.find(".j-label").addClass("j-hide");
		this.$_designSubmit.find(".j-loader").removeClass("j-hide");
	};

	/**
	 * Submit AJAX success callback function
	 *
	 * @param {Object} [data] Data from server
	 *
	 * @private
	 */
	c.Panel.prototype._onDesignSubmitSuccess = function (data) {
		this.$_designSubmit.find(".j-label").removeClass("j-hide");
		this.$_designSubmit.find(".j-loader").addClass("j-hide");

		if ($.type(data.errors) === "array" && data.errors.length === 0) {
			$.panel(this.data.submit.content);
		} else {
			$.validator(this.$panel.find(".j-panel-form")).showErrors(data.errors);
		}
	};
}(window.jQuery, window.Core);