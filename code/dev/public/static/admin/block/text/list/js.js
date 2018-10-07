ss.add(
    "adminBlockTextList",
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
                    group: "text",
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
                            // new ss.panel.blocks.text.Settings();
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
                                //        group: "text",
                                //        controller: "design",
                                //        id: itemData.id,
                                //        success: function () {
                                //            new ss.panel.blocks.text.List();
                                //        }
                                //    }
                                //);
                            };
                        }

                        var settings = null;
                        if (itemData.canUpdateDesign === true) {
                            settings = function () {
                                //new ss.panel.blocks.text.Settings(
                                //    itemData.id
                                //);
                            };
                        }

                        var open = null;
                        if (itemData.canUpdateContent === true) {
                            open = function () {
                                //new ss.window.blocks.text.Content(itemData.id);
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
    }
);
