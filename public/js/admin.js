!function ($, c) {
	"use strict";

	/**
	 * Object for initialising main configuration for admin mode
	 *
	 * @constructor
	 */
	c.Admin = function () {
		this.init();
	};

	/**
	 * Admin's prototype
	 *
	 * @type {Object}
	 */
	c.Admin.prototype = {
		/**
		 * Constructor
		 *
		 * @var {window.Core.Admin}
		 */
		constructor: c.AjaxJson,

		/**
		 * DOM-element of admin bottom container
		 *
		 * @type {Object}
		 */
		$adminBottomContainer: null,

		/**
		 * CSS class of active panel container
		 */
		activePanelContainer: "",

		/**
		 * Initialisation
		 */
		init: function () {
			this.$adminBottomContainer = $("#admin-bottom-container");
			$("#logout-button").on("click", $.proxy(this._onLogoutButtonClick, this));
			this.$adminBottomContainer.find(".j-panel-open").on("click", this._onPanelButtonClick);
		},

		/**
		 * Panel button click event
		 *
		 * @returns {Boolean}
		 *
         * @private
         */
		_onPanelButtonClick: function () {
			c.admin.$adminBottomContainer.find(".j-panel-open").removeClass("j-panel-open-active");
			c.admin.activePanelContainer = $(this).data("container");
			$(this).addClass("j-panel-open-active");
			$.panel({
				action: $(this).data("action")
			});
			return false;
		},

		/**
		 * Logout button click event
		 *
		 * @returns {boolean}
         *
		 * @private
         */
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

		/**
		 * Logout AJAX before callback function
		 *
		 * @private
         */
		_onLogoutBefore: function() {

		},

		/**
		 * Logout AJAX success callback function
		 *
		 * @private
         */
		_onLogoutSuccess: function() {
			location.reload();
		},

		/**
		 * Logout AJAX error callback function
		 *
		 * @private
         */
		_onError: function() {

		}
	};

	/**
	 * Adds Admin to jquery
	 *
	 * @returns {Window.Core.Admin}
	 */
	$.admin = function() {
		return new c.Admin();
	};

	/**
	 * Admin constructor
	 *
	 * @constructor
	 */
	$.admin.Constructor = c.Admin;

	$(document).ready(function() {
		c.admin = $.admin();
	});
}(window.jQuery, window.Core);