!function ($, c) {
	"use strict";

	/**
	 * Object for working with forms
	 *
	 * @param {Object}      [fields]     Form fields
	 * @param {Object} [$container] Container
	 *
	 * @constructor
	 */
	c.Form = function (fields, $container) {
		this.fields = fields;
		this.$container = $container;
		this.init();
	};

	/**
	  * Form's prototype
	  */
	c.Form.prototype = {
		/**
		 * Constructor
		 *
		 * @var {Window.Core.Form}
		 */
		constructor: c.Form,

		/**
		 * Unique value for IDs and labels
		 */
		_uniqueValue: Math.floor((Math.random() * 10000) + 1),

		/**
		 * Initialized fields
		 */
		init: function () {
			$.each(this.fields, $.proxy(function(i, params) {
				if (undefined !== this["_" + params.type]) {
					this["_" + params.type](params);
				} else {
					this._field(params);
				}
			}, this));

			$.validator(this.$container);
		},

		/**
		 * Sets field
		 *
		 * @param {Object} [params] Params
		 *
         * @private
         */
		_field: function (params) {
			this.$container.find(params.name.nameToClass())
				.attr("name", params.name)
				.attr("data-rules", this._getRulesAsString(params.rules))
				.val(params.value);
		},

		/**
		 * Gets rules as array
		 *
		 * @param {string} rules
		 *
		 * @returns {string}
		 *
         * @private
         */
		_getRulesAsString: function(rules) {
			var list = [];
			$.each(rules, function(key, value) {
				if ($.isNumeric(key)) {
					list.push(value);
				} else {
					list.push(key + "-" + value);
				}
			});

			return list.join(",");
		},

		/**
		 * Sets checkbox
		 *
		 * @param {Object} [params] Params
		 *
		 * @private
		 */
		_checkbox: function (params) {
			this.$container.find(params.name.nameToClass())
				.attr("name", params.name)
				.attr("checked", parseInt(params.value) === 1);
		},

		/**
		 * Sets select
		 *
		 * @param {Object} [params] Params
		 *
		 * @private
		 */
		_select: function (params) {
			this.$container.find(params.name.nameToClass())
				.attr("name", params.name)
				.val(params.value)
				.change();
		}
	};

	/**
	 * Adds Form to jquery
	 *
	 * @param {Object} [fields]     Form fields
	 * @param {String} [$container] Container
 	 *
	 * @returns {Window.Core.Form}
	 */
	$.form = function (fields, $container) {
		return new c.Form(fields, $container);
	};
}(window.jQuery, window.Core);