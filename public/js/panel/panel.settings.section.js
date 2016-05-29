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

		var $seoTitle = $container.find(".j-form-seo-title");
		var $seoContainer = $container.find(".j-form-seo-container");
		if (
			$seoContainer.find(".j-seoModel__title").val() === ""
			&& $seoContainer.find(".j-seoModel__keywords").val() === ""
			&& $seoContainer.find(".j-seoModel__description").val() === ""
		) {
			$seoContainer.addClass("j-hide");
			$seoTitle.find(".j-up").removeClass("j-hide");
		} else {
			$seoTitle.find(".j-down").removeClass("j-hide");
		}

		$seoTitle.on("click", function() {
			if ($seoContainer.hasClass("j-hide")) {
				$seoTitle.find(".j-up").addClass("j-hide");
				$seoTitle.find(".j-down").removeClass("j-hide");
				$seoContainer.removeClass("j-hide");
			} else {
				$seoTitle.find(".j-up").removeClass("j-hide");
				$seoTitle.find(".j-down").addClass("j-hide");
				$seoContainer.addClass("j-hide");
			}
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