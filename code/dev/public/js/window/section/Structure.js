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

        this._baseContainer = null;
        this._structureContainer = null;
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
            ._setContainers()
            ._setBlocks(data.blocks)
            ._setStructure(data.structure);

        this.getBody().append(this._baseContainer);
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
        blockElement.data("id", data.id);

        var iconElement = blockElement.find(".icon");
        if (icon === null) {
            iconElement.remove();
        } else {
            iconElement.addClass(icon);
        }

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

    ss.window.section.Structure.prototype._setStructure = function (structure) {
        $.each(structure, $.proxy(function(i, lineData) {
            var lineElement = this._addLine();

            $.each(lineData.blocks, $.proxy(function(i, blockData) {
                var block = this._getBlock(blockData);
                lineElement.append(block);

                var options = {};
                lineElement.gridstack(options);
            }, this));
        }, this));

        return this;
    };

    ss.window.section.Structure.prototype._addLine = function () {
        var lineElement = ss.components.Template.get(
            "section-structure-line"
        );

        this._structureContainer.append(lineElement);

        return lineElement;
    };

    /**
     * On send success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.section.Structure.prototype._onSendSuccess = function (data) {
        console.log(data);
    };
}(window.jQuery, window.ss);
