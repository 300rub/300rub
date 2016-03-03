!function ($, c) {
	"use strict";

	/**
	 * Object for working with forms
	 *
	 * @param {Object}      [fields]     Form fields
	 * @param {HTMLElement} [$container] Container
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
		 * @param {Object} [params] Field's params
		 *
         * @private
         */
		_field: function (params) {
			var $object = this.$container.find(params.name.nameToClass());
			$object
				.attr("name", params.name)
				.attr("data-rules", params.rules)
				.val(params.value);
		},

		/**
		 * Sets checkbox
		 *
		 * @param {Object} [params] Field's params
		 *
		 * @private
		 */
		_checkbox: function (params) {

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