/**
 * Abstract form
 */
ss.add(
    "adminComponentsUpload",
    {
        /**
         * Init
         */
        init: function () {
            setTimeout(
                $.proxy(
                    function () {
                        $.ajax(
                            {
                                url: "/api/",
                                type: "POST",
                                cache: false,
                                contentType: false,
                                processData: false,
                                global: false,
                                traditional: true,
                                data: this.getAjaxData(),
                                beforeSend: this.getBeforeSend(),
                                success: this.onSuccess(),
                                error: this.onError(),
                                complete: this.onComplete(),
                                xhr: this.getXhr()
                            }
                        );
                    },
                    this
                ),
                300
            );
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

            $.each(this.getOption("data", {}), function(key, value) {
                if ($.type(value) === "object") {
                    $.each(value, function(valueKey, valueValue) {
                        var formattedKey = key + "[" + valueKey + "]";
                        formData.append(formattedKey, valueValue);
                    });
                } else {
                    formData.append(key, value);
                }
            });

            return formData;
        },

        /**
         * Gets before send function
         *
         * @returns {Function}
         */
        getBeforeSend: function () {
            if ($.type(this.getOption("beforeSend")) === "function") {
                return this.getOption("beforeSend");
            }

            return this.emptyFunction;
        },

        /**
         * Gets success function
         *
         * @returns {Function}
         */
        onSuccess: function () {
            if ($.type(this.getOption("success")) === "function") {
                return this.getOption("success");
            }

            return this.emptyFunction;
        },

        /**
         * Gets error function
         *
         * @returns {Function}
         */
        onError: function () {
            if ($.type(this.getOption("error")) === "function") {
                return this.getOption("error");
            } else {
                return this.displayError;
            }
        },

        /**
         * Displays AJAX error
         *
         * @param {Object} jqXHR
         */
        displayError: function (jqXHR) {
            ss.init("commonComponentsError").displayAjaxError(jqXHR);
        },

        /**
         * Gets complete function
         *
         * @returns {Function}
         */
        onComplete: function () {
            if ($.type(this.getOption("complete")) === "function") {
                return this.getOption("complete");
            }

            return this.emptyFunction;
        },

        /**
         * Gets before send function
         *
         * @returns {Function}
         */
        getXhr: function () {
            if ($.type(this.getOption("xhr")) === "function") {
                return this.getOption("xhr");
            }

            return this.emptyFunction;
        },

        /**
         * Empty function
         */
        emptyFunction: function() {
        }
    }
);
