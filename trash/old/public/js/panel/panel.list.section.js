!function ($, c) {
	"use strict";

	/**
	 * Panel section list handler
	 */
	c.Panel.prototype.listSection = function() {
		this.list();
		this.$panel.find(".j-description").append($.help("section", "panelDescription"));
	};
}(window.jQuery, window.Core);