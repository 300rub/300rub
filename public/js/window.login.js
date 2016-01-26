!function ($, c) {
	"use strict";

	/**
	 * Window login handler
	 */
	c.Window.prototype.login = function() {
		var $template = c.$templates.find(".j-window-login-container").clone();
		$template.appendTo(this.$window.find(".j-container"));

		$.form(this.data.forms, ".j-window-login-container");
	};
}(window.jQuery, window.Core);