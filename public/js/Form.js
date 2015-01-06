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
	 * Получает DOM-объект формы
	 *
	 * @returns {HTMLElement}
	 */
	this.get = function () {
		return this[this.params.form]();
	};

	/**
	 * Получает DOM-объект текстового поля
	 *
	 * @returns {HTMLElement}
	 */
	this.field = function () {
		var $object = $forms.find(".field").clone();
		var $form = $object.find("input");

		$form.attr("id", t.id);
		$form.attr("name", t.getName(t.name));
		$object.addClass(t.getClass(t.name));

		if (params.label == undefined) {
			$object.find("label").remove();
		} else {
			$object.find("label").text(params.label).attr("for", this.id);
		}

		return $object;
	};

	/**
	 * Получает DOM-объект галочки с подписью
	 *
	 * @returns {HTMLElement}
	 */
	this.checkbox = function () {
		var $object = $forms.find(".checkbox").clone();
		var $form = $object.find("input");

		$form.attr("id", t.id);
		$form.attr("name", t.getName(t.name));
		$object.addClass(t.getClass(t.name));
		$object.find("label").text(params.label).attr("for", this.id);

		return $object;
	};

	/**
	 * Получает название атрибута name
	 *
	 * @param {string} name название для обработки
	 *
	 * @returns {string}
	 */
	this.getName = function (name) {
		return "Data[" + name + "]";
	};

	/**
	 * Получает название класса для формы
	 *
	 * @param name название
	 *
	 * @returns {string}
	 */
	this.getClass = function (name) {
		return name.replace(".", "__");
	};
};