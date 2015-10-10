function Design (id, type, title, values) {

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
			t.setVerticalSlider("name1", 20, "font-size", 6, 200, "px");
			t.setVerticalSlider("name2", 0, "letter-spacing", -10, 40, "px");
			t.setVerticalSlider("name3", 100, "line-height", 10, 300, "%");
			t.setFont("name4", 0);
			t.setColor("name5", "#000000", "color");
			t.setCheckbox("name6", 0, "font-weight", "bold", "normal");
			t.setCheckbox("name7", 0, "font-style", "italic", "normal");
			t.setRadio("name8", 0, "text-align");
			t.setRadio("name9", 0, "text-transform");
			t.setRadio("name0", 0, "text-decoration");
		}

		t.editor.find(".design-reset").bind("click", t.reset);

		return t.editor;
	};

	this.reset = function() {
		if (t.type === "text") {
			t.resetVerticalSlider(20, "font-size", "px");
			t.resetVerticalSlider(0, "letter-spacing", "px");
			t.resetVerticalSlider(100, "line-height", "%");
			t.resetFont(0);
			t.resetColor("#000000", "color");
			t.resetCkeckbox(0, "font-weight", "bold", "normal");
			t.resetCkeckbox(0, "font-style", "italic", "normal");
			t.resetRadio(0, "text-align");
			t.resetRadio(0, "text-transform");
			t.resetRadio(0, "text-decoration");
		}

		return false;
	};

	this.resetVerticalSlider = function(value, cssAttr, cssEnd) {
		var $slider = t.editor.find(".design-" + cssAttr + "-slider");
		$slider.parent().find(".design-slider-value").val(value);
		$slider.slider("value", parseInt(value) * -1);
		t.object.css(cssAttr, value + cssEnd);
	};

	this.setVerticalSlider = function(name, value, cssAttr, min, max, cssEnd) {
		var $slider = t.editor.find(".design-" + cssAttr + "-slider");
		var $value = $slider.parent().find(".design-slider-value");
		var $overlay = $slider.parent().find(".design-slider-overlay");
		$value.attr("name", name);
		$value.val(value);
		$slider.slider({
			orientation: "vertical",
			value: value * -1,
			min: max * -1,
			max: min * -1,
			slide: function (event, ui) {
				$value.val(ui.value * -1);
				t.object.css(cssAttr, ui.value * -1 + cssEnd);
			}
		});
		$value.on("keyup", function() {
			var val = parseInt($(this).val());
			$slider.slider("value", val * -1);
			t.object.css(cssAttr, val + cssEnd);
		});
		$value.on("click", function() {
			$overlay.css("display", "block");
			$slider.css("display", "block");
		});
		$overlay.on("click", function() {
			$(this).css("display", "none");
			$slider.css("display", "none");
		});
	};

	this.resetFont = function(value) {
		var $selector = t.editor.find(".design-font-selector");
		$selector.val(value);
		var className = $selector.find(':selected').attr('class');
		$selector.removeClassByMask("font-family-*");
		$selector.addClass(className);
		t.object.removeClassByMask("font-*");
		t.object.addClass(className);
	};

	this.setFont = function(name, value) {
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

	this.resetColor = function(value, cssAttr) {
		var $picker = t.editor.find('.color-' + cssAttr + '-picker');
		$picker.val(value);
		$picker.colorPicker("color", value);
		t.object.css(cssAttr, value);
	};

	this.setColor = function(name, value, cssAttr) {
		var $picker = t.editor.find('.color-' + cssAttr + '-picker');
		$picker.val(value);
		$picker.attr("name", name);
		$picker.colorPicker({
			renderCallback: function($elm, toggled) {
				var id = $elm.closest(".design-text-editor").data("id");
				var r = this.color.colors.RND.rgb.r;
				var g = this.color.colors.RND.rgb.g;
				var b = this.color.colors.RND.rgb.b;
				var alpha = this.color.colors.alpha;
				t.object.css(cssAttr, "rgba(" + r + "," + g + "," + b + "," + alpha + ")");
			}
		});
	};

	this.resetCkeckbox = function(value, cssAttr, checked, notChecked) {
		var $checkbox = t.editor.find(".design-" + cssAttr + "-checkbox");
		if (parseInt(value) == 1) {
			$checkbox.attr('checked', true);
			t.object.css(cssAttr, checked);
		} else {
			$checkbox.attr('checked', false);
			t.object.css(cssAttr, notChecked);
		}
	};

	this.setCheckbox = function(name, value, cssAttr, checked, notChecked) {
		var $checkbox = t.editor.find(".design-" + cssAttr + "-checkbox");
		t.resetCkeckbox($checkbox, value);
		$checkbox.attr("name", name);
		$checkbox.attr('id', ".design-" + cssAttr + "-checkbox" + t.id);
		$checkbox.parent().find("label").attr('for', ".design-" + cssAttr + "-checkbox" + t.id);
		$checkbox.on("change", function() {
			if ($(this).is(':checked')) {
				t.object.css(cssAttr, checked);
			} else {
				t.object.css(cssAttr, notChecked);
			}
		});
	};

	this.resetRadio = function(value, cssAttr) {
		var $group = t.editor.find(".design-" + cssAttr + "-radio-group");
		var $radio = $group.find('.design-radio[value="' + value + '"]');
		$radio.prop('checked', true);
		t.object.css(cssAttr, $radio.data("value"));
	};

	this.setRadio = function(name, value, cssAttr) {
		var $group = t.editor.find(".design-" + cssAttr + "-radio-group");
		$group.find(".design-radio").each(function(){
			$(this).attr("name", name);
			var id = name + "-" + $(this).attr("value");
			$(this).attr("id", id);
			$(this).parent().find(".design-button-label").attr("for", id);
			if (parseInt($(this).attr("value")) == parseInt(value)) {
				$(this).attr("checked", true);
			}
		});
		$group.find("input[type=radio][name=" + name + "]").on("change", function() {
			t.object.css(cssAttr, $(this).data("value"));
		});
	};
}