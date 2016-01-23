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
		data: {},

		init: function () {
			this.$overlay = c.$templates.find(".j-overlay").clone().appendTo(c.$ajaxWrapper);
			this.$window = c.$templates.find(".j-window").clone().appendTo(c.$ajaxWrapper);

			this.$window.find(".j-close").on("click", $.proxy(this.close, this));
			this.$overlay.on("click", $.proxy(this.close, this));

			$.ajaxJson(
				this.action,
				{},
				$.proxy(this.onLoadBefore, this),
				$.proxy(this.onLoadSuccess, this),
				$.proxy(this.onError, this)
			);
		},

		close: function () {
			this.$window.remove();
			this.$overlay.remove();

			return false;
		},

		onLoadBefore: function () {

		},

		onLoadSuccess: function (data) {
			this.data = data;

			this.$window.find(".j-header").text(data.title).css("display", "block");
			this.$window.find(".j-footer").css("display", "block");
			this.$window.find(".j-submit").on("click", $.proxy(this.submit, this));

			this[this.handler]();
		},

		onError: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
		},

		submit: function () {
			$.ajaxJson(
				this.data.action,
				this.$window.find(".j-window-form").serializeObject(),
				$.proxy(this.onSendBefore, this),
				$.proxy(this.onSendSuccess, this),
				$.proxy(this.onError, this)
			);

			return false;
		},

		onSendBefore: function () {
			if ($.validator(this.$window.find(".j-window-form")).validate() === false) {
				return false;
			}
		},

		onSendSuccess: function (data) {
			if (!$.isEmptyObject(data.errors)) {
				console.log(data.errors);
				$.validator(this.$window.find(".j-window-form")).showErrors(data.errors);
				return false;
			}

			this.close();
			location.reload();
		}
	};

	$.window = function (action, handler) {
		return new c.Window(action, handler);
	};
}(window.jQuery, window.Core);