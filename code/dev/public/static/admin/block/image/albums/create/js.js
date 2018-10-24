!function ($, ss) {
    "use strict";

    var name = "adminBlockImageAlbumsCreate";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsWindowAbstract",

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
            this.create(
                {
                    group: "image",
                    controller: "album",
                    data: {
                        blockId: this.getOption("blockId")
                    },
                    name: "image-content"
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            var seo = ss.init(
                "commonComponentsFormSeo",
                this.getData("forms", {})
            );
            seo.getContainer().appendTo(this.getBody());
            this.forms = $.extend({}, seo.getForms());

            this.setSubmit(
                {
                    label: this.getLabel("button"),
                    icon: "fas fa-save",
                    ajax: {
                        data: {
                            group: "image",
                            controller: "album",
                            forms: this.forms,
                            data: {
                                blockId: this.getData("blockId")
                            }
                        },
                        type: "POST",
                        success: $.proxy(this.onSendSuccess, this)
                    }
                }
            );
        },

        /**
         * On send success
         */
        onSendSuccess: function () {
            this.remove(true);
            
            ss.init(
                "commonContentBlockUpdate",
                {
                    list: [
                        this.getOption("blockId")
                    ]
                }
            );
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
