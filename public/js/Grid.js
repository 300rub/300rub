/**
 * Класс для работы с сеткой
 *
 * @constructor
 *
 * @param {int} id идентификатор раздела
 */
function Grid(id) {

	/**
	 * Объект класса
	 *
	 * @type {Grid}
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
	 * DOM-объект контейнера окна
	 *
	 * @type {HTMLElement}
	 */
	this.container = null;

	this.lineClone = null;

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
		t.container = t.window.find(".container");

		$.ajax({
			url: "/ajax/" + LANG + "/section/grid/" + t.id + "/",
			dataType: "json",
			beforeSend: function (data) {
				$loaderWindow.appendTo(t.container);
			},
			success: function (data) {
				var $button = $forms.find(".button").clone();
				$button.find("span").text(data.button.label);
				$button.attr("data-action", data.button.action);
				$button.appendTo(t.window.find(".footer"));
				$button.bind("click", t.submit);

				var $lineContainer = $('<div class="line-container"></div>');
				$lineContainer.appendTo(t.container);
				$lineContainer.sortable({
					stop: function (event, ui) {
						t.resetLineNumbers();
					}
				});

				t.showAddButton($lineContainer);

				t.container.find(".overlay").bind("click", t.close);
				$loaderWindow.remove();
				t.window.find(".header").text(data.title).css("display", "block");
				t.window.find(".footer").css("display", "block");

				t.setLineCloneWithBlocks(data.blocks);

				if (data.grid) {
					t.parseGrid(data.grid, $lineContainer);
				} else {
					t.addLine($lineContainer);
				}
			},
			error: function (request, status, error) {
				$loaderWindow.remove();
				$errors.find(".system").clone().appendTo(t.container);
			}
		});
	};

	this.setLineCloneWithBlocks = function(blocks) {
		t.lineClone = $templates.find(".grid-stack-line").clone();
		var $select = t.lineClone.find(".grid-stack-line-select-block");
		$.each(blocks, function(i, item) {
			var $option = $("<option></option>");
			$option.html(item.name);
			if (item.isDisabled === true) {
				$option.attr("disabled", true);
			}
			$option.attr("data-id", item.id);
			$option.attr("data-type", item.type);
			$select.append($option);
		});
	};

	/**
	 * Показывает кнопку добавления линии
	 *
	 * @param {HTMLElement} $lineContainer
	 */
	this.showAddButton = function ($lineContainer) {
		var $lineAdd = $templates.find(".grid-stack-line-add").clone();
		$lineAdd.appendTo(t.window.find(".footer"));
		$lineAdd.on("click", function () {
			t.addLine($lineContainer);
			return false;
		});
	};

	/**
	 * Выводит блоки в сетке
	 *
	 * @param {object} grid
	 * @param {HTMLElement} $lineContainer
	 */
	this.parseGrid = function (grid, $lineContainer) {
		$.each(grid, function (lineNumber, line) {
			t.addLine($lineContainer);
			$.each(line, function (i, item) {
				t.addWidget(lineNumber, item.id, item.type, item.x, item.y, item.width, item.name, false);
			});
		});
	};

	/**
	 * Добавляет виджет в сетку
	 *
	 * @param {int} line
	 * @param {int} id
	 * @param {int} type
	 * @param {int} x
	 * @param {int} y
	 * @param {int} width
	 * @param {string} name
	 * @param {boolean} isAutoPosition
	 */
	this.addWidget = function (line, id, type, x, y, width, name, isAutoPosition) {
		var grid = $('.grid-stack-line:nth-child(' + line + ') .grid-stack').data('gridstack');
		var $gridStackItem = $templates.find(".grid-stack-item").clone();
		var $gridStackItemContent = $gridStackItem.find(".grid-stack-item-content");
		$gridStackItemContent.addClass("grid-stack-item-content-" + type);
		$gridStackItem.attr("data-id", id);
		$gridStackItem.attr("data-type", type);
		$gridStackItemContent.text(name);
		grid.add_widget($gridStackItem, x, y, width, 1, isAutoPosition);

		$gridStackItem.find(".remove").on("click", function () {
			grid.remove_widget($gridStackItem);
		});
	};

	this.setBlockSelectForLine = function($line) {
		var $select = $line.find(".grid-stack-line-select-block");
		$select.on("change", function () {
			var line = parseInt($line.find(".grid-stack-line-header .title span").text());
			var name = $(this).val();
			var id = parseInt($(this).find(':selected').data('id'));
			var type = parseInt($(this).find(':selected').data('type'));
			if (id > 0 && type > 0) {
				t.addWidget(line, id, type, 0, 0, 3, name, true);
			}
			$(this).val(0);
		});
	};

	/**
	 * Добавляет линию
	 *
	 * @param {HTMLElement} $lineContainer
	 */
	this.addLine = function ($lineContainer) {
		var $line = t.lineClone.clone();
		$line.appendTo($lineContainer);
		t.setBlockSelectForLine($line);
		$line.find(".remove").bind("click", t.removeLine);

		$line.find('.grid-stack').gridstack({
			cell_height: 30,
			vertical_margin: 10,
			resizable: {
				minHeight: 30,
				maxHeight: 30,
				handles: "e, w"
			}
		});

		t.resetLineNumbers();
	};

	/**
	 * Удаляет линию
	 *
	 * @returns {boolean}
	 */
	this.removeLine = function () {
		$(this).parent().parent().remove();
		t.resetLineNumbers();
		return false;
	};

	/**
	 * Сбрасывает номера строк
	 */
	this.resetLineNumbers = function () {
		$(t.window).find(".grid-stack-line").each(function (id) {
			$(this).find(".title span").text(id + 1);
		});
	};

	/**
	 * Нажатие на кнопку отправки
	 *
	 * @returns {boolean}
	 */
	this.submit = function () {
		var data = [];

		t.window.find(".grid-stack-line").each(function (i, val) {
			var line = [];
			t.window.find('.grid-stack-line:nth-child(' + (i + 1) + ') .grid-stack .grid-stack-item:visible').each(function () {
				var node = $(this).data('_gridstack_node');
				var item = {
					id: $(this).data("id"),
					type: $(this).data("type"),
					x: node.x,
					y: node.y,
					width: node.width
				};
				line.push(item);
			});
			data.push(line);
		});

		var $loaderButton = $loader.clone();
		var $button = t.window.find(".button");
		var $buttonSpan = $button.find("span");

		$.ajax({
			url: "/ajax/" + LANG + "/section/saveGrid/" + t.id + "/",
			type: "post",
			data: {data: data},
			dataType: "json",
			beforeSend: function (data) {
				$loaderButton.appendTo($button);
				$buttonSpan.css("opacity", 0);
			},
			success: function (data) {
				if (parseInt(t.id) == parseInt(SECTION_ID) || parseInt(SECTION_ID) == 0) {
					location.reload();
				} else {
					$loaderButton.remove();
					$buttonSpan.css("opacity", 1);
					t.close();
				}
			},
			error: function (request, status, error) {
				$loaderButton.remove();
				$buttonSpan.css("opacity", 1);
				t.container.text("");
				$errors.find(".system").clone().appendTo(t.container);
			}
		});

		return false;
	};
}