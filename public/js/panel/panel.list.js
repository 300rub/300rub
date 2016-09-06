!function ($, c) {
	"use strict";

	/**
	 * Panel list handler
	 */
	c.Panel.prototype.list = function() {
		this
			._setListDisplayBlock()
			._setList();
	};

	/**
	 * Sets display block container
	 *
	 * @returns {c.Panel}
	 *
	 * @private
     */
	c.Panel.prototype._setListDisplayBlock = function() {
		if (this.data.isDisplayFromPage === undefined) {
			return this;
		}

		var $container = c.$templates.find(".j-panel-list-display-block-container").clone();

		if (!!this.data.isDisplayFromPage === true) {
			$container.find(".j-link-all")
				.removeClass("d-hide")
				.on("click", $.proxy(function() {
					$.panel({
						action: this.action,
						id: this.id,
						isDisplayFromPage: true
					});

					return false;
				}, this));
			$container.find(".j-label-page").removeClass("d-hide");
		} else {
			$container.find(".j-link-page")
				.removeClass("d-hide")
				.on("click", $.proxy(function() {
					$.panel({
						action: this.action,
						id: this.id,
						isDisplayFromPage: false
					});

					return false;
				}, this));
			$container.find(".j-label-all").removeClass("d-hide");
		}

		$container.appendTo(this.$panel.find(".j-header"));

		return this;
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
		var $itemTemplate = c.$templates.find(".j-panel-list-item").clone();
		var itemContent = this.data.item;
		var id = 0;

		if (this.data.design !== undefined) {
			$itemTemplate.find(".j-design").css("display", "block");
		}

		if (this.data.settings !== undefined) {
			$itemTemplate.find(".j-settings").css("display", "block");
		}

		if (this.data.add !== undefined) {
			var $add = c.$templates.find(".j-panel-list-add").clone();
			$add.on(
				"click",
				{
					content: this.data.add.action,
					id: 0
				},
				this._onSettingsClick
			);
			$add.find(".j-label").text(this.data.add.label);
			$add.appendTo(this.$panel.find(".j-footer"));
		}

		$.each(this.data.list, $.proxy(function (i, item) {
			$clone = $itemTemplate.clone();

			if (item.icon !== undefined) {
				$clone.find(".j-label .j-icon").addClass(item.icon);
			} else if (this.data.icon !== undefined) {
				$clone.find(".j-label .j-icon").addClass(this.data.icon);
			}

			$clone.find(".j-label .j-text").text(item.label);

			if (item.content !== undefined) {
				itemContent = item.content;
			}
			if (item.id !== undefined) {
				id = item.id;
			}
			$clone.on(
				"click",
				{
					isParent: this.data.isParent,
					content: itemContent,
					id: id,
					windowCssClass: this.data.windowCssClass
				},
				this._onItemClick
			);

			if (this.data.design !== undefined) {
				$clone
					.find(".j-design")
					.on(
						"click",
						{
							content: this.data.design,
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
							content: this.data.settings,
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
							content: this.data.add.content
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
			$.panel({
				action: event.data.content,
				id: event.data.id
			});
		} else {
			$.window({
				action: event.data.content,
				id: event.data.id,
				cssClass:  event.data.windowCssClass
			});
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
		$.panel({
			action: event.data.content,
			id: event.data.id
		});
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
		$.panel({
			action: event.data.content,
			id: event.data.id
		});
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
		$.panel({
			action: event.data.content
		});
		return false;
	};
}(window.jQuery, window.Core);