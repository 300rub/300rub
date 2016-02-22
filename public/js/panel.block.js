!function ($, c) {
	"use strict";

	/**
	 * Panel blocks handler
	 */
	c.Panel.prototype.block = function() {
		if (this.data.list != undefined) {
			this._setList();
		}


		var $template = c.$templates.find(".j-window-login-container").clone();
		$template.appendTo(this.$window.find(".j-container"));

		$.form(this.data.forms, ".j-window-login-container");
	};

	/**
	 * Sets list
	 *
	 * @returns {c.Panel}
	 *
	 * @private
	 */
	c.Panel.prototype._setList =  function() {
		var $clone;
		var $itemTemplate = $templates.find(".j-panel-item").clone();
		var content = this.data.content;
		var handler = this.data.handler;
		var id = 0;

		if (this.data.design !== undefined) {
			$itemTemplate.find(".j-design").css("display", "block");
			this.$panel.attr("data-design", this.data.design);
		}

		if (this.data.settings !== undefined) {
			$itemTemplate.find(".j-settings").css("display", "block");
			this.$panel.attr("data-settings", this.data.settings);
		}

		if (this.data.content !== undefined) {
			this.$panel.attr("data-content", this.data.content);
		}

		$.each(this.data.list.items, $.proxy(function (i, item) {
			$clone = $itemTemplate.clone();

			if (item.icon !== undefined) {
				$clone.find(".j-icon").css("display", "block").addClass("l-icon-" + item.icon);
			} else if (this.data.icon !== undefined) {
				$clone.find(".j-icon").css("display", "block").addClass("l-icon-" + this.data.icon);
			}

			$clone.find(".j-label").text(item.label);

			if (item.content !== undefined) {
				content = item.content;
			}
			if (item.handler !== undefined) {
				handler = item.handler;
			}
			if (item.id !== undefined) {
				id = item.id;
			}
			$clone.on("click", $.proxy(this._onItemClick(content, handler, id), this));

			$clone.appendTo(this.$panel.find(".j-container"));
		}, this));

		return this;
	};

	/**
	 * Panel item click event
	 *
	 * @var {String} [content] Content
	 * @var {String} [handler] Handler
	 * @var {int}    [id]      ID
	 *
	 * @private
	 */
	c.Panel.prototype._onItemClick = function(content, handler, id) {
		/**
		 * @var {bool} this.data.isParent
		 */
		if (this.data.isParent !== undefined) {
			$.panel(content, handler, id);
		} else {
			$.window(content, handler, id);
		}

		return false;
	};
}(window.jQuery, window.Core);