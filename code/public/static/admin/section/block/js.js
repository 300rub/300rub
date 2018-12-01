!function ($, ss) {
    "use strict";

    var name = "adminSectionBlock";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsWindowHelper",

        /**
         * Init
         */
        init: function () {
            this.create(
                {
                    name: "section-blocks"
                }
            );

            var tree = [];
            $.each(
                this.getOption("blocks", {}),
                $.proxy(
                    function (i, blockGroup) {
                        var body = ss.init("template").get(
                            "section-structure-type-container"
                        );

                        $.each(
                            blockGroup.blocks,
                            $.proxy(
                                function (i, blockData) {
                                    this.getBlock(blockData).appendTo(body);
                                },
                                this
                            )
                        );

                        tree.push(
                            {
                                title: blockGroup.name,
                                body: body
                            }
                        );
                    },
                    this
                )
            );

            ss.init(
                "commonComponentsAccordion",
                {
                    tree: tree,
                    container: this.getBody()
                }
            );
        },

        /**
         * Gets block
         *
         * @param {Object} data
         *
         * @returns {Object}
         */
        getBlock: function (data) {
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

            var blockElement = ss.init("template").get("section-block");

            blockElement.find(".name").text(data.name);

            var iconElement = blockElement.find(".icon");
            if (icon === null) {
                iconElement.remove();
            } else {
                iconElement.addClass(icon);
            }

            blockElement.on(
                "click",
                $.proxy(
                    function () {
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
                    },
                    this
                )
            );

            return blockElement;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
