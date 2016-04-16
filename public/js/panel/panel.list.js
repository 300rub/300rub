!function ($, c) {
	"use strict";

	/**
	 * Panel list handler
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
		var $itemTemplate = c.$templates.find(".j-panel-list-item").clone();
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
			settingsContent = this.data.settings.content;
			settingsHandler = this.data.design.handler;
		}

		$.each(this.data.list, $.proxy(function (i, item) {
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
			$clone.on(
				"click",
				{
					isParent: this.data.isParent,
					content: itemContent,
					handler: itemHandler,
					id: id
				},
				this._onItemClick
			);

			if (this.data.design !== undefined) {
				$clone
					.find(".j-design")
					.on(
						"click",
						{
							content: designContent,
							id: id
						},
						this._onDesignClick
					);
			}

			if (this.data.settings !== undefined) {
				$clone
					.find(".j-settings")
					.on(
						"click",
						{
							content: settingsContent,
							id: id
						},
						this._onSettingsClick
					);
			}

			if (this.data.add !== undefined) {
				$clone
					.find(".j-footer .j-add")
					.text(this.data.add.label)
					.on(
						"click",
						{
							content: this.data.add.content,
						},
						this._onAddClick
					);
			}

			$clone.appendTo(this.$container);
		}, this));

		return this;
	};

	/**
	 * Panel item click event
	 *
	 * @var {Object} [event]
	 *
	 * @private
	 */
	c.Panel.prototype._onItemClick = function(event) {
		if (event.data.isParent !== undefined) {
			$.panel(event.data.content, event.data.id);
		} else {
			$.window(event.data.content, event.data.handler, event.data.id);
		}

		return false;
	};

	/**
	 * Panel item design click event
	 *
	 * @var {Object} [event]
	 *
	 * @private
	 */
	c.Panel.prototype._onDesignClick = function(event) {
		$.panel(event.data.content, event.data.id);
		return false;
	};

	/**
	 * Panel item settings click event
	 *
	 * @var {Object} [event]
	 *
	 * @private
	 */
	c.Panel.prototype._onSettingsClick = function(event) {
		$.panel(event.data.content, event.data.id);
		return false;
	};

	/**
	 * Panel add click event
	 *
	 * @var {Object} [event]
	 *
	 * @private
	 */
	c.Panel.prototype._onAddClick = function(event) {
		$.panel(event.data.content);
		return false;
	};
}(window.jQuery, window.Core);