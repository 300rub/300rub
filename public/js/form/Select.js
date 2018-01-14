!function ($, TestS) {
    'use strict';

    /**
     * Select form
     *
     * @param {Object} options
     */
    TestS.Form.Select = function (options) {
        this.set("form-container-select", options);
        this.init();
    };

    /**
     * Select form prototype
     *
     * @type {Object}
     */
    TestS.Form.Select.prototype = {

        /**
         * Constructor
         */
        constructor: TestS.Form.Select,

        /**
         * Init
         */
        init: function () {
            var t = this;

            var optionTemplate = t.getForm().find(".option-template");

            var list = t.getOption("list");
            if ($.type(list) === "array") {
                $.each(
                    list,
                    function (i, object) {
                        var option = optionTemplate.clone()
                        .attr("value", object.key)
                        .text(object.value);

                        if (object.css !== undefined) {
                            option.addClass(object.css);
                        }

                        if (object.style !== undefined) {
                            option.attr("style", object.style);
                        }

                        option.appendTo(t.getInstance());
                    }
                );
            }

            optionTemplate.remove();

            t.getInstance().val(t.getOption("value"));

            var onChange = t.getOption("onChange");
            if ($.type(onChange) === "function") {
                t.getInstance().on(
                    "change",
                    function () {
                        onChange(
                            TestS.Library.getIntVal($(this).val())
                        );
                    }
                );
            }
        }
    };

    /**
     * Extends prototype
     */
    TestS.Form.Select.prototype = $.extend(
        TestS.Form.prototype,
        TestS.Form.Select.prototype
    );
}(window.jQuery, window.TestS);
