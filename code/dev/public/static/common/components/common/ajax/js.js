ss.add(
    "commonComponentsCommonAjax",
    {

        /**
         * Init
         */
        init: function() {
            $.ajax(
                {
                    url: "/api/",
                    contentType: "application/json",
                    accepts: "application/json",
                    dataType: "json",
                    global: false,
                    traditional: true,
                    data: this.getData(),
                    type: this.getType(),
                    beforeSend: this.getBeforeSend(),
                    success: this.getSuccess(),
                    error: this.getError(),
                    complete: this.getComplete()
                }
            );
        },

        /**
         * Gets data
         *
         * @returns {Object}
         */
        getData: function () {
            var data = $.extend(
                {},
                this.getOption("data"),
                {
                    language: ss.system.App.getLanguage(),
                    token: ss.system.App.getToken()
                }
            );

            if (this.getType() === "GET") {
                return decodeURIComponent($.param(data));
            }

            return window.JSON.stringify(data);
        },

        /**
         * Gets type
         *
         * @returns {Object}
         */
        getType: function () {
            switch (this.getOption("type")) {
                case "POST":
                    return "POST";
                case "PUT":
                    return "PUT";
                case "DELETE":
                    return "DELETE";
                default:
                    return "GET";
            }

            
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
        getSuccess: function () {
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
        getError: function () {
            if ($.type(this.getOption("error") === "function")) {
                return this.getOption("error");
            } else {
                return this.displayError;
            }
        },

        /**
         * Displays AJAX error
         *
         * @param {Object} jqXHR
         *
         * @returns {Function}
         */
        displayError: function (jqXHR) {
            ss.components.Error.displayAjaxError(jqXHR);
        },

        /**
         * Gets complete function
         *
         * @returns {Function}
         */
        getComplete: function () {
            if ($.type(this.getOption("complete") === "function")) {
                return this.getOption("complete");
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
