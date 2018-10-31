!function ($, ss) {
    "use strict";

    var name = "commonComponentsError";

    var parameters = {
        /**
         * Singleton flag
         *
         * @var {boolean}
         */
        isSingleton: true,

        /**
         * Errors
         *
         * @var {Object}
         */
        errors: {},

        /**
         * Init
         */
        init: function () {
        },

        /**
         * Sets an error
         *
         * @param {String} key
         * @param {String} value
         */
        set: function (key, value) {
            this.errors[key] = value;
        },

        /**
         * Gets an error
         *
         * @param {String} key
         *
         * @returns {String}
         */
        get: function (key) {
            if (this.errors[key] === undefined) {
                return key;
            }

            return this.errors[key];
        },

        /**
         * Gets error template
         *
         * @param {Object} jqXHR
         *
         * @returns {Object}
         */
        getAjaxErrorTemplate: function (jqXHR) {
            var template = ss.init("template").get("ajax-error");
            var message = "Error";
            var file = "";
            var trace = [];

            if ($.type(jqXHR) === "object"
                && $.type(jqXHR.responseJSON) === "object"
                && $.type(jqXHR.responseJSON.error) === "object"
            ) {
                if (jqXHR.responseJSON.error.message !== undefined) {
                    message = jqXHR.responseJSON.error.message;
                }

                if (jqXHR.responseJSON.error.file !== undefined) {
                    file = jqXHR.responseJSON.error.file;
                }

                if (jqXHR.responseJSON.error.trace !== undefined) {
                    trace = jqXHR.responseJSON.error.trace;
                }
            }

            template.find(".message").text(message);

            var fileElement = template.find(".file");
            if (file !== "") {
                fileElement.text(file);
            } else {
                fileElement.remove();
            }

            var traceElement = template.find(".trace");
            if (trace.length !== 0) {
                var traceText = "";
                $.each(
                    trace,
                    function (i, item) {
                        traceText += "#";
                        traceText += i;
                        traceText += " ";
                        traceText += item.file;
                        traceText += " (";
                        traceText += item.line;
                        traceText += ") ";
                        traceText += "<br/>";
                    }
                );

                traceElement.html(traceText);
            } else {
                traceElement.remove();
            }

            return template;
        },

        /**
         * Displays AJAX error
         *
         * @param {Object} jqXHR
         */
        displayAjaxError: function (jqXHR) {
            var errorTemplate
                = this.getAjaxErrorTemplate(jqXHR);
            ss.init("app").append(errorTemplate);

            errorTemplate.removeClass("transparent");

            setTimeout(
                function () {
                    errorTemplate.addClass("transparent");
                    setTimeout(
                        function () {
                            errorTemplate.remove();
                        },
                        1000
                    );
                },
                7000
            );
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
