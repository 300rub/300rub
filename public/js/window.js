!function ($, c) {
	"use strict";
	
	c.Window = function (controller) {
		this.controller = controller;
		this.init();
	};

	c.Window.prototype = {
		$html: null,
		$overlay: null,

		init: function() {
			this.$overlay = c.$templates.find(".j-overlay").clone().appendTo(c.$ajaxWrapper);
			this.$html = c.$templates.find(".j-window").clone().appendTo(c.$ajaxWrapper);
		},

		close: function () {
			this.$html.remove();
			this.$overlay.remove();
	
			return true;
		}
	};

	$.window = function(controller) {
		return new c.Window(controller);
	};
}(window.jQuery, window.Core);