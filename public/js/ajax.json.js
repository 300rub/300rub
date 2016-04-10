!function ($, c) {
	"use strict";

	/**
	 * Creates a new AjaxJson object
	 *
	 * @class
	 *
	 * @param {String}   [action]       Action
	 * @param {Object}   [fields]       Data fields
	 * @param {Function} [onBeforeSend] BeforeSend handler
	 * @param {Function} [onSuccess]    Success handler
	 * @param {Function} [onError]      Error handler
	 */
	c.AjaxJson = function (action, fields, onBeforeSend, onSuccess, onError) {
		this.action = action;
		this.fields = fields;
		this.onBeforeSend = onBeforeSend;
		this.onSuccess = onSuccess;
		this.onError = onError;

		this.send();
	};

	/**
	  * AjaxJson prototype
	  */
	c.AjaxJson.prototype = {
		/**
		 * Constructor
		 *
		 * @var {window.Core.AjaxJson}
		 */
		constructor: c.AjaxJson,

		/**
		 * Sends AJAX Request
		 *
		 * @returns {c.AjaxJson}
		 */
		send: function () {
			$.ajax({
				url: this._getUrl(),
				data: this._getData(),
				contentType: "application/json",
				accepts: "application/json",
				dataType: "json",
				global: false,
				cache: false,
				traditional: true,
				type: "POST",
				beforeSend: this.onBeforeSend,
				success: this.onSuccess,
				error: $.proxy(this._onError, this)
			});

			return this;
		},

		/**
		 * AJAX error callback function
		 *
		 * @param {jqXHR}  [jqXHR]       jQuery XMLHttpRequest
		 * @param {String} [textStatus]  Text status
		 * @param {String} [errorThrown] Error thrown
		 *
		 * @private
		 */
		_onError: function (jqXHR, textStatus, errorThrown) {
			if (jqXHR.responseJSON !== undefined && jqXHR.responseJSON.message !== undefined) {
				alert(jqXHR.responseJSON.message);
			}
			this.onError(jqXHR, textStatus, errorThrown);
		},

		/**
		 * Gets URL
		 *
		 * @private
		 *
		 * @returns {String}
		 */
		_getUrl: function () {
			return "/ajax/";
		},

		/**
		 * Gets data
		 *
		 * @private
		 *
		 * @returns {{action: *, token: *, fields: *}}
		 */
		_getData: function () {
			return JSON.stringify({
				action: this.action,
				fields: this.fields,
				language: c.language
			});
		}
	};

	/**
	 * Adds AjaxJson to jquery
	 *
	 * @param {String}   [action]       Action
	 * @param {Object}   [fields]       Data fields
	 * @param {Function} [onBeforeSend] BeforeSend handler
	 * @param {Function} [onSuccess]    Success handler
	 * @param {Function} [onError]      Error handler
	 *
	 * @returns {Window.Core.AjaxJson}
	 */
	$.ajaxJson = function (action, fields, onBeforeSend, onSuccess, onError) {
		return new c.AjaxJson(action, fields, onBeforeSend, onSuccess, onError);
	};

	/**
	 * AjaxJson constructor
	 *
	 * @constructor
	 */
	$.ajaxJson.Constructor = c.AjaxJson;
}(window.jQuery, window.Core);