!function ($, c) {
	"use strict";

	/**
	 * Panel payment handler
	 */
	c.Panel.prototype.payment = function() {
		var $container = c.$templates.find(".j-panel-payment-container").clone();
		$container.appendTo(this.$container);
	};
}(window.jQuery, window.Core);