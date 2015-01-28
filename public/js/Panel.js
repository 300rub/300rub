/**
 * Класс для работы с панелями
 *
 * @constructor
 *
 * @param {Object} params параметры
 */
function Panel (params) {

	/**
	 * Объект класса
	 *
	 * @type {Panel}
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
	this.panel = null;

	/**
	 * Производит инициализацию окна
	 */
	this.init = function () {
		$panelButtons.find("a").addClass("panel-button-half");
		$("#sections-button").addClass("panel-buttons-" + t.params.name + "-top");

		t.panel = $templates.find(".panel").clone();
		t.panel.addClass("panel-" + t.params.name);
		t.panel.appendTo($ajaxWrapper);

		t.showContent();
		t.panel.find(".close").bind("click", t.close);
	};

	this.showContent = function () {
		var $loaderPanel = $loader.clone();
		var $container = t.panel.find(".container");

		$.ajax({
			url: "/ajax/" + LANG + "/" + t.params.content + "/",
			dataType: "json",
			beforeSend: function (data) {
				$loaderPanel.appendTo($container);
			},
			success: function (data) {
				$loaderPanel.remove();
				t.panel.find(".title").text(t.params.title);
				t.panel.find(".header").css("display", "block");
				t.panel.find(".footer").css("display", "block");

				if (data.items != undefined) {
					var itemTemplate = $templates.find(".panel-item");
					$.each(data.items, function (i, item) {
						var clone = itemTemplate.clone();
						clone.find(".label").text(item.label);
						clone.appendTo(t.panel.find(".container"));
					});
				}
			},
			error: function (request, status, error) {
				$loaderPanel.remove();
				$errors.find(".system").clone().appendTo($container);
			}
		});
	};

	/**
	 * Закрытие окна
	 *
	 * @returns {boolean}
	 */
	this.close = function () {
		$ajaxWrapper.find(".panel").remove();
		$panelButtons.find("a").removeClass("panel-button-half").removeClass("panel-button-active");
		$("#sections-button").attr("class", "");

		return this;
	};
}