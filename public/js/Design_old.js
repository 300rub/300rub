function Design(id, type, values) {

	/**
	 * @type {Design}
	 */
	var t = this;

	this.id = id;
	this.type = type;
	this.values = values;
	this.editor = null;
	this.object = null;
	this.style = "";
	this.class = "";

	this.resetObject = function() {
		t.object.attr("class", t.class).attr("style", t.style);
	};

	this.get = function () {
		t.editor = $templates.find(".design-" + t.type + "-editor").clone();
		t.editor.attr("data-id", t.id);
		t.object = $(".design-" + t.type + "-" + t.id);
		t.style = t.object.attr("style");
		t.class = t.object.attr("class");

		if (t.type === "text") {
			t.setText();
		}
		if (t.type === "block") {
			t.setBlock();
		}

		return t.editor;
	};

	this.setText = function () {
		t.setSpinner(t.values.size.name, t.values.size.value, "font-size", 4, "px");
		t.setSpinner(t.values.letter_spacing.name, t.values.letter_spacing.value, "letter-spacing", -10, "px");
		t.setSpinner(t.values.line_height.name, t.values.line_height.value, "line-height", 10, "%");
		t.setColorPicker(t.values.color.name, t.values.color.value, "color");
		t.setFont(t.values.family.name, t.values.family.value);
		t.setCheckbox(t.values.is_bold.name, t.values.is_bold.value, "font-weight", "bold", "normal");
		t.setCheckbox(t.values.is_italic.name, t.values.is_italic.value, "font-style", "italic", "normal");
		t.setRadio(t.values.align.name, t.values.align.value, "text-align");
		t.setRadio(t.values.transform.name, t.values.transform.value, "text-transform");
		t.setRadio(t.values.decoration.name, t.values.decoration.value, "text-decoration");
	};

	this.setBlock = function () {
		t.setAngles(
			"margin",
			t.values.margin_top.name,
			t.values.margin_right.name,
			t.values.margin_bottom.name,
			t.values.margin_left.name,
			t.values.margin_top.value,
			t.values.margin_right.value,
			t.values.margin_bottom.value,
			t.values.margin_left.value
		);

		t.setAngles(
			"padding",
			t.values.padding_top.name,
			t.values.padding_right.name,
			t.values.padding_bottom.name,
			t.values.padding_left.name,
			t.values.padding_top.value,
			t.values.padding_right.value,
			t.values.padding_bottom.value,
			t.values.padding_left.value
		);

		t.setAngles(
			"border-radius",
			t.values.border_top_left_radius.name,
			t.values.border_top_right_radius.name,
			t.values.border_bottom_right_radius.name,
			t.values.border_bottom_left_radius.name,
			t.values.border_top_left_radius.value,
			t.values.border_top_right_radius.value,
			t.values.border_bottom_right_radius.value,
			t.values.border_bottom_left_radius.value
		);

		t.setAngles(
			"border",
			t.values.border_top_width.name,
			t.values.border_right_width.name,
			t.values.border_bottom_width.name,
			t.values.border_left_width.name,
			t.values.border_top_width.value,
			t.values.border_right_width.value,
			t.values.border_bottom_width.value,
			t.values.border_left_width.value
		);

		t.setRadio(t.values.border_style.name, t.values.border_style.value, "border-style");

		t.setColorPicker(t.values.border_color.name, t.values.border_color.value, "border-color");
		t.setBackgroundColor(
			t.values.background_color_from.name,
			t.values.background_color_to.name,
			t.values.background_color_from.value,
			t.values.background_color_to.value,
			t.values.gradient_direction.name,
			t.values.gradient_direction.value
		);
	};

	/**
	 * @param {string} nameFrom
	 * @param {string} nameTo
	 * @param {string} valueFrom
	 * @param {string} valueTo
	 * @param {string} nameDirection
	 * @param {int}    valueDirection
	 */
	this.setBackgroundColor = function (nameFrom, nameTo, valueFrom, valueTo, nameDirection, valueDirection) {
		var $from = t.editor.find(".color-background-from-picker");
		$from.attr("name", nameFrom).val(valueFrom);
		var $to = t.editor.find(".color-background-to-picker");
		$to.attr("name", nameTo).val(valueTo);

		var value = "to right";
		var $direction = t.editor.find(".design-direction-radio-group");
		$direction.find(".design-radio").each(function () {
			$(this).attr("name", nameDirection);
			var id = nameDirection + "-" + $(this).attr("value");
			$(this).attr("id", id);
			$(this).parent().find(".design-button-label").attr("for", id);
			if (parseInt($(this).attr("value")) == parseInt(valueDirection)) {
				$(this).attr("checked", true);
			}
		});
		$direction.find("input[type=radio]").on("change", function () {
			value = $(this).data("value");
			if ($from.val() != "" && $to.val() != "") {
				t.object.css("background", "linear-gradient(" + value + ", " + $from.val() + " 0%, " + $to.val() + " 100%)");
			}
		});

		t.editor.find(".design-background-clear").on("click", function () {
			$from.val("");
			$from.parent().find("img").css("background", "none");
			$to.val("");
			$to.parent().find("img").css("background", "none");
			$direction.find('.design-radio[value="0"]').prop('checked', true);
			t.object.css("background", "none");
			value = "to right";

			return false;
		});

		$from.colorpicker({
			alpha: true,
			colorFormat: 'RGBA',
			buttonColorize: true,
			showOn: 'both',
			buttonImage: '/img/common/color_picker_btn.png',
			buttonImageOnly: true,
			position: {
				my: 'center',
				at: 'center',
				of: window
			},
			parts: 'full',
			select: function (event, color) {
				if ($to.val() == "") {
					t.object.css("background", color.formatted);
				} else {
					t.object.css("background", "linear-gradient(" + value + ", " + color.formatted + " 0%, " + $to.val() + " 100%)");
				}
			}
		});

		$to.colorpicker({
			alpha: true,
			colorFormat: 'RGBA',
			buttonColorize: true,
			showOn: 'both',
			buttonImage: '/img/common/color_picker_btn.png',
			buttonImageOnly: true,
			position: {
				my: 'center',
				at: 'center',
				of: window
			},
			parts: 'full',
			select: function (event, color) {
				if ($from.val() == "") {
					t.object.css("background", color.formatted);
				} else {
					t.object.css("background", "linear-gradient(" + value + ", " + $from.val() + " 0%, " + color.formatted + " 100%)");
				}
			}
		});
	};

	/**
	 * @param {string} name
	 * @param {string} value
	 * @param {string} cssAttr
	 */
	this.setColorPicker = function (name, value, cssAttr) {
		t.editor.find(".color-" + cssAttr + "-picker")
			.attr("name", name)
			.val(value)
			.colorpicker({
				alpha: true,
				colorFormat: 'RGBA',
				buttonColorize: true,
				showOn: 'both',
				buttonImage: '/img/common/color_picker_btn.png',
				buttonImageOnly: true,
				position: {
					my: 'center',
					at: 'center',
					of: window
				},
				parts: 'full',
				select: function (event, color) {
					t.object.css(cssAttr, color.formatted);
				}
			});
	};

	/**
	 * @param {string} type
	 * @param {string} topLeftName
	 * @param {string} topRightName
	 * @param {string} bottomRightName
	 * @param {string} bottomLeftName
	 * @param {int}    topLeftValue
	 * @param {int}    topRightValue
	 * @param {int}    bottomRightValue
	 * @param {int}    bottomLeftValue
	 */
	this.setAngles = function (type,
							   topLeftName,
							   topRightName,
							   bottomRightName,
							   bottomLeftName,
							   topLeftValue,
							   topRightValue,
							   bottomRightValue,
							   bottomLeftValue) {
		var $container = t.editor.find(".design-angles-" + type + "-container");
		var $topLeft = $container.find(".design-angles-top-left input");
		$topLeft.attr("name", topLeftName).val(topLeftValue);
		var $topRight = $container.find(".design-angles-top-right input");
		$topRight.attr("name", topRightName).val(topRightValue);
		var $bottomRight = $container.find(".design-angles-bottom-right input");
		$bottomRight.attr("name", bottomRightName).val(bottomRightValue);
		var $bottomLeft = $container.find(".design-angles-bottom-left input");
		$bottomLeft.attr("name", bottomLeftName).val(bottomLeftValue);
		var $result = $container.find("." + $container.data("result"));
		var min = $container.data("min");
		var $join = $container.find("label input");

		$topLeft.forceNumericOnly();
		$topRight.forceNumericOnly();
		$bottomRight.forceNumericOnly();
		$bottomLeft.forceNumericOnly();

		$result
			.css($topLeft.data("css"), $topLeft.val() + "px")
			.css($topRight.data("css"), $topRight.val() + "px")
			.css($bottomRight.data("css"), $bottomRight.val() + "px")
			.css($bottomLeft.data("css"), $bottomLeft.val() + "px");

		if (
			$topLeft.val() == $topRight.val()
			&& $topLeft.val() == $bottomRight.val()
			&& $topLeft.val() == $bottomLeft.val()) {
			$join.attr('checked', true);
		}
		$join.on("change", function () {
			if ($(this).is(':checked')) {
				var value = $topLeft.val();
				t.object.css($topLeft.data("css"), value + "px");
				$result.css($topLeft.data("css"), value + "px");
				$topRight.val(value);
				t.object.css($topRight.data("css"), value + "px");
				$result.css($topRight.data("css"), value + "px");
				$bottomRight.val(value);
				t.object.css($bottomRight.data("css"), value + "px");
				$result.css($bottomRight.data("css"), value + "px");
				$bottomLeft.val(value);
				t.object.css($bottomLeft.data("css"), value + "px");
				$result.css($bottomLeft.data("css"), value + "px");
			}
		});

		t.setAngleSpinner($topLeft, $result, min, $join, $topRight, $bottomRight, $bottomLeft);
		t.setAngleSpinner($topRight, $result, min, $join, $topLeft, $bottomRight, $bottomLeft);
		t.setAngleSpinner($bottomRight, $result, min, $join, $topLeft, $topRight, $bottomLeft);
		t.setAngleSpinner($bottomLeft, $result, min, $join, $topLeft, $topRight, $bottomRight);
	};

	/**
	 * @param {HTMLElement} $obj
	 * @param {int}         $result
	 * @param {int}         min
	 * @param {HTMLElement} $join
	 * @param {HTMLElement} $obj2
	 * @param {HTMLElement} $obj3
	 * @param {HTMLElement} $obj4
	 */
	this.setAngleSpinner = function ($obj, $result, min, $join, $obj2, $obj3, $obj4) {
		$obj.spinner({
			min: min,
			spin: function (event, ui) {
				t.setAngleSpinnerValue($obj, $result, ui.value);
				if ($join.is(':checked')) {
					$obj2.val(ui.value);
					$obj3.val(ui.value);
					$obj4.val(ui.value);
					t.setAngleSpinnerValue($obj2, $result, ui.value);
					t.setAngleSpinnerValue($obj3, $result, ui.value);
					t.setAngleSpinnerValue($obj4, $result, ui.value);
				}
			}
		}).on("keyup", function () {
			var value = $(this).val();
			t.setAngleSpinnerValue($obj, $result, value);
			if ($join.is(':checked')) {
				$obj2.val(value);
				$obj3.val(value);
				$obj4.val(value);
				t.setAngleSpinnerValue($obj2, $result, value);
				t.setAngleSpinnerValue($obj3, $result, value);
				t.setAngleSpinnerValue($obj4, $result, value);
			}
		});
	};

	/**
	 * @param {HTMLElement} $obj
	 * @param {HTMLElement} $result
	 * @param {int}         value
	 */
	this.setAngleSpinnerValue = function ($obj, $result, value) {
		t.object.css($obj.data("css"), value + "px");
		$result.css($obj.data("css"), value + "px");
	};

	/**
	 * @param {string} name
	 * @param {int}    value
	 * @param {string} cssAttr
	 * @param {int}    min
	 * @param {string} cssEnd
	 */
	this.setSpinner = function (name, value, cssAttr, min, cssEnd) {
		var $spinner = t.editor.find(".design-spinner-" + cssAttr + "-container");
		$spinner.find("label").attr('for', "design-spinner-" + cssAttr + t.id);
		$spinner.find("span").text(cssEnd);

		$spinner.find("input")
			.val(value)
			.attr("name", name)
			.attr("id", "design-spinner-" + cssAttr + t.id)
			.forceNumericOnly()
			.spinner({
				min: min,
				spin: function (event, ui) {
					t.object.css(cssAttr, ui.value + cssEnd);
				}
			})
			.on("keyup", function () {
				t.object.css(cssAttr, $(this).val() + cssEnd);
			});
	};

	/**
	 * @param {string} name
	 * @param {int}    value
	 */
	this.setFont = function (name, value) {
		var $selector = t.editor.find(".design-font-selector");
		$selector.val(value);
		$selector.attr("name", name);
		$selector.removeClassByMask("font-family-*");
		var className = $selector.find(':selected').attr('class');
		$selector.addClass(className);
		$selector.on("change", function () {
			className = $(this).find(':selected').attr('class');
			$(this).removeClassByMask("font-family-*");
			$(this).addClass(className);
			t.object.removeClassByMask("font-*");
			t.object.addClass(className);
		});
	};

	/**
	 * @param {string} name
	 * @param {int}    value
	 * @param {string} cssAttr
	 * @param {string} checked
	 * @param {string} notChecked
	 */
	this.setCheckbox = function (name, value, cssAttr, checked, notChecked) {
		var $checkbox = t.editor.find(".design-" + cssAttr + "-checkbox");
		var $value = $checkbox.parent().find(".design-checkbox-value");
		if (parseInt(value) == 1) {
			$checkbox.attr('checked', true);
		} else {
			$checkbox.attr('checked', false);
		}
		$value.val(value);
		$value.attr("name", name);
		$checkbox.attr('id', "design-" + cssAttr + "-checkbox" + t.id);
		$checkbox.parent().find("label").attr('for', "design-" + cssAttr + "-checkbox" + t.id);
		$checkbox.on("change", function () {
			if ($(this).is(':checked')) {
				t.object.css(cssAttr, checked);
				$value.val(1);
			} else {
				t.object.css(cssAttr, notChecked);
				$value.val(0);
			}
		});
	};

	/**
	 * @param {string} name
	 * @param {int}    value
	 * @param {string} cssAttr
	 */
	this.setRadio = function (name, value, cssAttr) {
		var $group = t.editor.find(".design-" + cssAttr + "-radio-group");
		$group.find(".design-radio").each(function () {
			$(this).attr("name", name);
			var id = name + "-" + $(this).attr("value");
			$(this).attr("id", id);
			$(this).parent().find(".design-button-label").attr("for", id);
			if (parseInt($(this).attr("value")) == parseInt(value)) {
				$(this).attr("checked", true);
			}
		});
		$group.find("input[type=radio]").on("change", function () {
			t.object.css(cssAttr, $(this).data("value"));
		});
	};
}