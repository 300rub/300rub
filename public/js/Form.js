/**
 * Класс для работы с формами
 *
 * @constructor
 *
 * @param {string} name   название формы
 * @param {Object} params параметры
 */
function Form (name, params) {

	/**
	 * Объект класса
	 *
	 * @type {Form}
	 */
	var t = this;

	/**
	 * Название формы
	 *
	 * @type {string}
	 */
	this.name = name;

	/**
	 * Параметры
	 *
	 * @type {Object}
	 */
	this.params = params;

	this.container = "";

	this.object = null;

	/**
	 * Уникальный идентификатор
	 *
	 * @type {number}
	 */
	this.id = Math.floor(Math.random() * 99999);

	/**
	 * Получает DOM-объект формы
	 *
	 * @returns {HTMLElement}
	 */
	this.get = function () {
		t.container = t.name.replace(".", "__");

		t.object = $forms.find(".form-container-" + this.params.type).clone();
		t.object.find("label").text(params.label).attr("for", t.id);
		t.object.addClass(t.container);

		if (t.params.type === "field" || t.params.type === "password") {
			t.setField();
		}
		if (t.params.type === "checkbox") {
			t.setCheckbox();
		}
		if (t.params.type === "select") {
			t.setSelect();
		}
		if (t.params.type === "text") {
			t.setTextarea();
		}
		if (t.params.type === "tinymce") {
			t.id = "tinymce" + t.id;
			t.setTextarea();
		}

		return t.object;
	};

	this.setTextarea = function() {
		var $form = t.object.find("textarea");
		$form.attr("id", t.id);
		$form.attr("name", "Data[" + t.name + "]");
		$form.attr("data-container", t.container);
		$form.text(t.params.value);
	};

	this.setField = function() {
		var $form = t.object.find("input");
		$form.attr("id", t.id);
		$form.attr("name", "Data[" + t.name + "]");
		$form.attr("data-container", t.container);

		$form.val(t.params.value);

		if (params.rules.length != 0) {
			$form.addClass("validate");
			var rules = [];
			var er = /^-?[0-9]+$/;
			$.each(params.rules, function(key, value) {
				if (er.test(key)) {
					key = value;
				}
				rules[rules.length] = key + "-" + value;
			});
			$form.attr("data-rules", rules.join(", "));
		}

		if (t.name === "seoModel.name") {
			$form.on("keyup", function () {
				$(".seoModel__url input").val(t.translit($(this).val()));
			});
		}
	};

	this.setCheckbox = function() {
		var $checkbox = t.object.find("input[type=checkbox]");
		var $hidden = t.object.find("input[type=hidden]");

		$checkbox.attr("id", t.id);
		if (parseInt(t.params.value) == 1) {
			$checkbox.attr('checked', true);
		} else {
			$checkbox.attr('checked', false);
		}

		$hidden.attr("name", "Data[" + t.name + "]");
		$hidden.val(t.params.value);

		$checkbox.on("change", function () {
			if ($(this).is(':checked')) {
				$hidden.val(1);
			} else {
				$hidden.val(0);
			}
		});
	};

	this.setSelect = function() {
		var $select = t.object.find("select");
		$select.attr("id", t.id);
		$select.attr("name", "Data[" + t.name + "]");

		$.each(t.params.values, function (key, value) {
			var $option = $("<option></option>");
			$option.attr("value", key).text(value);
			if (parseInt(key) == parseInt(t.params.value)) {
				$option.attr("selected", true);
			}
			$select.append($option);
		});
	};

	/**
	 * Преобразует строку в транслит
	 *
	 * @param {string} text входящая строка
	 *
	 * @returns {string}
	 */
	this.translit = function (text) {
		var L = {
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
			},
			r = "",
			k;
		for (k in L) r += k;
		r = new RegExp("[" + r + "]", "g");
		k = function (a) {
			return a in L ? L[a] : "";
		};
		return function () {
			return text.replace(r, k).replace(/[^a-zA-Z0-9_-]/g, "").replace(/_+/g, "_");
		};
	};

	this.setTinyMce = function (id) {
		tinymce.init({
			selector: "#" + id,
			menubar: false,
			statusbar: false,
			setup: function (editor) {
				editor.on('change', function () {
					editor.save();
				});
			},
			plugins: "textcolor, link, hr, image, charmap, print, preview, fullscreen, table",
			toolbar1: "newdocument | cut copy paste | undo redo | print preview fullscreen",
			toolbar2: "table | fontselect fontsizeselect formatselect | removeformat | bullist numlist outdent indent | subscript superscript",
			toolbar3: "image | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | link unlink | blockquote charmap hr",
			fontsize_formats: "8px 9px 10px 11px 12px 14px 16px 18px 20px 22px 24px 26px 28px 36px 48px 72px",
			font_formats: "Andale Mono 111=andale mono,times;"+
			"Arial=arial,helvetica,sans-serif;"+
			"Arial Black=arial black,avant garde;"+
			"Book Antiqua=book antiqua,palatino;"+
			"Comic Sans MS=comic sans ms,sans-serif;"+
			"Courier New=courier new,courier;"+
			"Georgia=georgia,palatino;"+
			"Helvetica=helvetica;"+
			"Impact=impact,chicago;"+
			"Symbol=symbol;"+
			"Tahoma=tahoma,arial,helvetica,sans-serif;"+
			"Terminal=terminal,monaco;"+
			"Times New Roman=times new roman,times;"+
			"Trebuchet MS=trebuchet ms,geneva;"+
			"Verdana=verdana,geneva;"+
			"Webdings=webdings;"+
			"Wingdings=wingdings,zapf dingbats"
		});
	}
}