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

        this._sectionSetHeight();
        $(window).resize($.proxy(function () {
            this._sectionSetHeight();
        }, this));
    };

    /**
     * Sets container's height
     *
     * @private
     */
    c.Window.prototype._sectionSetHeight = function() {
        this.$container.css("height", $.proxy(function () {
            return $(window).outerHeight() - 148;
        }, this));
    };

    /**
     * Sets container
     *
     * @returns {c.Window}
     *
     * @private
     */
    c.Window.prototype._sectionSetContainer = function () {
        this.$_sectionContainer = c.$templates.find(".j-window-section-container").clone().appendTo(this.$container);
        return this;
    };

    /**
     * Sets line template
     *
     * @returns {c.Window}
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

        return this;
    };

    /**
     * Resets line numbers
     *
     * @private
     */
    c.Window.prototype._sectionResetLineNumbers = function () {
        this.$_sectionContainer.find(".j-window-section-line").each(function (id) {
            $(this).find(".j-title .j-line-number").text(id + 1);
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
                this.$container.scrollTop(99999);
                return false;
            }, this));

        return this;
    };

    /**
     * Adds line
     *
     * @param {int} [id] Line ID
     *
     * @private
     */
    c.Window.prototype._sectionAddLine = function (id) {
        var t = this;
        var $line = this.$_sectionLineTemplate.clone()
            .attr("data-id", id)
            .css("display", "block")
            .appendTo(this.$_sectionContainer);

        $line.find(".j-remove").on("click", function () {
            $line.remove();
            t._sectionResetLineNumbers();
            return false;
        });

        var blockLine, blockName, blockId, blockType;
        $line.find(".j-select-block").on("change", function () {
            blockLine = parseInt(
                $(this)
                    .closest(".j-window-section-line")
                    .find(".j-header .j-title .j-line-number")
                    .text()
            );
            blockName = $(this).val();
            blockId = parseInt($(this).find(':selected').data('id'));
            blockType = parseInt($(this).find(':selected').data('type'));
            if (blockId > 0 && blockType > 0) {
                t._sectionAddWidget(blockLine, blockId, blockType, 0, 0, 3, blockName, true);
            }
            $(this).val(0);
        });

        $line.find('.j-grid-stack').gridstack({
            cellHeight: 30,
            verticalMargin: 10,
            resizable: {
                minHeight: 30,
                maxHeight: 30
            }
        });

        $line.find(".j-line-up").on("click", function () {
            $line.insertBefore($line.prev());
            t._sectionResetLineNumbers();
            return false;
        });
        $line.find(".j-line-down").on("click", function () {
            $line.insertAfter($line.next());
            t._sectionResetLineNumbers();
            return false;
        });

        t._sectionResetLineNumbers();
    };

    /**
     * Adds widget
     *
     * @param {int}     [line]           Line number
     * @param {int}     [id]             Line id
     * @param {int}     [type]           Type (for design)
     * @param {int}     [x]              Left
     * @param {int}     [y]              Top
     * @param {int}     [width]          Width
     * @param {String}  [name]           Label
     * @param {boolean} [isAutoPosition] Auto position
     *
     * @private
     */
    c.Window.prototype._sectionAddWidget = function (line, id, type, x, y, width, name, isAutoPosition) {
        var grid =
            this.$_sectionContainer.find('.j-window-section-line:nth-child(' + line + ') .j-grid-stack').data('gridstack');
        var $gridStackItem = c.$templates.find(".j-window-section-grid-stack-item").clone();

        $gridStackItem
            .attr("data-id", id)
            .attr("data-type", type);
        grid.addWidget($gridStackItem, x, y, width, 1, isAutoPosition);

        $gridStackItem.find(".j-remove").on("click", function () {
            grid.removeWidget($gridStackItem);
            return false;
        });

        $gridStackItem.find(".j-content .j-label").text(name);
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
            $.each(data.grids, $.proxy(function (i, item) {
                this._sectionAddWidget(lineNumber, item.id, item.type, item.x, item.y, item.width, item.name, false);
            }, this));
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
        this.$_sectionContainer.find(".j-window-section-line").each($.proxy(function (i, line) {
            $line = $(line);
            items = [];
            $line.find(".j-grid-stack .j-window-section-grid-stack-item:visible").each(function () {
                var node = $(this).data('_gridstack_node');
                var item = {
                    id: $(this).data("id"),
                    type: $(this).data("type"),
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
            {
                grid: data,
                id: this.id
            },
            $.proxy(this._sectionOnSubmitBeforeSend, this),
            $.proxy(this._sectionOnSubmitSuccess, this),
            $.proxy(this.onError, this)
        );

        return false;
    };

    /**
     * On submit AJAX before send event
     *
     * @private
     */
    c.Window.prototype._sectionOnSubmitBeforeSend = function () {
        this.$submit.find(".j-icon").addClass("d-hide");
        this.$submit.find(".j-loader").removeClass("d-hide");
    };

    /**
     * On submit AJAX success event
     *
     * @param {Object} data Data from response
     *
     * @private
     */
    c.Window.prototype._sectionOnSubmitSuccess = function (data) {
        this.$submit.find(".j-icon").removeClass("d-hide");
        this.$submit.find(".j-loader").addClass("d-hide");

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