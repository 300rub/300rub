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

			this.show();
		},

		close: function () {
			this.$html.remove();
			this.$overlay.remove();
	
			return false;
		},

		show: function() {
			$.ajaxJson(this.controller, false, $.proxy(this.onShowSuccess, this), $.proxy(this.onShowError, this));
		},

		onShowSuccess: function(data) {
			this.$html.find(".j-header").text(data.title).css("display", "block");
			this.$html.find(".j-footer").css("display", "block");
		},

		onShowError: function(jqXHR, textStatus, errorThrown) {

		}
	};

	$.window = function(controller) {
		return new c.Window(controller);
	};
}(window.jQuery, window.Core);