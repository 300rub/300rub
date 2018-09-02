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
        console.log(data);

        this
            .setTitle(data.title);

        var sectionStructure = ss.components.Template.get("section-structure");

        var blocksContainer = sectionStructure.find(".blocks-container");

        $.each(data.blocks, function(i, blockGroup){
            console.log(blockGroup);

            var icon;
            switch (blockGroup.type) {
                case 1:
                    icon = "fas fa-font";
                    break;
                default:
                    icon = null;
                    break;
            }

            var typeContainer = ss.components.Template.get(
                "section-structure-type-container"
            );

            $.each(blockGroup.blocks, function(i, block) {
                var blockElement = ss.components.Template.get(
                    "section-structure-block"
                );

                blockElement.find(".name").text(block.name + "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");
                blockElement.data("id", block.id);

                var iconElement = blockElement.find(".icon");
                if (icon === null) {
                    iconElement.remove();
                } else {
                    iconElement.addClass(icon);
                }

                blockElement.appendTo(typeContainer);
            });

            new ss.components.accordion.Element(
                {
                    title: blockGroup.name,
                    body: typeContainer,
                    appendTo: blocksContainer
                }
            );
        });

        ss.components.accordion.Container(blocksContainer);

        this.getBody().append(sectionStructure);
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
