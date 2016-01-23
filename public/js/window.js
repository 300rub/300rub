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

			this.$window.find(".j-_close").on("click", $.proxy(this._close, this));
			this.$overlay.on("click", $.proxy(this._close, this));

			$.ajaxJson(
				this.action,
				{},
				$.proxy(this._onLoadBefore, this),
				$.proxy(this._onLoadSuccess, this),
				$.proxy(this._onError, this)
			);
		},

		_close: function () {
			this.$window.remove();
			this.$overlay.remove();

			return false;
		},

		_onLoadBefore: function () {

		},

		_onLoadSuccess: function (data) {
			this.data = data;

			this.$window.find(".j-header").text(data.title).css("display", "block");
			this.$window.find(".j-footer").css("display", "block");
			this.$window.find(".j-submit").on("click", $.proxy(this._submit, this));

			this[this.handler]();
		},

		_onError: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
		},

		_submit: function () {
			$.ajaxJson(
				this.data.action,
				this.$window.find(".j-window-form").serializeObject(),
				$.proxy(this._onSendBefore, this),
				$.proxy(this._onSendSuccess, this),
				$.proxy(this._onError, this)
			);

			return false;
		},

		_onSendBefore: function () {
			if ($.validator(this.$window.find(".j-window-form")).validate() === false) {
				return false;
			}
		},

		_onSendSuccess: function (data) {
			if (!$.isEmptyObject(data.errors)) {
				console.log(data.errors);
				$.validator(this.$window.find(".j-window-form")).showErrors(data.errors);
				return false;
			}

			if (data.reload === true) {
				location.reload();
			}

			this._close();
		}
	};

	$.window = function (action, handler) {
		return new c.Window(action, handler);
	};
}(window.jQuery, window.Core);