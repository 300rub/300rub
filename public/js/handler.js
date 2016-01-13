/*
function setWindowHeight() {
	$(".window .container").css("max-height", parseInt($(document).height()) - 150);
}

$(document).ready(function () {

	jQuery.fn.forceNumericOnly = function () {
		return this.each(function () {
			$(this).keydown(function (e) {
				var key = e.charCode || e.keyCode || 0;
				return (
				key == 8 ||
				key == 9 ||
				key == 46 ||
				(key >= 37 && key <= 40) ||
				(key >= 48 && key <= 57) ||
				(key >= 96 && key <= 105));
			});
		});
	};

	$wrapper = $("#wrapper");
	$ajaxWrapper = $("#ajax-wrapper");
	$templates = $("#templates");
	$loader = $templates.find(".loader");
	$forms = $("#forms");
	$errors = $("#errors");

	setWindowHeight();
	$(window).resize(function () {
		setWindowHeight();
	});

	$("#login-button").on("click", function () {
		(new Window("user/form")).init();
		return false;
	});

	$("#logout-button").on("click", function () {
		$.ajax({
			url: "/ajax/" + LANG + "/user/logout/",
			success: function () {
				window.location.replace("");
			}
		});

		return false;
	});

});
		*/

!function ($, c) {
	"use strict";

	c.Handler = function () {
		this.init();
	};

	c.Handler.prototype = {
		init: function () {
			this._setTemplates();
			this._setAjaxWrapper();
			this._setLanguage(LANG);
			$("#login-button").on("click", this.onLoginButtonClick);
		},

		_setTemplates: function () {
			c.$templates = $('#templates');
		},

		_setAjaxWrapper: function () {
			c.$ajaxWrapper = $('#ajax-wrapper');
		},

		_setLanguage: function (lang) {
			c.language = lang;
		},

		onLoginButtonClick: function () {
			$.window("user.window", "login");
			return false;
		}
	};

	$.handler = function() {
		return new c.Handler();
	};

	$(document).ready(function() {
		$.handler();
	});
}(window.jQuery, window.Core);