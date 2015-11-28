!function ($, c) {
	"use strict";

	c.Window.prototype.login = function() {
		var $template = c.$templates.find(".j-window-login-container").clone();
		$template.appendTo(this.$window.find(".j-container"));
	};
}(window.jQuery, window.Core);