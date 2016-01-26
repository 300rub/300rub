!function ($, c) {
	"use strict";

	/**
	 * Object for working with form's validation
	 *
	 * @param    {HTMLElement} [$form] DOM-element of form
	 * @property {HTMLElement} [$form] DOM-element of form
	 *
	 * @constructor
	 */
	c.Validator = function ($form) {
		this.$form = $form;
	};

	/**
	  * Validator prototype
	  */
	c.Validator.prototype = {
		/**
		 * Constructor
		 *
		 * @var {window.Core.Validator}
		 */
		constructor: c.Validator,

		/**
		 * Errors
		 *
		 * @var {Object}
		 */
		_errors: {},

		/**
		 * Validates form
		 *
		 * @returns {Boolean}
         */
		validate: function() {
			var methodName, $field, split;
			this._errors = {};

			this.$form.find(".j-validate").each($.proxy(function (i, field) {
				$field = $(field);
				$.each($field.data("rules").split(", "), $.proxy(function (i, rule) {
					split = rule.split("-");
					methodName = "_" + split[0];
					if (this[methodName] !== undefined) {
						if (split[1] === undefined) {
							this[methodName]($field);
						} else {
							this[methodName]($field, split[1]);
						}
					}
				}, this));
			}, this));

			return this.showErrors(this._errors);
		},

		/**
		 * Shows errors
		 *
		 * @param {Object} [errors] Errors
		 *
		 * @returns {Boolean}
         */
		showErrors: function (errors) {
			this.$form.find("div.j-error").remove();

			if ($.isEmptyObject(errors)) {
				return true;
			}

			$.each(errors, $.proxy(function (name, error) {
				this.$form.find(name.nameToClass()).after(c.$templates.find(".j-error-" + error).clone());
			}, this));

			return false;
		},

		/**
		 * Checks for requiring
		 *
		 * @param {HTMLElement} [$field] Field
		 *
         * @private
         */
		_required: function ($field) {
			if ($.trim($field.val()) === "") {
				this._addError($field.attr("name"), "required");
			}
		},

		/**
		 * Checks for max value
		 *
		 * @param {HTMLElement} [$field] Field
		 * @param {Integer}     [max]    Max value
		 *
         * @private
         */
		_max: function ($field, max) {
			if ($.trim($field.val()).length > parseInt(max)) {
				this._addError($field.attr("name"), "max");
			}
		},

		/**
		 * Adds error
		 *
		 * @param {String} [key]   Key
		 * @param {String} [value] Value
		 *
         * @private
         */
		_addError: function (key, value) {
			if (this._errors[key] === undefined) {
				this._errors[key] = value;
			}
		}
	};

	/**
	 * Adds Validator to jquery
	 *
	 * @returns {Window.Core.Validator}
	 */
	$.validator = function ($form) {
		return new c.Validator($form);
	};

	/**
	 * Validator constructor
	 *
	 * @constructor
	 */
	$.validator.Constructor = c.Validator;
}(window.jQuery, window.Core);