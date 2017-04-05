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
            $.ajax({
                url: "/api/",
                contentType: "application/json",
                accepts: "application/json",
                dataType: "json",
                global: false,
                cache: false,
                traditional: true,
                data: this._getData(),
                type: this._getType(),
                beforeSend: this._getBeforeSend(),
                success: this._getSuccess(),
                error: this._getError()
            });
        },

        /**
         * Gets data
         *
         * @returns {Object}
         *
         * @private
         */
        _getData: function () {
            return $.extend(
                {
                    language: TestS.getLanguage()
                },
                this._options.data
            );
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

        }
    };
}(window.jQuery, window.TestS);