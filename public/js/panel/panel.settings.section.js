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

		var width;
		var $widthSuffix = $container.find(".j-width-suffix");
		var $widthField = $container.find(".j-t__width");
		$widthField.on("keyup", function () {
			width = parseInt($(this).val()) || "";
			
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

			$(this).val(width);
		});

		this.settingsInit();
	};

}(window.jQuery, window.Core);