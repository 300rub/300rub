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
			var $object = this.$container.find(params.name.nameToClass());
			var $label = $object.parent().find("label");

			$object
				.attr("name", params.name)
				.attr("data-rules", params.rules)
				.attr("id", $object.attr("id") + this._uniqueValue)
				.val(params.value);

			$label.attr("for", $label.attr("for") + this._uniqueValue);
		},

		/**
		 * Sets textarea
		 *
		 * @param {Object} [params] Params
		 *
		 * @private
		 */
		_textArea: function (params) {
			var $object = this.$container.find(params.name.nameToClass());
			var $label = $object.parent().find("label");

			$object
				.attr("name", params.name)
				.attr("data-rules", params.rules)
				.attr("id", $object.attr("id") + this._uniqueValue)
				.text(params.value);

			$label.attr("for", $label.attr("for") + this._uniqueValue);
		},

		/**
		 * Sets checkbox
		 *
		 * @param {Object} [params] Params
		 *
		 * @private
		 */
		_checkbox: function (params) {
			var $object = this.$container.find(params.name.nameToClass());
			var $label = $object.parent().find("label");

			$object
				.attr("name", params.name)
				.attr("data-rules", params.rules)
				.attr("id", $object.attr("id") + this._uniqueValue)
				.attr("checked", parseInt(params.value) === 1);
			$label.attr("for", $label.attr("for") + this._uniqueValue);
		},

		/**
		 * Sets select
		 *
		 * @param {Object} [params] Params
		 *
		 * @private
		 */
		_select: function (params) {
			var $object = this.$container.find(params.name.nameToClass());
			var $label = $object.parent().find("label");

			$object
				.attr("name", params.name)
				.attr("data-rules", params.rules)
				.attr("id", $object.attr("id") + this._uniqueValue)
				.val(params.value)
				.change();
			$label.attr("for", $label.attr("for") + this._uniqueValue);
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