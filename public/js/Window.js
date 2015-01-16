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
function Window (params) {

	/**
	 * Объект класса
	 *
	 * @type {Window}
	 */
	var t = this;

	/**
	 * Параметры
	 *
	 * @type {Object}
	 */
	this.params = params;

	/**
	 * DOM-объект окна
	 *
	 * @type {HTMLElement}
	 */
	this.window = null;

	/**
	 * Производит инициализацию окна
	 */
	this.init = function () {
		t.window = $templates.find(".window").clone();
		t.window.addClass("window-" + t.params.name);
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
			url: "/ajax/" + LANG + "/" + t.params.forms + "/",
			dataType: "json",
			beforeSend: function (data) {
				$loaderWindow.appendTo($container);
			},
			success: function (data) {
				var $footer = t.window.find(".footer");
				var $form;

				$loaderWindow.remove();
				t.window.find(".header").text(t.params.title).css("display", "block");
				$footer.find("button span").text(t.params.button);
				$footer.css("display", "block");

				$.each(data.forms, function (name, params) {
					$form = (new Form(name, params)).get();
					if ($form !== false) {
						$form.appendTo($container);
					}
				});
			},
			error: function (request, status, error) {
				$loaderWindow.remove();
				$errors.find(".system").clone().appendTo($container);
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
			url: "/ajax/" + LANG + "/" + t.params.send + "/",
			type: "post",
			data: $form.serialize(),
			dataType: "json",
			beforeSend: function (data) {
				$loaderButton.appendTo($button);
				$buttonSpan.css("opacity", 0);

				if ((new Validator($form)).validate() === false) {
					$loaderButton.remove();
					$buttonSpan.css("opacity", 1);
					return false;
				}
			},
			success: function (data) {
				$loaderButton.remove();
				$buttonSpan.css("opacity", 1);
				if (data.success === false) {
					(new Validator($form)).showErrors(data.errors);
				} else {
					if (data.container !== null) {
						$wrapper.find("#" + data.container).html(data.html);
						t.close();
					} else if (data.redirect !== null) {
						window.location.replace(data.redirect);
					}
				}
			},
			error: function (request, status, error) {
				$loaderButton.remove();
				$buttonSpan.css("opacity", 1);
				var $container = t.window.find(".container");
				$container.text("");
				$errors.find(".system").clone().appendTo($container);
			}
		});

		return false;
	};
}