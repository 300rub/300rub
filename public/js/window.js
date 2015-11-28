!function ($, c) {
	"use strict";
	
	c.Window = function (controller, handler) {
		this.controller = controller;
		this.handler = handler;
		this.init();
	};

	c.Window.prototype = {
		$window: null,
		$overlay: null,

		init: function() {
			this.$overlay = c.$templates.find(".j-overlay").clone().appendTo(c.$ajaxWrapper);
			this.$window = c.$templates.find(".j-window").clone().appendTo(c.$ajaxWrapper);

			this.$window.find(".j-close").on("click", $.proxy(this.close, this));
			this.$overlay.on("click", $.proxy(this.close, this));

			$.ajaxJson(
					this.controller,
					false,
					$.proxy(this.onShowSuccess, this),
					$.proxy(this.onShowError, this)
			);
		},

		close: function () {
			this.$window.remove();
			this.$overlay.remove();
	
			return false;
		},


		onShowSuccess: function(data) {
			this.$window.find(".j-header").text(data.title).css("display", "block");
			this.$window.find(".j-footer").css("display", "block");

			this[this.handler]();
		},

		onShowError: function(jqXHR, textStatus, errorThrown) {

		}
	};

	$.window = function(controller, handler) {
		return new c.Window(controller, handler);
	};
}(window.jQuery, window.Core);