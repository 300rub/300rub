/**
 * Класс для работы с окнами
 *
 * Пример:
 * (new Window({
 * 		name: "name",
 * 		title: "Заголовок",
 * 		button: "Текст кнопки",
 * 		forms: controller/forms,
 * 		send: controller/send
 * })).init();
 *
 * @constructor
 *
 * @param {Object} params параметры
 */
var Window = function (params) {

	/**
	 * Объект класса
	 *
	 * @type {Window}
	 */
	var t = this;

	/**
	 * Название css-класса
	 *
	 * @type {string}
	 */
	this.name = params.name;

	/**
	 * Название кнопки
	 *
	 * @type {string}
	 */
	this.button = params.button;

	/**
	 * URL для получения форм
	 *
	 * @type {string}
	 */
	this.forms = params.forms;

	/**
	 * URL для отправки данных
	 *
	 * @type {string}
	 */
	this.send = params.send;

	/**
	 * DOM-объект окна
	 *
	 * @type {string}
	 */
	this.window = null;

	/**
	 * Производит инициализацию окна
	 */
	this.init = function () {
		t.window = $templates.find(".window").clone();
		t.window.addClass("window-" + t.name);
		t.window.appendTo($ajaxWrapper);

		t.showOverlay();
		t.showContent();

		t.window.find(".close").bind("click", t.close);
		t.window.find("button").bind("click", t.submit);
		$ajaxWrapper.find(".overlay").bind("click", t.close);
	};

	/**
	 * Показывает затемнение
	 */
	this.showOverlay = function () {
		$templates.find(".overlay").clone().appendTo($ajaxWrapper);
	};

	/**
	 * Скрывает затемнение
	 */
	this.hideOverlay = function () {
		$ajaxWrapper.find(".overlay").remove();
	};

	/**
	 * Закрытие окна
	 *
	 * @returns {boolean}
	 */
	this.close = function () {
		t.window.remove();
		t.hideOverlay();

		return false;
	};

	/**
	 * Загружает контект в окно
	 */
	this.showContent = function () {
		var $loaderWindow = $loader.clone();
		var $container = t.window.find(".container");

		$.ajax({
			url: "/ajax/" + LANG + "/" + t.forms + "/",
			dataType: "json",
			beforeSend: function (data) {
				$loaderWindow.appendTo($container);
			},
			success: function (data) {
				var $button = t.window.find("button");

				$loaderWindow.remove();
				t.window.find(".title").text(t.title);
				$button.find("span").text(t.button);
				$button.css("display", "block");

				$.each(data, function (name, params) {
					(new Form(name, params)).get().appendTo($container);
				});
			},
			error: function () {
				$loaderWindow.remove();
				$systemError.clone().appendTo($container);
			}
		});
	};

	/**
	 * Нажатие на кнопку отправки
	 *
	 * @returns {boolean}
	 */
	this.submit = function () {
		var $form = $(this).parents("form");
		var $loaderButton = $loader.clone();
		var $button = $form.find("button");
		var $buttonSpan = $button.find("span");

		$.ajax({
			url: "/ajax/" + LANG + "/" + t.send + "/",
			type: "post",
			data: $form.serialize(),
			dataType: "json",
			beforeSend: function (data) {
				$loaderButton.appendTo($button);
				$buttonSpan.css("opacity", 0);
				$form.find(".error").text("");
			},
			success: function (data) {
				$loaderButton.remove();
				$buttonSpan.css("opacity", 1);
				if (data.success === false) {
					$.each(data.errors, function (name, errors) {
						var errs = [];
						$.each(errors, function (type, value) {
							errs[errs.length] = value;
						});
						$form.find("." + name.replace(".", "__") + " .error").html(errs.join('<br />'));
					});
				}
			},
			error: function () {
				$loaderButton.remove();
				$buttonSpan.css("opacity", 1);
				var $container = t.window.find(".container");
				$container.text("");
				$systemError.clone().appendTo($container);
			}
		});

		return false;
	};
};