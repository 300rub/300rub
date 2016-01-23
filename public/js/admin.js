!function ($, c) {
	"use strict";

	c.Admin = function () {
		this.init();
	};

	c.Admin.prototype = {
		init: function () {
			$("#logout-button").on("click", $.proxy(this._onLogoutButtonClick, this));
			$("#panel-buttons").find("a").on("click", this._onPanelButtonClick);
		},

		_onPanelButtonClick: function () {
			$.panel($(this).data("action"), $(this).data("handler"));
			return false;
		},

		_onLogoutButtonClick: function () {
			$.ajaxJson(
				"user.logout",
				{},
				$.proxy(this._onLogoutBefore, this),
				$.proxy(this._onLogoutSuccess, this),
				$.proxy(this._onError, this)
			);
			return false;
		},

		_onLogoutBefore: function() {

		},

		_onLogoutSuccess: function() {
			location.reload();
		},

		_onError: function() {

		}
	};

	$.admin = function() {
		return new c.Admin();
	};

	$(document).ready(function() {
		$.admin();
	});
}(window.jQuery, window.Core);