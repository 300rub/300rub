!function ($, c) {
	"use strict";

	/**
	 * Object for working with Panel
	 *
	 * @param {Object} [options] Options: action, id...
	 *
	 * @constructor
     */
	c.Panel = function (options) {
		options = $.extend({}, options);

		this.action = null;
		if (options.action !== undefined) {
			this.action = options.action;
		}

		this.id = 0;
		if (options.id !== undefined) {
			this.id = parseInt(options.id);
		}

		this.init();
	};

	/**
	  * Panel prototype
	  */
	c.Panel.prototype = {
		/**
		 * Constructor
		 *
		 * @var {window.Core.Panel}
		 */
		constructor: c.Panel,

		/**
		 * DOM-element of panel
		 *
		 * @type {Object}
		 */
		$panel: null,

		/**
		 * DOM-element of panel's container
		 *
		 * @type {Object}
		 */
		$container: null,

		/**
		 * Data from AJAX request
		 *
		 * @type {Object}
		 */
		data: {},

		/**
		 * Initialization
		 */
		init: function () {
			var $oldPanels = c.$ajaxWrapper.find(".j-panel");
			$oldPanels.removeClass("j-opacity");
			setTimeout($.proxy(function () {
				$oldPanels.remove();
			}, this), 300);

			this.$panel = c.$templates
				.find(".j-panel")
				.clone()
				.addClass(c.admin.activePanelContainer)
				.appendTo(c.$ajaxWrapper);

			this.$container = this.$panel.find(".j-container");
			this.$panel.find(".j-close").on("click", $.proxy(this.close, this));

			setTimeout($.proxy(function () {
				this.$panel.addClass("j-opacity");
			}, this), 100);

			$.ajaxJson(
				this.action,
				{
					id: this.id
				},
				$.proxy(this._onLoadBefore, this),
				$.proxy(this._onLoadSuccess, this),
				$.proxy(this.onError, this)
			);
		},

		/**
		 * Sets container's max-height
		 *
		 * @private
         */
		_setHeight: function() {
			this.$container.css("max-height", $.proxy(function () {
				return $(window).outerHeight()
					- 60
					- this.$panel.find(".j-header").outerHeight()
					- this.$panel.find(".j-footer").outerHeight();
			}, this));
		},

		/**
		 * Close panel click event
		 *
		 * @returns {Boolean}
		 *
         * @private
         */
		close: function() {
			this.$panel.removeClass("j-opacity");
			setTimeout($.proxy(function () {
				this.$panel.remove();
			}, this), 300);

			c.admin.$adminBottomContainer.find(".j-panel-open").removeClass("j-panel-open-active");
			c.admin.activePanelContainer = "";
			return false;
		},

		/**
		 * Load AJAX before callback function
		 *
		 * @private
		 */
		_onLoadBefore: function () {
			this.$container.find(".j-loader").removeClass("j-hide");
		},

		/**
		 * Load AJAX success callback function
		 *
		 * @param {Object} [data] Data from server
		 *
         * @private
         */
		_onLoadSuccess: function (data) {
			this.$container.find(".j-loader").addClass("j-hide");

			this.data = data;

			this.setBack();
			this.$panel.find(".j-title").text(this.data.title);
			this.$panel.find(".j-description").text(this.data.description);
			this.$panel.find(".j-header").css("display", "block");
			this.$panel.find(".j-footer").css("display", "block");
			
			this[this.data.handler]();

			this._setHeight();
			$(window).resize($.proxy(function () {
				this._setHeight();
			}, this));
		},

		/**
		 * Sets back link
		 *
		 * @returns {c.Panel}
		 *
         * @private
         */
		setBack: function() {
			if (this.data.back !== undefined) {
				this.$panel.find(".j-back")
					.removeClass("j-hide")
					.on("click", $.proxy(function() {
						$.panel({
							action: this.data.back
						});
						return false;
					}, this));
			}

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
		onError: function (jqXHR, textStatus, errorThrown) {
			this.$container.find(".j-loader").addClass("j-hide");
		}
	};

	/**
	 * Adds Panel to jquery
	 *
	 * @param {Object} [options] Options: action, id...
	 *
	 * @returns {Window.Core.Panel}
     */
	$.panel = function (options) {
		return new c.Panel(options);
	};

	/**
	 * Panel constructor
	 *
	 * @constructor
	 */
	$.panel.Constructor = c.Panel;
}(window.jQuery, window.Core);