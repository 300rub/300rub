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
	 * DOM-объект контейнера окна
	 *
	 * @type {HTMLElement}
	 */
	this.container = null;

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

				t.showBlocks(data.blocks);

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
	 * Показывает блоки
	 *
	 * @param {object} blocks
	 */
	this.showBlocks = function (blocks) {
		t.container.append('<div class="blocks"></div>');
		var $blocks = t.container.find(".blocks");
		$.each(blocks, function (id, params) {
			$blocks.append('<h3>' + params.name + '</h3>');
			$blocks.append('<div />');
			var $last = $blocks.find("div").last();
			$.each(params.blocks, function (id, name) {
				var $block = $("<div/>");
				$block.addClass("block");
				$block.addClass("block-" + params.class);
				$block.attr("data-name", name);
				$block.attr("data-class", params.class);
				$block.attr("data-id", id);
				$block.text(name);
				$block.appendTo($last);
			});
		});
		$blocks.accordion({
			heightStyle: "content"
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
				t.addWidget(lineNumber + 1, item.id, item.cssClass, item.x, item.y, item.width, item.name, false);
			});
		});
	};

	/**
	 * Добавляет selectы для блоков для выбора линии
	 */
	this.appendSelect = function () {
		$(".blocks .block").each(function () {
			$(this).find("select").remove();
			var select = '<select>';
			select += '<option disabled selected> -- select line -- </option>';
			for (i = 1; i < $(".grid-stack-line").length; i++) {
				select += '<option>' + i + '</option>';
			}
			select += '</select>';
			$(this).append(select);
		});
		$(".blocks .block select").bind("change", t.blockSelectLine);
	};

	/**
	 * Выбор линии для блока
	 */
	this.blockSelectLine = function () {
		var line = $(this).val();
		var cssClass = $(this).parent().data("class");
		var id = $(this).parent().data("id");
		var name = $(this).parent().data("name");
		$(this).val(0);
		t.addWidget(line, id, cssClass, 0, 0, 3, name, true);
	};

	/**
	 * Добавляет виджет в сетку
	 *
	 * @param {int} line
	 * @param {int} id
	 * @param {string} cssClass
	 * @param {int} x
	 * @param {int} y
	 * @param {int} width
	 * @param {string} name
	 * @param {boolean} isAutoPosition
	 */
	this.addWidget = function (line, id, cssClass, x, y, width, name, isAutoPosition) {
		var grid = $('.grid-stack-line:nth-child(' + line + ') .grid-stack').data('gridstack');

		var $gridStackItem = $templates.find(".grid-stack-item").clone();
		var $gridStackItemContent = $gridStackItem.find(".grid-stack-item-content");
		$gridStackItemContent.addClass("grid-stack-item-content-" + cssClass);
		$gridStackItem.attr("data-id", id);
		$gridStackItemContent.text(name);
		grid.add_widget($gridStackItem, x, y, width, 1, isAutoPosition);

		$gridStackItem.find(".remove").on("click", function () {
			grid.remove_widget($gridStackItem);
		});
	};

	/**
	 * Добавляет линию
	 *
	 * @param {HTMLElement} $lineContainer
	 */
	this.addLine = function ($lineContainer) {
		var $line = $templates.find(".grid-stack-line").clone();
		$line.appendTo($lineContainer);
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
		t.appendSelect();
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
			//	dataType: "json",
			beforeSend: function (data) {
				$loaderButton.appendTo($button);
				$buttonSpan.css("opacity", 0);
			},
			success: function (data) {
				$loaderButton.remove();
				$buttonSpan.css("opacity", 1);
				alert(data);
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