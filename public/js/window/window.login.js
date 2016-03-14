!function ($, c) {
	"use strict";

	/**
	 * Window login handler
	 */
	c.Window.prototype.login = function() {
		var $container = c.$templates.find(".j-window-login-container").clone();
		$container.appendTo(this.$window.find(".j-container"));

		$.form(this.data.forms, $container);
	};
}(window.jQuery, window.Core);