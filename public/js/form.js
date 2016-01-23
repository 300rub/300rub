!function ($, c) {
	"use strict";

	/**
	 * Object for working with forms
	 *
	 * @param {Object} fields            Form fields
	 * @param {String} containerSelector Container's selector
	 *
	 * @constructor
	 */
	c.Form = function (fields, containerSelector) {
		this.fields = fields;
		this.containerSelector = containerSelector;
		this.init();
	};

	/**
	  * Form prototype
	  */
	c.Form.prototype = {
		/**
		 * Constructor
		 *
		 * @var {Window.Core.Form}
		 */
		constructor: c.Form,

		/**
		 * DOM-element of container
		 *
		 * @type {HTMLElement}
		 */
		container: null,

		/**
		 * Initialized fields
		 */
		init: function () {
			this.container = c.$ajaxWrapper.find(this.containerSelector);

			$.each(this.fields, $.proxy(function(i, params) {
				if (undefined !== this[params.type]) {
					this[params.type](params);
				} else {
					this.field(params);
				}
			}, this));
		},

		field: function (params) {
			var $object = this.container.find(params.name.nameToClass());
			$object
				.attr("name", params.name)
				.attr("data-rules", params.rules)
				.val(params.value);
		},

		checkbox: function (params) {

		}
	};

	/**
	 * Adds Form to jquery
	 *
	 * @param {Object} fields            Form fields
	 * @param {String} containerSelector Container's selector
 	 *
	 * @returns {Window.Core.Form}
	 */
	$.form = function (fields, containerSelector) {
		return new c.Form(fields, containerSelector);
	};
}(window.jQuery, window.Core);