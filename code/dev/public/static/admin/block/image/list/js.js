ss.add(
    "adminBlockImageList",
    {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsPanel",

        /**
         * Init
         */
        init: function() {
            this.create(
                {
                    group: "image",
                    controller: "blocks",
                    back: function() {
                        ss.init("adminBlockList");
                    },
                    hasBlockSectionSwitcher: true
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function() {
            if (this.getData("canAdd") === true) {
                this
                    .setFooterButton({
                        label: this.getLabel("add"),
                        icon: "fas fa-plus",
                        onClick: function () {
                            //new ss.panel.blocks.image.Settings();
                        }
                    });
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
                                //new ss.panel.design.Editor(
                                //    {
                                //        group: "image",
                                //        controller: "design",
                                //        id: itemData.id,
                                //        success: function () {
                                //            new ss.panel.blocks.image.List();
                                //        }
                                //    }
                                //);
                            };
                        }

                        var settings = null;
                        if (itemData.canUpdateDesign === true) {
                            settings = function () {
                                //new ss.panel.blocks.image.Settings(
                                //    itemData.id
                                //);
                            };
                        }

                        var open = function () {
                            //new ss.window.blocks.image.Content(
                            //    {
                            //        blockId: itemData.id
                            //    }
                            //);
                        };

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
    }
);
