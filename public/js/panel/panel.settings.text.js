!function ($, c) {
	"use strict";

	/**
	 * Panel section settings handler
	 */
	c.Panel.prototype.settingsText = function() {
		var $container = c.$templates.find(".j-panel-settings-text-container").clone();
		$container.appendTo(this.$container);

		$.form(this.data.forms, $container);

		this.settingsInit();
	};

}(window.jQuery, window.Core);