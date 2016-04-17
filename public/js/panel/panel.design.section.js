!function ($, c) {
	"use strict";

	/**
	 * Panel design section handler
	 */
	c.Panel.prototype.designSection = function() {
		if ($.type(this.data.design) !== "array") {
			return false;
		}

		$.each(this.data.design, $.proxy(function(i, block) {
			$.each(block.forms, $.proxy(function(j, form) {
				this.$container.append($.design(form.id, form.type, form.values));
			}, this));
		}, this));

	};
}(window.jQuery, window.Core);