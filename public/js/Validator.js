/**
 * Класс для валидации
 *
 * @constructor
 *
 * @param {HTMLElement} form форма для валидации
 */
var Validator = function (form) {

	/**
	 * Объект класса
	 *
	 * @type {Validator}
	 */
	var t = this;

	/**
	 * Форма для валидации
	 *
	 * @type {HTMLElement}
	 */
	this.form = form;

	/**
	 * Ошибки
	 *
	 * @type {Object}
	 */
	this.errors = {};

	/**
	 * Производит валидацию всей формы
	 *
	 * @returns {boolean}
	 */
	this.validate = function () {
		this.form.find(".validate").each(function (i) {
			var $form = $(this);
			$.each($(this).data("rules").split(", "), function (i, rule) {
				var split = rule.split("-");
				if (split[1] == undefined) {
					t[split[0]]($form);
				} else {
					t[split[0]]($form, split[1]);
				}
			});
		});

		if (!$.isEmptyObject(t.errors)) {
			t.showErrors(t.errors);
			return false;
		}

		return true;
	};

	/**
	 * Проверка на пустое значение
	 *
	 * @param {HTMLElement} form форма
	 */
	this.required = function (form) {
		if ($.trim(form.val()) === "") {
			t.addError(form.data("container"), "required");
		}
	};

	/**
	 * Проверка на максимальное значение
	 *
	 * @param {HTMLElement} form форма
	 * @param {int}         max  максимальное число символов
	 */
	this.max = function (form, max) {
		if ($.trim(form.val()).length > parseInt(max)) {
			t.addError(form.data("container"), "max");
		}
	};

	/**
	 * Добавляет ошибку
	 *
	 * @param {string} container  название контейнера
	 * @param {string} error      название ошибки
	 */
	this.addError = function (container, error) {
		if (t.errors[container] == undefined) {
			t.errors[container] = error;
		}
	};

	/**
	 * Выводит все ошибки на экран
	 *
	 * @param {Object} errors ошибки
	 */
	this.showErrors = function (errors) {
		t.form.find("div.error").remove();
		t.form.find("input.error").removeClass("error");
		$.each(errors, function (container, error) {
			$errors.find("." + error).clone().appendTo(t.form.find("." + container));
			t.form.find("." + container + " input").addClass("error");
		});
	};
};