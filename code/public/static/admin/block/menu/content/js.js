!function ($, ss) {
    "use strict";

    var name = "adminBlockMenuContent";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsWindowAbstract",

        /**
         * Init
         */
        init: function () {
            this.create(
                {
                    group: "menu",
                    controller: "content",
                    data: {
                        blockId: this.getOption("blockId")
                    },
                    name: "menu-content"
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {


            this.setSubmit(
                {
                    label: this.getLabel("button"),
                    icon: "fas fa-save",
                    forms: this.forms,
                    ajax: {
                        data: {
                            group: "menu",
                            controller: "content",
                            data: {
                                blockId: this.getData("blockId")
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
            console.log(1);
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
