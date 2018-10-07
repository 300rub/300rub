ss.add(
    "adminBlockList",
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
                    group: "block",
                    controller: "blocks",
                    hasFooter: false,
                    hasBlockSectionSwitcher: true
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function() {
            $.each(
                this.getData("list", {}),
                $.proxy(
                    function (i, itemData) {
                        var icon = null;
                        var open = null;

                        switch (itemData.type) {
                            case 1:
                                icon = "fas fa-font";
                                open = function() {
                                    //new ss.panel.blocks.text.List();
                                };
                                break;
                            case 2:
                                icon = "fas fa-images";
                                open = function() {
                                    ss.init("adminBlockImageList");
                                };
                                break;
                            case 3:
                                icon = "far fa-newspaper";
                                break;
                            case 5:
                                icon = "fas fa-bars";
                                break;
                            default:
                                break;
                        }

                        this.addListItem(
                            {
                                label: itemData.name,
                                icon: icon,
                                open: open
                            }
                        );
                    },
                    this
                )
            );
        }
    }
);
