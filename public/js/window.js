!function ($, c) {
	"use strict";

	c.Window = function (controller) {
		this.controller = controller;
		this.init();
	};

	c.Window.prototype = {
		$window: null,

		init: function() {
			this.$window = c.$templates.find(".j-window").clone();
			this.$window.appendTo(c.$ajaxWrapper);
		}
	};

	$.window = function(controller) {
		return new c.Window(controller);
	};
}(window.jQuery, window.Core);