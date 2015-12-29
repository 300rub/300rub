!function ($, c) {
	"use strict";

	c.Window = function (action, handler) {
		this.action = action;
		this.handler = handler;
		this.init();
	};

	c.Window.prototype = {
		$window: null,
		$overlay: null,

		init: function () {
			this.$overlay = c.$templates.find(".j-overlay").clone().appendTo(c.$ajaxWrapper);
			this.$window = c.$templates.find(".j-window").clone().appendTo(c.$ajaxWrapper);

			this.$window.find(".j-close").on("click", $.proxy(this.close, this));
			this.$overlay.on("click", $.proxy(this.close, this));

			$.ajaxJson(
				this.action,
				{},
				this.onBeforeSend,
				this.onSuccess,
				this.onError
			);
		},



		close: function () {
			this.$window.remove();
			this.$overlay.remove();

			return false;
		},

		onBeforeSend: function() {

		},

		onSuccess: function (data) {
			console.log(data);

			this.$window.find(".j-header").text(data.title).css("display", "block");
			this.$window.find(".j-footer").css("display", "block");

			this[this.handler]();
		},

		onError: function (jqXHR, textStatus, errorThrown) {
console.log(jqXHR);
		}
	};

	$.window = function (action, handler) {
		return new c.Window(action, handler);
	};
}(window.jQuery, window.Core);