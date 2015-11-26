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

			this.window.$html.find(".j-close").on("click", $.proxy(this.close, this));
			this.window.$overlay.on("click", $.proxy(this.close, this));
		},

		close: function () {
			return this.window.close();
		}
	};

	$.windowLogin = function(controller) {
		return new w.WindowLogin(controller);
	};
}(window.jQuery, window.Window);