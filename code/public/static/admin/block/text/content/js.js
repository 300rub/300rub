!function ($, ss) {
    "use strict";

    var name = "adminBlockTextContent";

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
         * @avr {Object}
         */
        forms: {},

        /**
         * Init
         */
        init: function () {
            this.forms = {};

            this.create(
                {
                    group: "text",
                    controller: "content",
                    data: {
                        id: this.getOption("blockId")
                    },
                    name: "text-content"
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            if (this.getData("type") === 0) {
                this.forms.text = ss.init(
                    "commonComponentsFormTextarea",
                    $.extend(
                        {},
                        this.getData(["forms", "text"], {}),
                        {
                            appendTo: this.getBody(),
                            rows: 15,
                            label: null
                        }
                    )
                );
            } else {
                this.forms.text = ss.init(
                    "commonComponentsFormText",
                    $.extend(
                        {},
                        this.getData(["forms", "text"], {}),
                        {
                            appendTo: this.getBody(),
                            label: null
                        }
                    )
                );
            }

            if (this.getData("hasEditor") === true) {
                ss.init("adminBlockTextEditor", {
                    item: this.forms.text,
                    group: "text",
                    controller: "file",
                    blockId: this.getOption("blockId")
                });
            }

            this.setSubmit(
                {
                    label: this.getLabel("button"),
                    icon: "fas fa-save",
                    forms: this.forms,
                    ajax: {
                        data: {
                            group: "text",
                            controller: "content",
                            data: {
                                id: this.getData("id")
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
            this.remove();

            if (this.getOption("blockId") !== 0) {
                ss.init(
                    "commonContentBlockUpdate",
                    {
                        list: [this.getOption("blockId")]
                    }
                );
            }
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
