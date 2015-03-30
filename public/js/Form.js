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

	/**
	 * Уникальный идентификатор
	 *
	 * @type {number}
	 */
	this.id = Math.floor(Math.random() * 99999);

	/**
	 * Сопоставление типов и html форм
	 *
	 * @type Object
	 */
	this.fields = {
		field: "input",
		checkbox: "input",
		password: "input"
	};

	/**
	 * Получает DOM-объект формы
	 *
	 * @returns {HTMLElement}
	 */
	this.get = function () {
		if (this.fields[this.params.type] == undefined) {
			return false;
		}

		var $object = $forms.find(".form-container-" + this.params.type).clone();
		var $form = $object.find(this.fields[this.params.type]);
		var container = t.name.replace(".", "__");

		$form.val(this.params.value);

		$form.attr("id", t.id);
		$form.attr("name", "Data[" + t.name + "]");

		$object.addClass(container);
		$form.attr("data-container", container);

		$object.find("label").text(params.label).attr("for", t.id);

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

		return $object;
	};

	/**
	 * Преобразует строку в транслит
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
}