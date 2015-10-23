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
				t.panel.find(".title span").text(data.title);
				t.panel.find(".description").text(data.description);
				t.panel.find(".header").css("display", "block");
				t.panel.find(".footer").css("display", "block");

				if (data.back != undefined) {
					t.panel.find(".title .back")
						.css("display", "inline-block")
						.attr("data-content", data.back)
						.bind("click", t.loadNewPanel);
				}

				if (data.list != undefined) {
					var itemTemplate = $templates.find(".panel-item").clone();
					if (data.list.class != undefined) {
						itemTemplate.addClass("panel-item-" + data.list.class);
					}
					if (data.list.content != undefined) {
						t.panel.attr("data-content", data.list.content);
					}
					if (data.list.icons.big !== false) {
						itemTemplate.addClass("with-icon");
					}
					if (data.list.icons.design !== false) {
						itemTemplate.find("a.design").css("display", "block");
						t.panel.attr("data-design-content", data.list.icons.design);
					}
					if (data.list.icons.settings !== false) {
						itemTemplate.find("a.settings").css("display", "block");
						t.panel.attr("data-settings-content", data.list.icons.settings);
					}
					if (data.list.icons.design === false && data.list.icons.settings === false) {
						itemTemplate.find("span.item").css("display", "block");
					}

					$.each(data.list.items, function (i, item) {
						var $clone = itemTemplate.clone();

						if (item.icon != undefined) {
							$clone.addClass("with-icon");
							$clone.find(".big-icon").addClass("big-icon-" + item.icon);
						}
						if ($clone.hasClass("panel-item-grid") && parseInt(item.id) == parseInt(SECTION_ID)) {
							$clone.addClass("with-icon");
							$clone.find(".big-icon").addClass("big-icon-section-active");
						}

						$clone.attr("data-id", item.id);
						$clone.attr("data-content", item.content);
						$clone.find(".label").text(item.label);
						$clone.appendTo(t.panel.find(".container"));
					});

					t.panel.find(".panel-item").bind("click", t.showItem);
					t.panel.find(".panel-item .settings").bind("click", t.settings);
					t.panel.find(".panel-item .design").bind("click", t.design);
				}

				if (data.forms != undefined) {
					$.each(data.forms, function (name, params) {
						var $form = (new Form(name, params)).get();
						if ($form !== false) {
							$form.appendTo($container);
						}
					});
				}

				if (data.design != undefined) {
					var $close = t.panel.find(".close");
					var $back = t.panel.find(".back");
					$close.off();
					$back.off();
					$.each(data.design, function (i, params) {
						var designObject = new Design(params.id, params.type, params.title, params.values);
						var $design = designObject.get();
						if ($design !== false) {
							$design.appendTo($container);
							$close.on("click", function() {
								designObject.reset();
							});
							$back.on("click", function() {
								designObject.reset();
							});
						}
					});
					$close.bind("click", t.close);
					$back.bind("click", t.back);
				}

				if (data.button != undefined) {
					var $button = $forms.find(".button").clone();
					$button.find("span").text(data.button.label);
					$button.attr("data-action", data.button.action);
					if (data.button.update != undefined) {
						$button.attr("data-update-block", data.button.update.block);
						$button.attr("data-update-content", data.button.update.content);
					}
					$button.appendTo(t.panel.find(".footer"));
					$button.bind("click", t.submit);
				}

				if (data.add != undefined) {
					var $add = $forms.find(".button").clone();
					$add.find("span").text(data.add.label);
					$add.attr("data-content", data.add.content);
					$add.addClass("footer-button");
					$add.appendTo(t.panel.find(".footer"));
					$add.bind("click", t.loadNewPanel);
				}

				if (data.duplicate != undefined) {
					t.panel.find(".duplicate")
						.css("display", "block")
						.text(data.duplicate.label)
						.attr("data-action", data.duplicate.action)
						.attr("data-content", data.duplicate.content)
						.bind("click", t.duplicate);
				}

				if (data.delete != undefined) {
					t.panel.find(".delete")
						.css("display", "block")
						.text(data.delete.label)
						.attr("data-action", data.delete.action)
						.attr("data-confirm", data.delete.confirm)
						.attr("data-css", data.delete.cssClass)
						.attr("data-content", data.delete.content)
						.bind("click", t.delete);
				}
			},
			error: function (request, status, error) {
				$loaderPanel.remove();
				$errors.find(".system").clone().appendTo($container);
			}
		});
	};

	this.duplicate = function() {
		var $loaderDuplicate = $loader.clone();
		var action = $(this).data("action");
		var content = $(this).data("content");
		var $container = t.panel.find(".container");

		$.ajax({
			url: "/ajax/" + LANG + "/" + action + "/",
			dataType: "json",
			beforeSend: function (data) {
				$loaderDuplicate.appendTo(t.panel.find(".header"));
			},
			success: function (data) {
				$loaderDuplicate.remove();
				if (data === false) {
					$container.text("");
					$errors.find(".system").clone().appendTo($container);
				} else {
					(new Panel({
						name: t.panel.data("name"),
						content: content + "/" + data
					})).init();

					t.panel.remove();
				}
			},
			error: function (request, status, error) {
				$loaderDuplicate.remove();
				$container.text("");
				$errors.find(".system").clone().appendTo($container);
			}
		});

		return false;
	};

	this.delete = function() {
		var $loaderDelete = $loader.clone();
		var message = $(this).data("confirm");
		var css = $(this).data("css");
		var action = $(this).data("action");
		var content = $(this).data("content");
		var $container = t.panel.find(".container");

		if (confirm(message) === true) {
			$.ajax({
				url: "/ajax/" + LANG + "/" + action + "/",
				dataType: "json",
				beforeSend: function (data) {
					$loaderDelete.appendTo(t.panel.find(".header"));
				},
				success: function (data) {
					$loaderDelete.remove();
					if (data === false) {
						$container.text("");
						$errors.find(".system").clone().appendTo($container);
					} else {
						if (css === "section-" + SECTION_ID) {
							window.location.replace("/" + LANG + "/");
						} else {
							$("." + css).remove();

							(new Panel({
								name: t.panel.data("name"),
								content: content
							})).init();

							t.panel.remove();
						}
					}
				},
				error: function (request, status, error) {
					$loaderDelete.remove();
					$container.text("");
					$errors.find(".system").clone().appendTo($container);
				}
			});
		}

		return false;
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

	this.loadNewPanel = function() {
		var content = $(this).data("content");

		(new Panel({
			name: t.panel.data("name"),
			content: content
		})).init();

		t.panel.remove();

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

	/**
	 * @returns {boolean}
	 */
	this.design = function () {
		var content = t.panel.data("design-content") + "/" + $(this).parent().data("id");

		(new Panel({
			name: t.panel.data("name"),
			content: content
		})).init();

		t.panel.remove();

		return false;
	};

	/**
	 * Нажатие на кнопку сохрнения
	 *
	 * @returns {boolean}
	 */
	this.submit = function () {
		var $form = $(this).parents("form");
		var $loaderButton = $loader.clone();
		var $button = $form.find(".button");
		var $buttonSpan = $button.find("span");

		$.ajax({
			url: "/ajax/" + LANG + "/" + $button.data("action") + "/",
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
					(new Panel({
						name: t.panel.data("name"),
						content: data.content
					})).init();
					t.panel.remove();

					if ($button.data("update-content") != undefined) {
						$.ajax({
							url: "/ajax/" + LANG + "/" + $button.data("update-content") + "/",
							success: function (data) {
								$("." + $button.data("update-block")).html(data);
							}
						});
					}
				}
			},
			error: function (request, status, error) {
				$loaderButton.remove();
				$buttonSpan.css("opacity", 1);
				var $container = t.panel.find(".container");
				$container.text("");
				$errors.find(".system").clone().appendTo($container);
			}
		});

		return false;
	};

	/**
	 * Клик по элементу списка
	 *
	 * @returns {boolean}
	 */
	this.showItem = function () {
		var content;
		if ($(this).hasClass("panel-item-grid")) {
			(new Grid($(this).data("id"))).init();
		} else if ($(this).hasClass("panel-item-window")) {
			content = t.panel.data("content") + "/" + $(this).data("id");
			(new Window(content)).init();
		} else {
			content = $(this).data("content");
			(new Panel({
				name: t.panel.data("name"),
				content: content
			})).init();

			t.panel.remove();
		}

		return false;
	};
}