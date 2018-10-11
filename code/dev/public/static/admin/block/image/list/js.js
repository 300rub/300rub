!function ($, ss) {
    "use strict";

    var name = "adminBlockImageList";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsPanel",

        /**
         * Init
         */
        init: function () {
            this.create(
                {
                    group: "image",
                    controller: "blocks",
                    back: function () {
                        ss.init("adminBlockList");
                    },
                    hasBlockSectionSwitcher: true
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            if (this.getData("canAdd") === true) {
                this
                    .setFooterButton(
                        {
                            label: this.getLabel("add"),
                            icon: "fas fa-plus",
                            onClick: function () {
                                ss.init("adminBlockImageSettings", {});
                            }
                        }
                    );
            } else {
                this.removeFooter();
            }

            $.each(
                this.getData("list", {}),
                $.proxy(
                    function (i, itemData) {
                        var design = null;
                        if (itemData.canUpdateDesign === true) {
                            design = function () {
                                // new ss.panel.design.Editor(
                                // {
                                // group: "image",
                                // controller: "design",
                                // id: itemData.id,
                                // success: function () {
                                // new ss.panel.blocks.image.List();
                                // }
                                // }
                                // );
                            };
                        }

                        var settings = null;
                        if (itemData.canUpdateDesign === true) {
                            settings = function () {
                                ss.init(
                                    "adminBlockImageSettings",
                                    {
                                        blockId: itemData.id
                                    }
                                );
                            };
                        }

                        var open = null;
                        if (itemData.canUpdateContent === true) {
                            open = function () {
                                ss.init(
                                    "adminBlockImageContent",
                                    {
                                        blockId: itemData.id
                                    }
                                );
                            };
                        }

                        this.addListItem(
                            {
                                label: itemData.name,
                                icon: "fas fa-image",
                                open: open,
                                design: design,
                                settings: settings
                            }
                        );
                    },
                    this
                )
            );
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
