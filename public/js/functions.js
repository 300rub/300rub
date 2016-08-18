!function ($) {

	/**
	 * Gets data from form
	 *
	 * @returns {Object}
     */
	$.fn.serializeObject = function() {
		var o = {};
		var a = this.serializeArray();
		$.each(a, function(i, v) {
			o[v.name] = v.value || '';
		});
		return o;
	};

	/**
	 * Removes class by mask
	 *
	 * @param {String} [mask] Mask. For example: "group-of-names-*"
	 */
	$.fn.removeClassByMask = function (mask) {
		return this.removeClass(function (index, cls) {
			var re = mask.replace(/\*/g, '\\S+');
			return (cls.match(new RegExp('\\b' + re + '', 'g')) || []).join(' ');
		});
	};

	/**
	 * Force numeric
	 *
	 * @returns {Object}
	 *
	 * @constructor
     */
	$.fn.forceNumericOnly = function() {
		return this.each(function() {
			$(this).keydown(function(e) {
				var key = e.charCode || e.keyCode || 0;
				return (
					key == 8
					|| key == 9
					|| key == 46
					|| (key >= 37 && key <= 40)
					|| (key >= 48 && key <= 57)
					|| (key >= 96 && key <= 105)
				);
			})
		})
	};

	/**
	 * Converts name to class
	 *
	 * @param {Boolean} [withoutDot] Without dot
	 *
	 * @returns {String}
     */
	String.prototype.nameToClass = function(withoutDot) {
		var prefix = ".";
		if (withoutDot === true) {
			prefix = "";
		}

		return prefix + "j-" + this.replace(".", "__");
	};

	/**
	 * Converts the string into transliteration
	 *
	 * @returns {String}
     */
	$.fn.transliteration = function () {
		var values = {
			"А": "a",
			"а": "a",
			"Б": "b",
			"б": "b",
			"В": "v",
			"в": "v",
			"Г": "g",
			"г": "g",
			"Д": "d",
			"д": "d",
			"Е": "e",
			"е": "e",
			"Ё": "yo",
			"ё": "yo",
			"Ж": "zh",
			"ж": "zh",
			"З": "z",
			"з": "z",
			"И": "i",
			"и": "i",
			"Й": "y",
			"й": "y",
			"К": "k",
			"к": "k",
			"Л": "l",
			"л": "l",
			"М": "m",
			"м": "m",
			"Н": "n",
			"н": "n",
			"О": "o",
			"о": "o",
			"П": "p",
			"п": "p",
			"Р": "r",
			"р": "r",
			"С": "s",
			"с": "s",
			"Т": "t",
			"т": "t",
			"У": "u",
			"у": "u",
			"Ф": "f",
			"ф": "f",
			"Х": "kh",
			"х": "kh",
			"Ц": "ts",
			"ц": "ts",
			"Ч": "ch",
			"ч": "ch",
			"Ш": "sh",
			"ш": "sh",
			"Щ": "sch",
			"щ": "sch",
			"Ъ": "",
			"ъ": "",
			"Ы": "y",
			"ы": "y",
			"Ь": "",
			"ь": "",
			"Э": "e",
			"э": "e",
			"Ю": "yu",
			"ю": "yu",
			"Я": "ya",
			"я": "ya",
			" ": "-",
			"_": "-"
		};

		var valuesString = "";
		var val;
		for (val in values) {
			valuesString += val;
		}

		return this.val()
			.replace(
				new RegExp("[" + valuesString + "]", "g"),
				function (symbol) {
					return symbol in values ? values[symbol] : "";
				}
			)
			.replace(/[^a-zA-Z0-9_-]/g, "")
			.toLowerCase();
	};

	/**
	 * Checks Service Event Key Code
	 *
	 * @returns {boolean}
	 */
	$.isServiceEventKeyCode = function(event) {
		return (
			event.keyCode == 46
			|| event.keyCode == 8
			|| event.keyCode == 9
			|| event.keyCode == 27
			|| (event.keyCode == 65 && event.ctrlKey === true)
			|| (event.keyCode >= 35 && event.keyCode <= 39)
		);
	}

}(window.jQuery);