!function ($, c) {
	"use strict";

	c.AjaxJson = function (controller, data, callbackSuccess, callbackError) {
		this.controller = controller;
		this.data = data;
		this.callbackSuccess = callbackSuccess;
		this.callbackError = callbackError;

		this.send();
	};

	c.AjaxJson.prototype = {
		send: function() {
			$.ajax({
				url: this._getUrl(),
				dataType: 'json',
				data: (this.data !== false) ? this.data : {},
				type: (this.data !== false) ? 'POST' : 'GET',
				success: this.callbackSuccess,
				error: this.callbackError
			});

			return this;
		},

		_getUrl: function() {
			return "/ajax/" + c.language + "/" + this.controller + "/";
		}
	};

	$.ajaxJson = function(controller, data, callbackSuccess, callbackError) {
		return new c.AjaxJson(controller, data, callbackSuccess, callbackError);
	};
}(window.jQuery, window.Core);