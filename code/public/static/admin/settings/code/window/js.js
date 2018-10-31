!function ($, ss) {
    "use strict";

    var name = "adminSettingsCodeWindow";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminSettingsCodeWindow",

        /**
         * Forms
         *
         * @var {Object}
         */
        forms: {},

        /**
         * Init
         */
        init: function () {
            this.forms = {};

            this.create(
                {
                    group: "settings",
                    controller: "code",
                    data: {
                        type: this.getOption("type")
                    },
                    name: "create-site"
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            this.forms.value = ss.init(
                "commonComponentsFormTextarea",
                $.extend(
                    {},
                    this.getData(["forms", "value"], {}),
                    {
                        appendTo: this.getBody(),
                        rows: 15
                    }
                )
            );

            this.setSubmit(
                {
                    label: this.getLabel("button"),
                    icon: "fas fa-save",
                    forms: this.forms,
                    ajax: {
                        data: {
                            group: "settings",
                            controller: "code",
                            data: {
                                type: this.getData("type")
                            }
                        },
                        type: "PUT",
                        success: $.proxy(this.onSendSuccess, this)
                    }
                }
            );
        },

        /**
         * On send success
         */
        onSendSuccess: function () {
            window.location.reload();
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
