!function ($, TestS) {
    'use strict';

    /**
     * Ajax
     *
     * @type {Object}
     */
    TestS.Ajax = function (options) {
        this._options = $.extend({}, options);
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Ajax.prototype = {

        /**
         * _options
         *
         * @var {Object}
         */
        _options: {},

        /**
         * Init
         */
        init: function () {
            setTimeout($.proxy(function(){
                $.ajax({
                    url: "/api/",
                    contentType: "application/json",
                    accepts: "application/json",
                    dataType: "json",
                    global: false,
                    traditional: true,
                    data: this._getData(),
                    type: this._getType(),
                    beforeSend: this._getBeforeSend(),
                    success: this._getSuccess(),
                    error: this._getError(),
                    complete: this._getComplete()
                });
            }, this), 1000);

        },

        /**
         * Gets data
         *
         * @returns {Object}
         *
         * @private
         */
        _getData: function () {
            var data = $.extend(
                {
                    language: TestS.getLanguage(),
                    token: TestS.getToken()
                },
                this._options.data
            );

            if (this._getType() === "GET") {
                return decodeURIComponent($.param(data));
            } else {
                return JSON.stringify(data);
            }
        },

        /**
         * Gets type
         *
         * @returns {Object}
         *
         * @private
         */
        _getType: function () {
            switch (this._options.type) {
                case "POST":
                    return "POST";
                case "PUT":
                    return "PUT";
                case "DELETE":
                    return "DELETE";
            }

            return "GET";
        },

        /**
         * Gets before send function
         *
         * @returns {Function}
         *
         * @private
         */
        _getBeforeSend: function() {
            if ($.type(this._options.beforeSend) !== "function") {
                return this._beforeSend;
            }

            return this._options.beforeSend;
        },

        /**
         * Default before send function
         *
         * @private
         */
        _beforeSend: function() {

        },

        /**
         * Gets success function
         *
         * @returns {Function}
         *
         * @private
         */
        _getSuccess: function() {
            if ($.type(this._options.success) !== "function") {
                return this._success;
            }

            return this._options.success;
        },

        /**
         * Default success function
         *
         * @param {Object} [data]
         *
         * @private
         */
        _success: function(data) {

        },

        /**
         * Gets error function
         *
         * @returns {Function}
         *
         * @private
         */
        _getError: function() {
            if ($.type(this._options.error) !== "function") {
                return this._error;
            }

            return this._options.error;
        },

        /**
         * AJAX error callback function
         *
         * @param {jqXHR}  [jqXHR]       jQuery XMLHttpRequest
         * @param {String} [textStatus]  Text status
         * @param {String} [errorThrown] Error thrown
         *
         * @private
         */
        _error: function (jqXHR, textStatus, errorThrown) {

        },

        /**
         * Gets complete function
         *
         * @returns {Function}
         *
         * @private
         */
        _getComplete: function() {
            if ($.type(this._options.complete) !== "function") {
                return this._complete;
            }

            return this._options.complete;
        },

        /**
         * Default complete function
         *
         * @private
         */
        _complete: function() {

        }
    };

    /**
     * Gets error template
     *
     * @param {Object} jqXHR
     *
     * @returns {Object}
     */
    TestS.Ajax.getErrorTemplate = function(jqXHR) {
        var $template = TestS.Template.get("ajax-error");
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
}(window.jQuery, window.TestS);