ss.add(
    "adminReleasePanel",
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
                    group: "release",
                    controller: "shortInfo"
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function() {
            this.setSubmit(
                {
                    label: this.getLabel("button"),
                    icon: "fas fa-truck",
                    ajax: {
                        data: {
                            group: "release",
                            controller: "release"
                        },
                        type: "POST",
                        success: $.proxy(this.onSendSuccess, this)
                    }
                }
            );

            this.addListItem(
                {
                    label: this.getLabel("moreInfo"),
                    icon: "fas fa-info",
                    open: function() {
                        ss.init("adminReleaseWindow");
                    }
                }
            );
        },

        /**
         * On send success
         */
        onSendSuccess: function() {
            window.location.reload();
        }
    }
);
