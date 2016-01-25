!function ($) {
	'use strict';

	/**
	 * Main object for application
	 *
	 * @type {Object}
     */
	$.Core = {
		/**
		 * DOM-element of templates
		 *
		 * @type {HTMLElement}
		 */
		$templates: null,

		/**
		 * DOM-element of ajax wrapper
		 *
		 * @type {HTMLElement}
		 */
		$ajaxWrapper: null,

		/**
		 * Language alias
		 *
		 * @type {String}
		 */
		language: ''
	}
}(window);