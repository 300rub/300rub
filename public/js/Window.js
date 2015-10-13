/**
 * Класс для работы с окнами
 *
 * @constructor
 *
 * @param {string} action запрос
 */
function Window (action) {

	/**
	 * Объект класса
	 *
	 * @type {Window}
	 */
	var t = this;

	/**
	 * запрос
	 *
	 * @type {string}
	 */
	this.action = action;

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
		t.window.appendTo($ajaxWrapper);

		t.showOverlay();
		t.showContent();

		t.window.find(".close").bind("click", t.close);
		t.window.find(".button").bind("click", t.submit);
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
			url: "/ajax/" + LANG + "/" + t.action + "/",
			dataType: "json",
			beforeSend: function (data) {
				$loaderWindow.appendTo($container);
			},
			success: function (data) {
				if (data.forms != undefined) {
					var $form;
					$.each(data.forms, function (name, params) {
						$form = (new Form(name, params)).get();
						if ($form !== false) {
							$form.appendTo($container);
						}
					});
				}

				if (data.button != undefined) {
					var $button = $forms.find(".button").clone();
					$button.find("span").text(data.button.label);
					$button.attr("data-action", data.button.action);
					if (data.button.update != undefined) {
						$button.attr("data-update-block", data.button.update.block);
						$button.attr("data-update-content", data.button.update.content);
					}
					$button.appendTo(t.window.find(".footer"));
					$button.bind("click", t.submit);
				}

				t.window.find(".footer").css("display", "block");
				t.window.addClass("window-" + data.name);
				t.window.find(".header").text(data.title).css("display", "block");
				$loaderWindow.remove();
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
		var $button = $form.find(".button");
		var $buttonSpan = $button.find("span");
		var action = $(this).data("action");

		$.ajax({
			url: "/ajax/" + LANG + "/" + action + "/",
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
					if ($button.data("update-content") != undefined) {
						$.ajax({
							url: "/ajax/" + LANG + "/" + $button.data("update-content") + "/",
							success: function (data) {
								$("." + $button.data("update-block")).html(data);
							}
						});
					} else if (data.redirect != undefined) {
						window.location.replace(data.redirect);
					}

					t.close();
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