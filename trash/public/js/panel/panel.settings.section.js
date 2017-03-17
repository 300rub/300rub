!function ($, c) {
	"use strict";

	/**
	 * Panel section settings handler
	 */
	c.Panel.prototype.settingsSection = function() {
		var $container = c.$templates.find(".j-panel-settings-section-container").clone();
		$container.appendTo(this.$container);

		$.each(this.data.forms, function(i, item) {
			switch (item.name) {
				case "isMain":
					if (parseInt(item.value) === 1) {
						$container.find(".j-is-main-container").addClass("d-hide");
					}

					break;
				default:
					break;
			}
		});

		$.form(this.data.forms, $container);

		this
			._settingsSectionSetNameAndUrl($container)
			._settingsSectionSetWidthEvent($container)
			._settingsSectionSetSeo($container);

		this.settingsInit();
	};

	/**
	 * Sets name and url
	 *
	 * @param {Object} $container
	 *
	 * @private
	 *
	 * @returns {c.Panel}
     */
	c.Panel.prototype._settingsSectionSetNameAndUrl = function($container) {
		var $name = $container.find(".j-seoModel__name");
		var $url = $container.find(".j-seoModel__url");
		var urlVal;

		$name.on("keyup", function () {
			$url.val($(this).transliteration());
		});

		$url.on("keyup", function (event) {
			if ($.isServiceEventKeyCode(event)) {
				return true;
			}

			urlVal = $(this).transliteration();
			if ($(this).val() !== urlVal) {
				$(this).val(urlVal);
			}
		});

		return this;
	};

	/**
	 * Sets event on width field
	 *
	 * @param {Object} $container
	 *
	 * @returns {c.Panel}
	 *
	 * @private
     */
	c.Panel.prototype._settingsSectionSetWidthEvent = function($container) {
		var t = this;
		var $widthField = $container.find(".j-t__width");
		var $widthSuffix = $container.find(".j-width-suffix");
		t._settingsSectionSetWidth($widthField, $widthSuffix, $widthField.val());

		$widthField.on("keydown", function (event) {
			if ($.isServiceEventKeyCode(event)) {
				return true;
			}

			if (
				(event.keyCode < 48 || event.keyCode > 57)
				&& (event.keyCode < 96 || event.keyCode > 105 )
			) {
				event.preventDefault();
			}
		});

		$widthField.on("keyup", function () {
			t._settingsSectionSetWidth($widthField, $widthSuffix, $(this).val());
		});

		return this;
	};

	/**
	 * Sets width
	 *
	 * @param {Object} [$widthField]
	 * @param {Object} [$widthSuffix]
	 * @param {int}    [width]
	 *
	 * @private
	 *
	 * @returns {c.Panel}
     */
	c.Panel.prototype._settingsSectionSetWidth = function($widthField, $widthSuffix, width) {
		width = parseInt($widthField.val()) || 0;

		if (width < 0) {
			$widthField.val("");
		} else if (width > 2500) {
			$widthField.val(2500);
		}

		if (width <= 100) {
			$widthSuffix.text("%");
		} else {
			$widthSuffix.text("px");
		}

		return this;
	};

	/**
	 * Sets Seo block
	 *
	 * @param $container
	 *
	 * @private
	 *
	 * @returns {c.Panel}
	 */
	c.Panel.prototype._settingsSectionSetSeo = function($container) {
		var $seoTitle = $container.find(".j-form-seo-title");
		var $seoContainer = $container.find(".j-form-seo-container");
		if (
			$seoContainer.find(".j-seoModel__title").val() === ""
			&& $seoContainer.find(".j-seoModel__keywords").val() === ""
			&& $seoContainer.find(".j-seoModel__description").val() === ""
		) {
			$seoContainer.addClass("d-hide");
			$seoTitle.find(".j-up").removeClass("d-hide");
		} else {
			$seoTitle.find(".j-down").removeClass("d-hide");
		}

		$seoTitle.on("click", function() {
			if ($seoContainer.hasClass("d-hide")) {
				$seoTitle.find(".j-up").addClass("d-hide");
				$seoTitle.find(".j-down").removeClass("d-hide");
				$seoContainer.removeClass("d-hide");
			} else {
				$seoTitle.find(".j-up").removeClass("d-hide");
				$seoTitle.find(".j-down").addClass("d-hide");
				$seoContainer.addClass("d-hide");
			}
		});

		return this;
	};

	/**
	 * Event after deleting
	 *
	 * @param {Object} [data]
     */
	c.Panel.prototype.settingsSectionOnDelete = function(data) {
		if (!!data.result === true) {
			if (parseInt(this.id) === c.sectionId || c.sectionId === 0) {
				location.href = "/" + c.language + "/";
			} else {
				$.panel({
					action: this.data.delete.content
				});
			}
		} else {
			// error
		}
	};
}(window.jQuery, window.Core);