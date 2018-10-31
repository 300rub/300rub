!function ($, ss) {
    "use strict";

    var name = "adminComponentsUpload";

    var parameters = {
        /**
         * Init
         */
        init: function () {
            var ajax = {
                url: "/api/",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                global: false,
                traditional: true,
                data: this.getAjaxData()
            };

            if ($.type(this.getOption("beforeSend")) === "function") {
                ajax.beforeSend = this.getOption("beforeSend");
            }

            if ($.type(this.getOption("success")) === "function") {
                ajax.success = this.getOption("success");
            }

            if ($.type(this.getOption("error")) === "function") {
                ajax.error = this.getOption("error");
            } else {
                ajax.error = this.displayError;
            }

            if ($.type(this.getOption("complete")) === "function") {
                ajax.complete = this.getOption("complete");
            }

            if ($.type(this.getOption("xhr")) === "function") {
                ajax.xhr = this.getOption("xhr");
            }

            $.ajax(ajax);
        },

        /**
         * Gets data
         *
         * @returns {Object}
         */
        getAjaxData: function () {
            var formData = new FormData();

            formData.append("file", this.getOption("file"));
            formData.append("language", ss.init("app").getLanguage());
            formData.append("token", ss.init("app").getToken());

            $.each(
                this.getOption("data", {}),
                function (key, value) {
                    if ($.type(value) === "object") {
                        $.each(
                            value,
                            function (valueKey, valueValue) {
                                var formattedKey = key + "[" + valueKey + "]";
                                formData.append(formattedKey, valueValue);
                            }
                        );
                    } else {
                        formData.append(key, value);
                    }
                }
            );

            return formData;
        },

        /**
         * Displays AJAX error
         *
         * @param {Object} jqXHR
         */
        displayError: function (jqXHR) {
            ss.init("commonComponentsError").displayAjaxError(jqXHR);
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
