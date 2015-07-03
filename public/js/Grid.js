/**
 * Класс для работы с сеткой
 *
 * @constructor
 *
 * @param {int} id идентификатор раздела
 */
function Grid (id) {

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
	this.id = id;

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
		t.window.addClass("window-grid");
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
			url: "/ajax/" + LANG + "/section/grid/" + t.id + "/",
			dataType: "json",
			beforeSend: function (data) {
				$loaderWindow.appendTo($container);
			},
			success: function (data) {
				var $button = $forms.find(".button").clone();
				$button.find("span").text(data.button.label);
				$button.attr("data-action", data.button.action);
				$button.appendTo(t.window.find(".footer"));
				$button.bind("click", t.submit);

				$container.append('<div class="blocks"></div>');
				var $blocks = $($container).find(".blocks");
				$.each(data.blocks, function (id, params) {
					$blocks.append('<h3>' + params.name + '</h3>');
					$blocks.append('<div />');
					var $last = $blocks.find("div").last();
					$.each(params.blocks, function (id, name) {
						$last.append('<div>' + name + '</div>');
					});
				});
				$blocks.accordion({
					heightStyle: "content"
				});

				$container.append('<div class="clear"></div>');

				$loaderWindow.remove();
				t.window.find(".header").text(data.title).css("display", "block");
				t.window.find(".footer").css("display", "block");
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


		return false;
	};
}