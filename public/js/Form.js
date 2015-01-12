/**
 * Класс для работы с формами
 *
 * @constructor
 *
 * @param {string} name   название формы
 * @param {Object} params параметры
 */
var Form = function (name, params) {

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
		if(this.fields[this.params.type] == undefined){
			return false;
		}

		var $object = $forms.find("." + this.params.type).clone();
		var $form = $object.find(this.fields[this.params.type]);

		$form.attr("id", t.id);
		$form.attr("name", "Data[" + t.name + "]");
		$object.addClass(t.name.replace(".", "__")) ;

		$object.find("label").text(params.label).attr("for", t.id);

		if (params.rules !== "") {
			$form.addClass("validate");
			$form.attr("data-rules", params.rules);
		}

		return $object;
	};
};