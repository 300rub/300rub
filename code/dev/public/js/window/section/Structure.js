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
        this._baseContainer = null;
        this._structureContainer = null;
        this._labels = {};
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

        this.getBody().append(this._baseContainer);
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
        this._baseContainer = ss.components.Template.get("section-structure");
        this._structureContainer = this._baseContainer.find(".structure-container");
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
        var blocksContainer = this._baseContainer.find(".blocks-container");

        $.each(blocks, $.proxy(function(i, blockGroup){
            var typeContainer = ss.components.Template.get(
                "section-structure-type-container"
            );

            $.each(blockGroup.blocks, $.proxy(function(i, blockData) {
                this._getBlock(blockData).appendTo(typeContainer);
            }, this));

            new ss.components.accordion.Element(
                {
                    title: blockGroup.name,
                    body: typeContainer,
                    appendTo: blocksContainer
                }
            );
        }, this));

        ss.components.accordion.Container(blocksContainer);

        return this;
    };

    /**
     * Gets block
     *
     * @param {Object} data
     *
     * @returns {Object}
     *
     * @private
     */
    ss.window.section.Structure.prototype._getBlock = function (data) {
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
            "section-structure-block"
        );

        blockElement.find(".name").text(data.name);

        var iconElement = blockElement.find(".icon");
        if (icon === null) {
            iconElement.remove();
        } else {
            iconElement.addClass(icon);
        }

        blockElement.attr("data-id", data.id);

        if (data.x !== undefined) {
            blockElement.attr("data-gs-x", data.x);
        }

        if (data.y !== undefined) {
            blockElement.attr("data-gs-y", data.y);
        }

        if (data.width !== undefined) {
            blockElement.attr("data-gs-width", data.width);
        }

        return blockElement;
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
            var lineElement = this._addLine();
            var gridStack = lineElement.find(".grid-stack");

            lineElement.attr("data-id", lineData.id);

            $.each(lineData.blocks, $.proxy(function(i, blockData) {
                var block = this._getBlock(blockData);
                gridStack.append(block);
            }, this));

            var options = {
                animate: true,
                cellHeight: "60px",
                height: 1,
                disableOneColumnMode: true,
                width: 12,
                resizable: {
                    handles: 'w, e',
                    classes: {
                        "ui-resizable-w": "fas fa-arrows-alt-h",
                        "ui-resizable-e": "fas fa-arrows-alt-h"
                    }
                }
            };

            gridStack.gridstack(options);
        }, this));

        return this;
    };

    /**
     * Adds line
     *
     * @returns {Object}
     *
     * @private
     */
    ss.window.section.Structure.prototype._addLine = function () {
        var lineElement = ss.components.Template.get(
            "section-structure-line"
        );

        lineElement.find(".remove-line").on("click", $.proxy(function() {
            lineElement.remove();
            this._updateLineNames();
        }, this));

        this._structureContainer.append(lineElement);

        this._updateLineNames();

        return lineElement;
    };

    /**
     * Updates line numbers
     *
     * @returns {ss.window.section.Structure}
     *
     * @private
     */
    ss.window.section.Structure.prototype._updateLineNames = function () {
        var lineLabel = this._labels.line;

        this._structureContainer.find(".section-structure-line").each(function(i) {
            $(this).find(".line-name").text(lineLabel + " " + (i + 1));
        });

        return this;
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
                css: "btn btn-gray",
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
                    success: this._onSendSuccess
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

        this._structureContainer.find(".section-structure-line").each(function() {
            var lineStructure = [];

            $(this).find(".section-structure-block").each(function() {
                lineStructure.push({
                    id: $(this).data("id"),
                    x: $(this).data("x"),
                    y: $(this).data("y"),
                    width: $(this).data("width")
                });
            });

            structure.push(lineStructure);
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
