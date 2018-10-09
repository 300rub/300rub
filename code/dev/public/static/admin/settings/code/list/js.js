ss.add(
    "adminSettingsCodeList",
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
                    group: "settings",
                    controller: "codeList",
                    hasFooter: false,
                    back: function() {
                        ss.init("adminSettingsList");
                    }
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
                    function (i, listItem) {
                        this.addListItem(
                            {
                                label: listItem.name,
                                icon: "fas fa-code",
                                open: function() {
                                    ss.init(
                                        "adminSettingsUserList",
                                        {
                                            type: listItem.type
                                        }
                                    );
                                }
                            }
                        );
                    },
                    this
                )
            );
        }
    }
);
