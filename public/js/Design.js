function Design (type, id, values) {

	/**
	 * @type {Design}
	 */
	var t = this;

	this.type = type;
	this.id = id;
	this.values = values;
	this.editor = null;
	this.object = null;
	this.objectStyleForReset = "";
	this.objectClassForReset = "";

	this.get = function () {
		t.editor = $templates.find(".design-" + t.type + "-editor").clone();
		t.editor.attr("data-id", t.id);
		t.object = $(".design-" + t.type + "-" + t.id);
		t.objectStyleForReset = t.object.attr("style");
		t.objectClassForReset = t.object.attr("class");

		t.setVerticalSlider("designTextModel__size" + t.id, 20, "font-size", 6, 200, "px");
		t.setVerticalSlider("designTextModel__letter_spacing" + t.id, 0, "letter-spacing", -10, 40, "px");
		t.setVerticalSlider("designTextModel__line_height" + t.id, 100, "line-height", 10, 300, "%");
		t.setFont("designTextModel__family" + t.id, 0);
		t.setColor("designTextModel__color" + t.id, "#000000", "color");
		t.setCheckbox("designTextModel__is_bold" + t.id, 0, "font-weight", "bold", "normal");
		t.setCheckbox("designTextModel__is_italic" + t.id, 0, "font-style", "italic", "normal");
		t.setRadio("designTextModel__align" + t.id, 0, "text-align");
		t.setRadio("designTextModel__transform" + t.id, 0, "text-transform");
		t.setRadio("designTextModel__decoration" + t.id, 0, "text-decoration");

		t.editor.find(".design-reset").bind("click", t.reset);

		return t.editor;
	};

	this.reset = function() {
		t.object.attr("style", t.objectStyleForReset);
		t.object.attr("class", t.objectClassForReset);

		t.resetVerticalSlider(t.editor.find(".design-font-size-slider"), 20);
		t.resetVerticalSlider(t.editor.find(".design-letter-spacing-slider"), 0);
		t.resetVerticalSlider(t.editor.find(".design-line-height-slider"), 100);
		t.resetFont(t.editor.find(".design-font-selector"), 0);
		t.resetColor(t.editor.find('.color-color-picker'), "#000000");
		t.resetCkeckbox(t.editor.find(".design-font-weight-checkbox"), 0);
		t.resetCkeckbox(t.editor.find(".design-font-style-checkbox"), 0);
		t.resetRadio(t.editor.find(".design-text-align-radio-group"), 0);
		t.resetRadio(t.editor.find(".design-text-transform-radio-group"), 0);
		t.resetRadio(t.editor.find(".design-text-decoration-radio-group"), 0);

		return false;
	};

	this.resetVerticalSlider = function($slider, value) {
		var $value = $slider.parent().find(".design-slider-value");
		$slider.slider("value", parseInt(value) * -1);
		$value.val(value);
	};

	this.setVerticalSlider = function(name, value, cssAttr, min, max, cssEnd) {
		var $slider = t.editor.find(".design-" + cssAttr + "-slider");
		var $value = $slider.parent().find(".design-slider-value");
		var $overlay = $slider.parent().find(".design-slider-overlay");
		$value.attr("name", name);
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
		t.resetVerticalSlider($slider, value);
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

	this.setFont = function(name, value) {
		var $selector = t.editor.find(".design-font-selector");
		t.resetFont($selector, value);
		$selector.attr("name", name);
		$selector.on("change", function () {
			className = $(this).find(':selected').attr('class');
			$(this).removeClassByMask("font-family-*");
			$(this).addClass(className);
			t.object.removeClassByMask("font-*");
			t.object.addClass(className);
		});
	};

	this.resetFont = function($selector, value) {
		$selector.val(value);
		var className = $selector.find(':selected').attr('class');
		$selector.removeClassByMask("font-family-*");
		$selector.addClass(className);
	};

	this.resetColor = function($picker, value) {
		$picker.val(value);
		$picker.colorPicker("color", value);
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
				$(".design-text-" + id).css(cssAttr, "rgba(" + r + "," + g + "," + b + "," + alpha + ")");
			}
		});
	};

	this.resetCkeckbox = function($checkbox, value) {
		if (parseInt(value) == 1) {
			$checkbox.attr('checked', true);
		} else {
			$checkbox.attr('checked', false);
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

	this.resetRadio = function($group, value) {
		$group.find('.design-radio[value="' + value + '"]').prop('checked', true);
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