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
		 * @type {Object}
		 */
		$templates: null,

		/**
		 * DOM-element of ajax wrapper
		 *
		 * @type {Object}
		 */
		$ajaxWrapper: null,

		/**
		 * Language alias
		 *
		 * @type {String}
		 */
		language: '',

		/**
		 * Section ID
		 *
		 * @type {Integer}
		 */
		sectionId: 0
	}
}(window);