!function ($, c) {
	"use strict";

	/**
	 * Panel design handler
	 */
	c.Panel.prototype.design = function() {
		if ($.type(this.data.design) !== "array") {
			return false;
		}

		var designs = [];
		$.each(this.data.design, $.proxy(function(i, block) {
			$.each(block.forms, $.proxy(function(j, form) {
				designs.push({
					"title": block.title,
					"design": $.design(form.id, form.type, form.values)
				});
			}, this));
		}, this));

		// Append to container
		$.each(designs, $.proxy(function(i, item) {
			this.$container.append("<div>" + item.title + "</div>");
			this.$container.append(item.design.getEditor());
		}, this));

		// Back events
		this.$panel.find(".j-back").off().on("click", $.proxy(function() {
			$.each(designs, function(i, item) {
				item.design.reset();
			});

			$.panel(this.data.back);

			return false;
		}, this));

		// Close panel events
		this.$panel.find(".j-close").off().on("click", $.proxy(function() {
			$.each(designs, function(i, item) {
				item.design.reset();
			});

			this.close();

			return false;
		}, this));

		// Click on panel buttons
		$("#panel-buttons").find("a").off().on("click", function() {
			$.each(designs, function(i, item) {
				item.design.reset();
			});

			$.panel($(this).data("action"));

			return false;
		});
	};
}(window.jQuery, window.Core);