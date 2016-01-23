!function ($, c) {
	"use strict";

	c.Panel = function (action, handler) {
		this.action = action;
		this.handler = handler;
		this.init();
	};

	c.Panel.prototype = {
		$panel: null,
		data: {},

		init: function () {
			this.$panel = c.$templates.find(".j-panel").clone().appendTo(c.$ajaxWrapper);
			this.$panel.find(".j-close").on("click", $.proxy(this._close, this));

			$.ajaxJson(
				this.action,
				{},
				$.proxy(this._onLoadBefore, this),
				$.proxy(this._onLoadSuccess, this),
				$.proxy(this._onError, this)
			);
		},

		_close: function() {
			this.$panel.remove();
			return false;
		},

		_onLoadBefore: function () {

		},

		_onLoadSuccess: function (data) {
			this.data = data;

			this.$panel.find(".j-title").text(data.title);
			this.$panel.find(".j-description").text(data.description);
		},

		_onError: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
		}
	};

	$.panel = function (action, handler) {
		return new c.Panel(action, handler);
	};
}(window.jQuery, window.Core);