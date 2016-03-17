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
}