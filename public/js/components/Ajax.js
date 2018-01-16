!function ($, TestS) {
    'use strict';

    /**
     * Ajax
     *
     * @param {Object} options
     */
    TestS.Components.Ajax = function (options) {
        this._options = $.extend({}, options);
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Components.Ajax.prototype = {

        /**
         * Constructor
         */
        constructor: TestS.Components.Ajax,

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
         *
         * @private
         */
        _getData: function () {
            var data = $.extend(
                {
                    language: TestS.System.App.getLanguage(),
                    token: TestS.System.App.getToken()
                },
                this._options.data
            );

            if (this._getType() === "GET") {
                return decodeURIComponent($.param(data));
            }

            return window.JSON.stringify(data);
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
        _getBeforeSend: function () {
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
        _beforeSend: function () {

        },

        /**
         * Gets success function
         *
         * @returns {Function}
         *
         * @private
         */
        _getSuccess: function () {
            if ($.type(this._options.success) === "function") {
                return this._options.success;
            }
        },

        /**
         * Gets error function
         *
         * @returns {Function}
         *
         * @private
         */
        _getError: function () {
            if ($.type(this._options.error) === "function") {
                return this._options.error;
            }
        },

        /**
         * Gets complete function
         *
         * @returns {Function}
         *
         * @private
         */
        _getComplete: function () {
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
        _complete: function () {
        }
    };
}(window.jQuery, window.TestS);
