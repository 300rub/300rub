!function ($, c) {
	"use strict";

	/**
	 * Panel blocks handler
	 */
	c.Panel.prototype.list = function() {
		this._setList();
	};

	/**
	 * Sets list
	 *
	 * @returns {c.Panel}
	 *
	 * @private
	 */
	c.Panel.prototype._setList =  function() {
		var $clone, designContent, designHandler, settingsContent, settingsHandler;
		var $itemTemplate = $templates.find(".j-panel-list-item").clone();
		var itemContent = this.data.item.content;
		var itemHandler = this.data.item.handler;
		var id = 0;

		if (this.data.design !== undefined) {
			$itemTemplate.find(".j-design").css("display", "block");
			designContent = this.data.design.content;
			designHandler = this.data.design.handler;
		}

		if (this.data.settings !== undefined) {
			$itemTemplate.find(".j-settings").css("display", "block");
			settingsContent = this.data.design.content;
			settingsHandler = this.data.design.handler;
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
				itemContent = item.content;
			}
			if (item.handler !== undefined) {
				itemHandler = item.handler;
			}
			if (item.id !== undefined) {
				id = item.id;
			}
			$clone.on("click", $.proxy(this._onItemClick(itemContent, itemHandler, id), this));

			if (this.data.design !== undefined) {
				$clone
					.find(".j-design")
					.on("click", $.proxy(this._onDesignClick(designContent, designHandler, id), this));
			}

			if (this.data.settings !== undefined) {
				$clone
					.find(".j-settings")
					.on("click", $.proxy(this._onSettingsClick(settingsContent, settingsHandler, id), this));
			}

			if (this.data.add !== undefined) {
				$clone
					.find(".j-footer .j-add")
					.text(this.data.add.label)
					.on("click", $.proxy(this._onAddClick(this.data.add.content, this.data.add.handler), this));
			}

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
		if (this.data.isParent !== undefined) {
			$.panel(content, handler, id);
		} else {
			$.window(content, handler, id);
		}

		return false;
	};

	/**
	 * Panel item design click event
	 *
	 * @var {String} [content] Content
	 * @var {String} [handler] Handler
	 * @var {int}    [id]      ID
	 *
	 * @private
	 */
	c.Panel.prototype._onDesignClick = function(content, handler, id) {
		$.panel(content, handler, id);
		return false;
	};

	/**
	 * Panel item settings click event
	 *
	 * @var {String} [content] Content
	 * @var {String} [handler] Handler
	 * @var {int}    [id]      ID
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsClick = function(content, handler, id) {
		$.panel(content, handler, id);
		return false;
	};

	/**
	 * Panel add click event
	 *
	 * @var {String} [content] Content
	 * @var {String} [handler] Handler
	 *
	 * @private
	 */
	c.Panel.prototype._onAddClick = function(content, handler) {
		$.panel(content, handler);
		return false;
	};
}(window.jQuery, window.Core);