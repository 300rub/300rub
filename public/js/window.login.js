!function ($, w) {
	"use strict";

	w.WindowLogin = function (controller) {
		this.controller = controller;
		this.init();
	};

	w.WindowLogin.prototype = {
		window: null,

		init: function() {
			this.window = $.window(this.controller);
		}
	};

	$.windowLogin = function(controller) {
		return new w.WindowLogin(controller);
	};
}(window.jQuery, window.Window);