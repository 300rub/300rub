!function ($, c) {
    "use strict";

    /**
     * Container
     *
     * @type {Object}
     */
    c.Window.prototype.$_sectionContainer = null;

    /**
     * Line template
     *
     * @type {Object}
     */
    c.Window.prototype.$_sectionLineTemplate = null;

    /**
     * Initialization
     */
    c.Window.prototype.section = function () {
        this
            ._sectionSetLineTemplate()
            ._sectionSetContainer()
            ._sectionSetAddLineButton();

        if (this.data.grid) {
            this._sectionParseGrid(this.data.grid);
        } else {
            this._sectionAddLine(0);
        }

        this.$submit.off().on("click", $.proxy(this._sectionSubmit, this));
    };

    /**
     * Sets container
     *
     * @returns {c.Window}
     *
     * @private
     */
    c.Window.prototype._sectionSetContainer = function () {
        this.$_sectionContainer = c.$templates.find(".j-window-section-container").clone()
            .appendTo(this.$container)
            .sortable({
                stop: $.proxy(function () {
                    this._sectionResetLineNumbers();
                }, this)
            });

        return this;
    };

    /**
     * Sets line template
     *
     * @private
     */
    c.Window.prototype._sectionSetLineTemplate = function () {
        this.$_sectionLineTemplate = c.$templates.find(".j-window-section-line").clone();

        var $select = this.$_sectionLineTemplate.find(".j-select-block");
        $.each(this.data.blocks, function (i, item) {
            $("<option/>")
                .html(item.name)
                .attr("data-id", item.id)
                .attr("data-type", item.type)
                .attr("disabled", item.isDisabled === true)
                .appendTo($select);
        });
    };

    /**
     * Resets line numbers
     *
     * @private
     */
    c.Window.prototype._sectionResetLineNumbers = function () {
        this.$_sectionContainer.find(".j-window-section-line").each(function (id) {
            $(this).find(".title span").text(id + 1);
        });
    };

    /**
     * Sets "Add line" button
     *
     * @returns {c.Window}
     *
     * @private
     */
    c.Window.prototype._sectionSetAddLineButton = function () {
        c.$templates.find(".j-window-section-add-line").clone()
            .appendTo(this.$window.find(".j-footer"))
            .on("click", $.proxy(function () {
                this._sectionAddLine(0);
                return false;
            }, this));

        return this;
    };

    /**
     * Adds line
     *
     * @param {Integer} [id] Line ID
     *
     * @private
     */
    c.Window.prototype._sectionAddLine = function (id) {
        var $line = this.$_sectionLineTemplate.clone()
            .attr("data-id", id)
            .css("display", "block")
            .appendTo(this.$_sectionContainer);

        $line.find(".j-remove").on("click", $.proxy(function () {
            $line.remove();
            this._sectionResetLineNumbers();
            return false;
        }, this));

        var blockLine, blockName, blockId, blockType;
        $line.find(".j-select-block").on("change", function () {
            blockLine = parseInt($line.find(".j-header .j-title span").text());
            blockName = $(this).val();
            blockId = parseInt($(this).find(':selected').data('id'));
            blockType = parseInt($(this).find(':selected').data('type'));
            if (blockId > 0 && blockType > 0) {
                this._sectionAddWidget(blockLine, blockId, blockType, 0, 0, 3, blockName, true);
            }
            $(this).val(0);
        });

        $line.find('.j-grid-stack').gridstack({
            cell_height: 30,
            vertical_margin: 10,
            resizable: {
                minHeight: 30,
                maxHeight: 30,
                handles: "e, w"
            }
        });

        this._sectionResetLineNumbers();
    };

    /**
     * Adds widget
     *
     * @param {Integer} [line]           Line number
     * @param {Integer} [id]             Line id
     * @param {Integer} [type]           Type (for design)
     * @param {Integer} [x]              Left
     * @param {Integer} [y]              Top
     * @param {Integer} [width]          Width
     * @param {String}  [name]           Label
     * @param {boolean} [isAutoPosition] Auto position
     *
     * @private
     */
    c.Window.prototype._sectionAddWidget = function (line, id, type, x, y, width, name, isAutoPosition) {
        var grid =
            this.$_sectionContainer.find('.j-window-section-line:nth-child(' + line + ').grid-stack').data('gridstack');
        var $gridStackItem = c.$templates.find(".j-window-section-grid-stack-item").clone();

        $gridStackItem
            .attr("data-id", id)
            .attr("data-type", type);
        grid.add_widget($gridStackItem, x, y, width, 1, isAutoPosition);

        $gridStackItem.find(".j-remove").on("click", function () {
            grid.remove_widget($gridStackItem);
        });

        $gridStackItem.find(".j-content").text(name);
    };

    /**
     * Parses grid
     *
     * @param grid
     *
     * @private
     */
    c.Window.prototype._sectionParseGrid = function (grid) {
        $.each(grid, $.proxy(function (lineNumber, data) {
            this._sectionAddLine(data.id);
            $.each(data.grids, function (i, item) {
                this._sectionAddWidget(lineNumber, item.id, item.type, item.x, item.y, item.width, item.name, false);
            });
        }, this));
    };

    /**
     * Sets submit event
     *
     * @returns {boolean}
     *
     * @private
     */
    c.Window.prototype._sectionSubmit = function () {
        var data = [];
        var items;
        var $line;
        this.$_sectionContainer.find(".j-window-section-line").$.proxy(each(function (i, line) {
            $line = $(line);
            items = [];
            $line.find(".j-grid-stack .j-window-section-grid-stack-item:visible").each(function () {
                var node = $line.data('_gridstack_node');
                var item = {
                    id: $line.data("id"),
                    type: $line.data("type"),
                    x: node.x,
                    y: node.y,
                    width: node.width
                };
                items.push(item);
            });
            data.push({id: $line.data("id"), items: items});
        }, this));

        $.ajaxJson(
            this.data.action,
            {data: data},
            $.proxy(this._sectionOnSubmitBeforeSend, this),
            $.proxy(this._sectionOnSubmitSuccess, this),
            $.proxy(this._onError, this)
        );

        return false;
    };

    /**
     * On submit AJAX before send event
     *
     * @private
     */
    c.Window.prototype._sectionOnSubmitBeforeSend = function () {
        this.$submit.find(".j-label").addClass("j-hide");
        this.$submit.find(".j-loader").removeClass("j-hide");
    };

    /**
     * On submit AJAX success event
     *
     * @param {Object} data Data from response
     *
     * @private
     */
    c.Window.prototype._sectionOnSubmitSuccess = function (data) {
        if (data !== false) {
            if (parseInt(this.id) === c.sectionId || c.sectionId === 0) {
                location.reload();
            } else {
                this.close();
            }
        } else {
            // errors
        }
    };
}(window.jQuery, window.Core);