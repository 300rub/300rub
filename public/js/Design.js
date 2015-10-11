function Design(id, type, title, values) {

	/**
	 * @type {Design}
	 */
	var t = this;

	this.id = id;
	this.title = title;
	this.type = type;
	this.values = values;
	this.editor = null;
	this.object = null;

	this.get = function () {
		t.editor = $templates.find(".design-" + t.type + "-editor").clone();
		t.editor.attr("data-id", t.id);
		t.editor.find(".design-editor-title").text(t.title);
		t.object = $(".design-" + t.type + "-" + t.id);

		if (t.type === "text") {
			t.setText();
		}
		if (t.type === "block") {
			t.setVerticalSlider("name1", 0, "margin-top", -50, 200, "px", ["margin-right", "margin-bottom", "margin-left"]);
			t.setVerticalSlider("name2", 0, "margin-right", -50, 200, "px");
			t.setVerticalSlider("name3", 0, "margin-bottom", -50, 200, "px");
			t.setVerticalSlider("name4", 0, "margin-left", -50, 200, "px");
			t.setVerticalSlider("name5", 0, "padding-top", 0, 200, "px", ["padding-right", "padding-bottom", "padding-left"]);
			t.setVerticalSlider("name6", 0, "padding-right", 0, 200, "px");
			t.setVerticalSlider("name7", 0, "padding-bottom", 0, 200, "px");
			t.setVerticalSlider("name8", 0, "padding-left", 0, 200, "px");
			t.setColor("name9", "", "background-color");
			t.setColor("name9", "", "background");
			t.setGradientDirection("name10", 0);
			t.setColor("name13", "", "border-top-color");
			t.setColor("name15", "", "border-right-color");
			t.setColor("name15", "", "border-bottom-color");
			t.setColor("name15", "", "border-left-color");
			t.setVerticalSlider("name11", 0, "border-top-width", 0, 20, "px", ["border-right-width", "border-bottom-width", "border-left-width"]);
			t.setVerticalSlider("name16", 0, "border-right-width", 0, 20, "px");
			t.setVerticalSlider("name19", 0, "border-bottom-width", 0, 20, "px");
			t.setVerticalSlider("name20", 0, "border-left-width", 0, 20, "px");
			t.setVerticalSlider("name12", 0, "border-top-left-radius", 0, 100, "px", ["border-top-right-radius", "border-bottom-right-radius", "border-bottom-left-radius"]);
			t.setVerticalSlider("name17", 0, "border-top-right-radius", 0, 100, "px");
			t.setVerticalSlider("name21", 0, "border-bottom-right-radius", 0, 100, "px");
			t.setVerticalSlider("name22", 0, "border-bottom-left-radius", 0, 100, "px");
			t.setSelector("name14", 0, "border-top-style", "", ["border-right-style", "border-bottom-style", "border-left-style"]);
			t.setSelector("name23", 0, "border-right-style", "");
			t.setSelector("name24", 0, "border-bottom-style", "");
			t.setSelector("name25", 0, "border-left-style", "");
			t.editor.find(".design-background-reset").bind("click", t.backgroundReset);
		}

		t.editor.find(".design-reset").bind("click", t.reset);

		return t.editor;
	};

	this.setText = function() {
		t.setVerticalSlider(t.values.size.name, t.values.size.value, "font-size", 6, 200, "px");
		t.setVerticalSlider(
			t.values.letter_spacing.name,
			t.values.letter_spacing.value,
			"letter-spacing",
			-10,
			40,
			"px"
		);
		t.setVerticalSlider(
			t.values.line_height.name,
			t.values.line_height.value,
			"line-height",
			10,
			300,
			"%"
		);
		t.setFont(t.values.family.name, t.values.family.value);
		t.setColor(t.values.color.name, t.values.color.value, "color");
		t.setCheckbox(t.values.is_bold.name, t.values.is_bold.value, "font-weight", "bold", "normal");
		t.setCheckbox(t.values.is_italic.name, t.values.is_italic.value, "font-style", "italic", "normal");
		t.setRadio(t.values.align.name, t.values.align.value, "text-align");
		t.setRadio(t.values.transform.name, t.values.transform.value, "text-transform");
		t.setRadio(t.values.decoration.name, t.values.decoration.value, "text-decoration");
	};

	this.reset = function () {
		if (t.type === "text") {
			t.resetVerticalSlider(t.values.size.value, "font-size", "px");
			t.resetVerticalSlider(t.values.letter_spacing.value, "letter-spacing", "px");
			t.resetVerticalSlider(t.values.line_height.value, "line-height", "%");
			t.resetFont(t.values.family.value);
			t.resetColor(t.values.color.value, "color");
			t.resetCkeckbox(t.values.is_bold.value, "font-weight", "bold", "normal");
			t.resetCkeckbox(t.values.is_italic.value, "font-style", "italic", "normal");
			t.resetRadio(t.values.align.value, "text-align");
			t.resetRadio(t.values.transform.value, "text-transform");
			t.resetRadio(t.values.decoration, "text-decoration");
		}
		if (t.type === "block") {
			t.resetVerticalSlider(0, "margin-top", "px");
			t.resetVerticalSlider(0, "margin-right", "px");
			t.resetVerticalSlider(0, "margin-bottom", "px");
			t.resetVerticalSlider(0, "margin-left", "px");
			t.resetVerticalSlider(0, "padding-top", "px");
			t.resetVerticalSlider(0, "padding-right", "px");
			t.resetVerticalSlider(0, "padding-bottom", "px");
			t.resetVerticalSlider(0, "padding-left", "px");
			t.resetColor("", "background-color");
			t.resetColor("", "background");
			t.resetGradientDirection(0);
			t.setColor("name13", "", "border-top-color");
			t.resetColor("", "border-top-color");
			t.resetColor("", "border-right-color");
			t.resetColor("", "border-bottom-color");
			t.resetColor("", "border-left-color");
			t.resetVerticalSlider(0, "border-top-width", "px");
			t.resetVerticalSlider(0, "border-right-width", "px");
			t.resetVerticalSlider(0, "border-bottom-width", "px");
			t.resetVerticalSlider(0, "border-left-width", "px");
			t.resetVerticalSlider(0, "border-top-left-radius", "px");
			t.resetVerticalSlider(0, "border-top-right-radius", "px");
			t.resetVerticalSlider(0, "border-bottom-right-radius", "px");
			t.resetVerticalSlider(0, "border-bottom-left-radius", "px");
			t.resetSelector(0, "border-top-style", "");
			t.resetSelector(0, "border-right-style", "");
			t.resetSelector(0, "border-bottom-style", "");
			t.resetSelector(0, "border-left-style", "");
		}

		return false;
	};

	this.resetVerticalSlider = function (value, cssAttr, cssEnd) {
		var $slider = t.editor.find(".design-" + cssAttr + "-slider");
		$slider.parent().find(".design-slider-value").val(value);
		$slider.slider("value", parseInt(value) * -1);
		t.object.css(cssAttr, value + cssEnd);
	};

	this.checkAndUpdateJointVerticalSliders = function (oldValue, value, cssEnd, joint) {
		var isSame = true;
		$.each(joint, function (key, cssAttr) {
			var oldVal = t.editor.find(".design-" + cssAttr + "-slider").parent().find(".design-slider-value").val();
			if (parseInt(oldValue) != parseInt(oldVal)) {
				isSame = false;
			}
		});

		if (isSame === true) {
			$.each(joint, function (key, cssAttr) {
				var $slider = t.editor.find(".design-" + cssAttr + "-slider");
				var $value = $slider.parent().find(".design-slider-value");
				$slider.slider("value", value * -1);
				$value.val(value);
				t.object.css(cssAttr, value + cssEnd);
			});
		}
	};

	this.setVerticalSlider = function (name, value, cssAttr, min, max, cssEnd, joint) {
		if (typeof joint === 'undefined') {
			joint = [];
		}

		var $slider = t.editor.find(".design-" + cssAttr + "-slider");
		var $value = $slider.parent().find(".design-slider-value");
		var $overlay = $slider.parent().find(".design-slider-overlay");
		$value.attr("name", name);
		$value.val(value);
		var oldValue = value;
		$value.on("focus", function () {
			oldValue = $(this).val();
		});

		$slider.slider({
			orientation: "vertical",
			value: value * -1,
			min: max * -1,
			max: min * -1,
			slide: function (event, ui) {
				$value.val(ui.value * -1);
				t.object.css(cssAttr, ui.value * -1 + cssEnd);
				t.checkAndUpdateJointVerticalSliders(oldValue, ui.value * -1, cssEnd, joint);
				oldValue = ui.value * -1;
			}
		});
		$value.on("keyup", function () {
			var val = parseInt($(this).val());
			$slider.slider("value", val * -1);
			t.object.css(cssAttr, val + cssEnd);
			t.checkAndUpdateJointVerticalSliders(oldValue, val, cssEnd, joint);
			oldValue = val;
		});
		$value.on("click", function () {
			$overlay.css("display", "block");
			$slider.css("display", "block");
		});
		$overlay.on("click", function () {
			$(this).css("display", "none");
			$slider.css("display", "none");
		});
	};

	this.resetFont = function (value) {
		var $selector = t.editor.find(".design-font-selector");
		$selector.val(value);
		var className = $selector.find(':selected').attr('class');
		$selector.removeClassByMask("font-family-*");
		$selector.addClass(className);
		t.object.removeClassByMask("font-*");
		t.object.addClass(className);
	};

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

	this.resetColor = function (value, cssAttr) {
		var $picker = t.editor.find('.color-' + cssAttr + '-picker');
		$picker.val(value);
		$picker.css("background", value);
		$picker.colorPicker("color", value);
		t.object.css(cssAttr, value);
	};

	this.backgroundReset = function () {
		t.object.css("background", "none");
		t.object.css("background-color", "none");
		$(this).parent().parent().find(".color-background-color-picker").val("").css("background", "#fff");
		$(this).parent().parent().find(".color-background-picker").val("").css("background", "#fff");
		return false;
	};

	this.resetGradientDirection = function (value) {
		var $selector = t.editor.find(".design-gradient-direction");
		$selector.val(value);
	};

	this.setGradientDirection = function (name, value) {
		var $selector = t.editor.find(".design-gradient-direction");
		$selector.val(value);
		$selector.attr("name", name);
		$selector.on("change", function () {
			var value = $(this).find(':selected').data('value');
			var from = $selector.parent().find(".color-background-color-picker").val();
			var to = $selector.parent().find(".color-background-picker").val();
			if (from !== "" && to !== "") {
				t.object.css("background", "linear-gradient(" + value + ", " + from + " 0%, " + to + " 100%)");
			}
		});
	};

	this.resetSelector = function (value, cssAttr, cssEnd) {
		var $selector = t.editor.find(".design-" + cssAttr + "-selector");
		$selector.val(value);
		t.object.css(cssAttr, value + cssEnd);
	};

	this.setSelector = function (name, value, cssAttr, cssEnd, joint) {
		if (typeof joint === 'undefined') {
			joint = [];
		}

		var $selector = t.editor.find(".design-" + cssAttr + "-selector");
		$selector.val(value);
		$selector.attr("name", name);
		var oldValue = $selector.val();
		$selector.on("change", function () {
			var v = $(this).val();
			var value = $(this).find(':selected').data('value');
			t.object.css(cssAttr, value + cssEnd);

			var isSame = true;
			$.each(joint, function (key, cssAttr) {
				var oldVal = t.editor.find(".design-" + cssAttr + "-selector").val();
				if (parseInt(oldValue) != parseInt(oldVal)) {
					isSame = false;
				}
			});

			if (isSame === true) {
				$.each(joint, function (key, cssAttr) {
					var $s = t.editor.find(".design-" + cssAttr + "-selector");
					$s.val(v);
					t.object.css(cssAttr, value + cssEnd);
				});
			}

			oldValue = value;
		});
	};

	this.setColor = function (name, value, cssAttr) {
		var $picker = t.editor.find('.color-' + cssAttr + '-picker');
		$picker.val(value);
		$picker.attr("data-css", cssAttr);
		$picker.attr("name", name);
		$picker.attr("data-id", t.id);
		$picker.attr("data-type", t.type);
		var oldValue = $picker.val();
		$picker.colorPicker({
			renderCallback: function ($elm, toggled) {
				var r = this.color.colors.RND.rgb.r;
				var g = this.color.colors.RND.rgb.g;
				var b = this.color.colors.RND.rgb.b;
				var alpha = this.color.colors.alpha;
				var css = $elm.data("css");
				var value;
				var $object = $(".design-" + $elm.data("type") + "-" + $elm.data("id"));
				if (alpha < 1) {
					value = "rgba(" + r + "," + g + "," + b + "," + alpha + ")";
				} else {
					value = "#" + this.color.colors.HEX;
				}

				var direction;
				if (css === "border-top-color") {
					var isSame = true;
					var isEmpty = true;
					var joint = ["border-right-color", "border-bottom-color", "border-left-color"];

					$.each(joint, function (key, cssAttr) {
						var oldVal = $elm.closest(".design-editor").find(".color-" + cssAttr + "-picker").val();
						if (oldValue !== oldVal) {
							isSame = false;
						}
					});

					if (isSame === false) {
						$.each(joint, function (key, cssAttr) {
							var oldVal = $elm.closest(".design-editor").find(".color-" + cssAttr + "-picker").val();
							if (oldVal !== "") {
								isEmpty = false;
							}
						});
					}

					if (isSame === true || isEmpty === true) {
						$.each(joint, function (key, cssAttr) {
							var $s = $elm.closest(".design-editor").find(".color-" + cssAttr + "-picker");
							$s.val(value);
							$s.css("background", value);
							$object.css(cssAttr, value);
						});
					}

					oldValue = value;
				}

				if (css === "background") {
					var valueBg = $elm.closest(".design-editor").find(".color-background-color-picker").val();
					if (valueBg !== "") {
						direction = $elm.parent().find('.design-gradient-direction :selected').data('value');
						$object.css("background", "linear-gradient(" + direction + ", " + valueBg + " 0%, " + value + " 100%)");
					} else {
						$object.css("background-color", value);
					}
				} else if (css === "background-color") {
					var valueBg2 = $elm.closest(".design-editor").find(".color-background-picker").val();
					if (valueBg2 !== "") {
						direction = $elm.parent().find('.design-gradient-direction :selected').data('value');
						$object.css("background", "linear-gradient(" + direction + ", " + value + " 0%, " + valueBg2 + " 100%)");
					} else {
						$object.css("background-color", value);
					}
				} else {
					$object.css(css, value);
				}
			}
		});
	};

	this.resetCkeckbox = function (value, cssAttr, checked, notChecked) {
		var $checkbox = t.editor.find(".design-" + cssAttr + "-checkbox");
		if (parseInt(value) == 1) {
			$checkbox.attr('checked', true);
			t.object.css(cssAttr, checked);
		} else {
			$checkbox.attr('checked', false);
			t.object.css(cssAttr, notChecked);
		}
	};

	this.setCheckbox = function (name, value, cssAttr, checked, notChecked) {
		var $checkbox = t.editor.find(".design-" + cssAttr + "-checkbox");
		t.resetCkeckbox($checkbox, value);
		$checkbox.attr("name", name);
		$checkbox.attr('id', ".design-" + cssAttr + "-checkbox" + t.id);
		$checkbox.parent().find("label").attr('for', ".design-" + cssAttr + "-checkbox" + t.id);
		$checkbox.on("change", function () {
			if ($(this).is(':checked')) {
				t.object.css(cssAttr, checked);
			} else {
				t.object.css(cssAttr, notChecked);
			}
		});
	};

	this.resetRadio = function (value, cssAttr) {
		var $group = t.editor.find(".design-" + cssAttr + "-radio-group");
		var $radio = $group.find('.design-radio[value="' + value + '"]');
		$radio.prop('checked', true);
		t.object.css(cssAttr, $radio.data("value"));
	};

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