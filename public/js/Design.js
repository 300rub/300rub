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
			$(this).removeClassByMask("font-*");
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
}