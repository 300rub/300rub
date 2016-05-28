!function ($, c) {
	"use strict";

	/**
	 * Panel section settings handler
	 */
	c.Panel.prototype.settingsSection = function() {
		var $container = c.$templates.find(".j-panel-settings-section-container").clone();
		$container.appendTo(this.$container);

		$.form(this.data.forms, $container);

		$container.find(".j-seoModel__name").on("keyup", function () {
			$container.find(".j-seoModel__url").val($(this).transliteration());
		});

		$container.find(".j-seoModel__url").on("keyup", function () {
			$(this).val($(this).transliteration());
		});

		var t = this;
		var $widthField = $container.find(".j-t__width");
		var $widthSuffix = $container.find(".j-width-suffix");
		t.settingsSectionSetWidth($widthField, $widthSuffix, $widthField.val());
		$widthField.on("keyup", function () {
			t.settingsSectionSetWidth($widthField, $widthSuffix, $(this).val());
		});

		this.settingsInit();
	};

	/**
	 * Sets width
	 *
	 * @param {Object} [$widthField]
	 * @param {Object} [$widthSuffix]
	 * @param {int}    [width]
	 *
	 * @returns {c.Panel}
     */
	c.Panel.prototype.settingsSectionSetWidth = function($widthField, $widthSuffix, width) {
		width = parseInt($widthField.val()) || 0;

		if (width < 0) {
			width = 0;
		} else if (width > 2500) {
			width = 2500;
		}

		if (width <= 100) {
			$widthSuffix.text("%");
		} else {
			$widthSuffix.text("px");
		}

		$widthField.val(width === 0 ? "" : width);

		return this;
	};
}(window.jQuery, window.Core);