!function ($, ss) {
    'use strict';

    /**
     * Errors
     *
     * @var {Object}
     */
    ss.components.Error = {

        /**
         * Errors
         *
         * @var {Object}
         */
        _errors: {},

        /**
         * Sets an error
         *
         * @param {String} key
         * @param {String} value
         */
        set: function (key, value) {
            this._errors[key] = value;
        },

        /**
         * Gets an error
         *
         * @param {String} key
         *
         * @returns {String}
         */
        get: function (key) {
            if (this._errors[key] === undefined) {
                return key;
            }

            return this._errors[key];
        },

        /**
         * Gets error template
         *
         * @param {Object} jqXHR
         *
         * @returns {Object}
         */
        getAjaxErrorTemplate: function (jqXHR) {
            var $template = ss.components.Template.get("ajax-error");
            var message = "Error";
            var file = "";
            var line = "";
            var trace = "";

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

                if (jqXHR.responseJSON.error.line !== undefined) {
                    line = jqXHR.responseJSON.error.line;
                }

                if (jqXHR.responseJSON.error.trace !== undefined) {
                    trace = jqXHR.responseJSON.error.trace;
                }
            }

            $template.find(".message").text(message);
            if (file !== "") {
                $template.find(".file").text(file);
            }

            if (line !== "") {
                $template.find(".line").text(" (" + line + ")");
            }

            if (trace !== "") {
                $template.find(".trace").html(trace.replace("\n", "<br/>"));
            }

            return $template;
        }
    };
}(window.jQuery, window.ss);
