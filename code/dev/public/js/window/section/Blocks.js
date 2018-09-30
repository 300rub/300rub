!function ($, ss) {
    'use strict';

    /**
     * Section structure window
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    ss.window.section.Blocks = function (options) {
        ss.window.AbstractHelper.call(this, options);

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.section.Blocks.prototype
        = Object.create(ss.window.AbstractHelper.prototype);

    /**
     * Constructor
     */
    ss.window.section.Blocks.prototype.constructor = ss.window.section.Blocks;

    /**
     * Init
     */
    ss.window.section.Blocks.prototype.init = function () {
        $.each(this.getOption("blocks"), $.proxy(function(i, blockGroup){
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
                    appendTo: this.getBody()
                }
            );
        }, this));

        ss.components.accordion.Container(this.getBody());
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
    ss.window.section.Blocks.prototype._getBlock = function (data) {
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
            "section-block"
        );

        blockElement.find(".name").text(data.name);

        var iconElement = blockElement.find(".icon");
        if (icon === null) {
            iconElement.remove();
        } else {
            iconElement.addClass(icon);
        }

        blockElement.on("click", $.proxy(function() {
            var callback = this.getOption("callback");
            if ($.type(callback) === "function") {
                callback(
                    {
                        id: data.id,
                        type: data.type,
                        name: data.name
                    }
                );
            }

            this.remove();
        }, this));

        return blockElement;
    };
}(window.jQuery, window.ss);
