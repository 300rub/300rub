!function ($, ss) {
    "use strict";

    var name = "adminBlockTextList";

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
                    group: "text",
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
                                ss.init("adminBlockTextSettings", {});
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
                                ss.init(
                                    "adminComponentsDesignEditor",
                                    {
                                        group: "text",
                                        controller: "design",
                                        blockId: itemData.id,
                                        onBack: function () {
                                            ss.init("adminBlockTextList");
                                        },
                                        success: function () {
                                            ss.init("adminBlockTextList");
                                        }
                                    }
                                );
                            };
                        }

                        var settings = null;
                        if (itemData.canUpdateSettings === true) {
                            settings = function () {
                                ss.init(
                                    "adminBlockTextSettings",
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
                                    "adminBlockTextContent",
                                    {
                                        blockId: itemData.id
                                    }
                                );
                            };
                        }

                        this.addListItem(
                            {
                                label: itemData.name,
                                icon: "fas fa-font",
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
