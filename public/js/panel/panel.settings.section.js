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

		this.settingsInit();
	};

}(window.jQuery, window.Core);