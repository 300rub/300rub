ss.add(
    "adminSettingsList",
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
                    controller: "settings",
                    hasFooter: false
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
                    function (key, name) {
                        var icon = null;
                        var open = null;

                        switch (key) {
                            case "users":
                                icon = "fas fa-user-friends";
                                open = function () {
                                    //new ss.window.users.List();
                                };
                                break;
                            case "icon":
                                icon = "fas fa-image";
                                break;
                            case "hiddenCode":
                                icon = "fas fa-code";
                                open = function () {
                                    //new ss.panel.settings.CodeList();
                                };
                                break;
                            default:
                                break;
                        }

                        this.addListItem(
                            {
                                label: name,
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
