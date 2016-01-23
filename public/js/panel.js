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
		},

		_close: function() {
			this.$panel.remove();
			return false;
		}
	};

	$.panel = function (action, handler) {
		return new c.Panel(action, handler);
	};
}(window.jQuery, window.Core);