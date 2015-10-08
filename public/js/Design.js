function Design (type, id) {

	/**
	 * @type {Design}
	 */
	var t = this;

	this.type = type;
	this.id = id;
	this.editor = null;
	this.object = null;

	this.get = function () {
		t.editor = $templates.find(".design-" + t.type + "-editor").clone();
		t.editor.attr("data-id", t.id);
		t.object = $(".design-" + t.type + "-" + t.id);

		t.setSize(20);
		t.setFont(3);
		t.setColor("#3A236A");
		t.setLetterSpacing(0);
		t.setLineHeight(100);
		t.setIsBold(0);
		t.setIsItalic(0);

		return t.editor;
	};

	this.setSize = function(value) {
		t.editor.find(".size-result").text(value);
		t.editor.find(".size-value").val(value);
		t.editor.find(".size-slider").slider({
			value: value,
			min: 6,
			max: 200,
			slide: function (event, ui) {
				$(this).parent().find(".size-result").text(ui.value);
				$(this).parent().find(".size-value").val(ui.value);
				t.object.css("font-size", ui.value + "px");
			}
		});
	};

	this.setFont = function(value) {
		var $selector = t.editor.find(".font-selector");
		$selector.val(value);
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

	this.setColor = function(value) {
		var $picker = t.editor.find('.color-pick');
		$picker.val(value);
		$picker.colorPicker({
			renderCallback: function($elm, toggled) {
				t.object.css("color", $picker.val());
			}
		});
	};

	this.setLetterSpacing = function(value) {
		t.editor.find(".letter-spacing-result").text(value);
		t.editor.find(".letter-spacing-value").val(value);
		t.editor.find(".letter-spacing-slider").slider({
			value: value,
			min: -10,
			max: 40,
			slide: function (event, ui) {
				$(this).parent().find(".letter-spacing-result").text(ui.value);
				$(this).parent().find(".letter-spacing-value").val(ui.value);
				t.object.css("letter-spacing", ui.value + "px");
			}
		});
	};

	this.setLineHeight = function(value) {
		t.editor.find(".line-height-result").text(value);
		t.editor.find(".line-height-value").val(value);
		t.editor.find(".line-height-slider").slider({
			value: value,
			min: 10,
			max: 300,
			slide: function (event, ui) {
				$(this).parent().find(".line-height-result").text(ui.value);
				$(this).parent().find(".line-height-value").val(ui.value);
				t.object.css("line-height", parseInt(ui.value) / 100);
			}
		});
	};

	this.setIsBold = function(value) {
		var $checkbox = t.editor.find('.is-bold');
		if (parseInt(value) == 1) {
			$checkbox.attr('checked', true);
		}
		$checkbox.attr('id', "is-bold-" + t.id);
		$checkbox.parent().find("label").attr('for', "is-bold-" + t.id);
		$checkbox.on("change", function() {
			if ($(this).is(':checked')) {
				t.object.css("font-weight", "bold");
			} else {
				t.object.css("font-weight", "normal");
			}
		});
	};

	this.setIsItalic = function(value) {
		var $checkbox = t.editor.find('.is-italic');
		if (parseInt(value) == 1) {
			$checkbox.attr('checked', true);
		}
		$checkbox.attr('id', "is-italic-" + t.id);
		$checkbox.parent().find("label").attr('for', "is-italic-" + t.id);
		$checkbox.on("change", function() {
			if ($(this).is(':checked')) {
				t.object.css("font-style", "italic");
			} else {
				t.object.css("font-style", "normal");
			}
		});
	};
}