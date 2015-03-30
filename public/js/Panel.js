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
		t.panel.attr("data-name", t.params.name);
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
				t.panel.find(".title").text(data.title);
				t.panel.find(".description").text(data.description);
				t.panel.find(".header").css("display", "block");
				t.panel.find(".footer").css("display", "block");

				if (data.list != undefined) {
					var itemTemplate = $templates.find(".panel-item");
					if (data.list.icons.big === true) {
						itemTemplate.addClass("with-icon");
					}
					if (data.list.icons.design !== false) {
						itemTemplate.find("a.design").css("display", "block");
					}
					if (data.list.icons.settings !== false) {
						itemTemplate.find("a.settings").css("display", "block");
						t.panel.attr("data-settings-content", data.list.icons.settings);
					}
					if (data.list.icons.design === false && data.list.icons.settings === false) {
						itemTemplate.find("span.item").css("display", "block");
					}

					$.each(data.list.items, function (i, item) {
						var clone = itemTemplate.clone();
						clone.attr("data-id", item.id);
						clone.find(".label").text(item.label);
						clone.appendTo(t.panel.find(".container"));
					});

					t.panel.find(".panel-item .settings").bind("click", t.settings);
				}

				if (data.forms != undefined) {
					$.each(data.forms, function (name, params) {
						$form = (new Form(name, params)).get();
						if ($form !== false) {
							$form.appendTo($container);
						}
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

		return false;
	};

	/**
	 * Настройки
	 *
	 * @returns {boolean}
	 */
	this.settings = function () {
		var content = t.panel.data("settings-content") + "/" + $(this).parent().data("id");

		(new Panel({
			name: t.panel.data("name"),
			content: content
		})).init();

		t.panel.remove();

		return false;
	};
}