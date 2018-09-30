!function ($, ss) {
    'use strict';

    /**
     * Section structure window
     *
     * @param {int} sectionId
     *
     * @type {Object}
     */
    ss.window.section.Structure = function (sectionId) {
        ss.window.Abstract.call(
            this,
            {
                group: "section",
                controller: "structure",
                data: {
                    id: sectionId
                },
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "section-structure"
            }
        );

        this._sectionId = sectionId;
        this._container = null;
        this._labels = {};
        this._blocks = {};
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.section.Structure.prototype
        = Object.create(ss.window.Abstract.prototype);

    /**
     * Constructor
     */
    ss.window.section.Structure.prototype.constructor = ss.window.section.Structure;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.section.Structure.prototype._onLoadDataSuccess = function (data) {
        this
            .setTitle(data.title)
            ._setLabels(data.labels)
            ._setContainers()
            ._setBlocks(data.blocks)
            ._setStructure(data.structure)
            ._setAddLineButton()
            ._setSubmitButton();

        this.getBody().append(this._container);
    };

    /**
     * Sets labels
     *
     * @returns {ss.window.section.Structure}
     *
     * @private
     */
    ss.window.section.Structure.prototype._setLabels = function (labels) {
        this._labels = labels;
        return this;
    };

    /**
     * Sets section structure
     *
     * @returns {ss.window.section.Structure}
     *
     * @private
     */
    ss.window.section.Structure.prototype._setContainers = function () {
        this._container = ss.components.Template.get("section-structure");
        return this;
    };

    /**
     * Sets blocks
     *
     * @param {Object} blocks
     *
     * @returns {ss.window.section.Structure}
     *
     * @private
     */
    ss.window.section.Structure.prototype._setBlocks = function (blocks) {
        this._blocks = blocks;
        return this;
    };

    /**
     * Adds block
     *
     * @param {Object} data
     * @param {Object} gridStack
     *
     * @returns {Object}
     *
     * @private
     */
    ss.window.section.Structure.prototype._addBlock = function (data, gridStack) {
        var icon;
        switch (data.type) {
            case 1:
                icon = "fas fa-font";
                break;
            case 2:
                icon = "fas fa-image";
                break;
            case 3:
                icon = "far fa-newspaper";
                break;
            case 5:
                icon = "fas fa-bars";
                break;
            default:
                icon = null;
                break;
        }

        var blockElement = ss.components.Template.get(
            "grid-stack-item"
        );

        blockElement.find(".name").text(data.name);
        blockElement.attr("title", data.name);

        var iconElement = blockElement.find(".icon");
        if (icon === null) {
            iconElement.remove();
        } else {
            iconElement.addClass(icon);
        }

        blockElement.find(".remove").on("click", function(){
            gridStack.removeWidget(blockElement);
        });

        blockElement.attr("data-id", data.id);

        if (data.x === undefined) {
            data.x = 0;
        }

        if (data.y === undefined) {
            data.y = 100;
        }

        if (data.width === undefined) {
            data.width = 3;
        }

        gridStack.addWidget(
            blockElement,
            data.x,
            data.y,
            data.width,
            1
        );
    };

    /**
     * Sets structure
     *
     * @param {Object} structure
     *
     * @returns {ss.window.section.Structure}
     *
     * @private
     */
    ss.window.section.Structure.prototype._setStructure = function (structure) {
        $.each(structure, $.proxy(function(i, lineData) {
            this._addLine(lineData);
        }, this));

        return this;
    };

    /**
     * Adds line
     *
     * @private
     */
    ss.window.section.Structure.prototype._addLine = function (lineData) {
        lineData = $.extend({}, lineData);

        if (lineData.id === undefined) {
            lineData.id = 0;
        }

        if (lineData.name === undefined) {
            lineData.name = this._labels.newLine;
        }

        var lineElement = ss.components.Template.get(
            "section-structure-line"
        );

        var removeButton = lineElement.find(".remove-line");
        removeButton.on("click", $.proxy(function() {
            if (lineData.id === 0) {
                lineElement.remove();
                return false;
            }

            new ss.components.Confirmation(
                {
                    element: removeButton,
                    text: this._labels.deleteLineConfirmText,
                    yes: {
                        label: this._labels.delete,
                        icon: "fas fa-trash"
                    },
                    no: this._labels.no,
                    onClick: function() {
                        lineElement.remove();
                    }
                }
            );
        }, this));

        lineElement.attr("data-id", lineData.id);

        lineElement.find(".line-name").text(lineData.name);

        this._container.append(lineElement);

        var gridStack = lineElement.find(".grid-stack");

        gridStack.gridstack({
            animate: true,
            cellHeight: "60px",
            width: 12,
            verticalMargin: 10,
            resizable: {
                handles: 'w, e',
                classes: {
                    "ui-resizable-w": "fas fa-arrows-alt-h",
                    "ui-resizable-e": "fas fa-arrows-alt-h"
                }
            }
        });

        new ss.forms.Button(
            {
                css: "btn btn-gray btn-small",
                icon: "fas fa-plus",
                label: this._labels.addBlock,
                appendTo: lineElement.find(".line-footer"),
                onClick: $.proxy(function () {
                    new ss.window.section.Blocks({
                        name: "section-blocks",
                        blocks: this._blocks,
                        callback: $.proxy(function(blockData) {
                            this._addBlock(blockData, gridStack.data('gridstack'));
                        }, this)
                    });
                }, this)
            }
        );

        var btnGroup = lineElement.find(".line-header .btn-group");

        new ss.forms.Button(
            {
                css: "btn btn-gray btn-small up",
                icon: "fas fa-chevron-up",
                label: "Up",
                appendTo: btnGroup,
                onClick: $.proxy(function () {
                    lineElement.prev().before(lineElement);
                }, this)
            }
        );

        new ss.forms.Button(
            {
                css: "btn btn-gray btn-small down",
                icon: "fas fa-chevron-down",
                label: "Down",
                appendTo: btnGroup,
                onClick: $.proxy(function () {
                    lineElement.next().after(lineElement);
                }, this)
            }
        );

        if (lineData.blocks !== undefined) {
            setTimeout($.proxy(function(){
                $.each(lineData.blocks, $.proxy(function (i, blockData) {
                    this._addBlock(blockData, gridStack.data('gridstack'));
                }, this));
            }, this), 300);
        }

        this.getBody().scrollTop(100000);
    };

    /**
     * Sets add line button
     *
     * @returns {ss.window.section.Structure}
     *
     * @private
     */
    ss.window.section.Structure.prototype._setAddLineButton = function () {
        new ss.forms.Button(
            {
                css: "btn btn-gray btn-big button",
                icon: "fas fa-plus",
                label: this._labels.addLine,
                appendTo: this.getWindow().find(".footer"),
                onClick: $.proxy(function () {
                    this._addLine();
                }, this)
            }
        );

        return this;
    };

    /**
     * Sets submit button
     *
     * @returns {ss.window.section.Structure}
     *
     * @private
     */
    ss.window.section.Structure.prototype._setSubmitButton = function () {
        return this.setSubmit(
            {
                label: this._labels.save,
                icon: "fas fa-save",
                ajax: {
                    data: {
                        group: "section",
                        controller: "structure",
                        data: $.proxy(
                            function() {
                                return {
                                    id: this._sectionId,
                                    structure: this._getStructure()
                                };
                            },
                            this
                        )
                    },
                    type: "PUT",
                    success: $.proxy(this._onSendSuccess, this)
                }
            }
        );
    };

    /**
     * Gets structure
     *
     * @returns {Array}
     *
     * @private
     */
    ss.window.section.Structure.prototype._getStructure = function () {
        var structure = [];

        this._container.find(".section-structure-line").each(function() {
            var grids = [];

            $(this).find(".grid-stack-item").each(function() {
                grids.push({
                    blockId: $(this).data("id"),
                    x: $(this).data("gs-x"),
                    y: $(this).data("gs-y"),
                    width: $(this).data("gs-width")
                });
            });

            structure.push(
                {
                    id: $(this).data("id"),
                    grids: grids
                }
            );
        });

        return structure;
    };

    /**
     * On send success
     *
     * @private
     */
    ss.window.section.Structure.prototype._onSendSuccess = function () {
        if (this._sectionId === ss.system.App.getSectionId()) {
            window.location.reload();
        } else {
            this.remove();
        }
    };
}(window.jQuery, window.ss);
