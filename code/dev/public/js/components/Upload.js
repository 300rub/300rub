!function ($, ss) {
    'use strict';

    /**
     * Ajax
     *
     * @param {Object} options
     */
    ss.components.Upload = function (options) {
        this._options = $.extend({}, options);
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.components.Upload.prototype = {

        /**
         * Constructor
         */
        constructor: ss.components.Upload,

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
                                data: this._getData(),
                                beforeSend: this._getBeforeSend(),
                                success: this._getSuccess(),
                                error: this._getError(),
                                complete: this._getComplete(),
                                xhr: this._getXhr()
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
            var formData = new FormData();

            formData.append("file", this._options.file);
            formData.append(language, ss.system.App.getLanguage());
            formData.append(token, ss.system.App.getToken());
            
            $.each(this._options.data, function(key, value) {
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
         *
         * @private
         */
        _getBeforeSend: function () {
            if ($.type(this._options.beforeSend) === "function") {
                return this._options.beforeSend;
            }

            return null;
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

            return null;
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
            } else {
                return this._displayError;
            }
        },

        /**
         * Displays AJAX error
         *
         * @param {Object} jqXHR
         *
         * @returns {Function}
         *
         * @private
         */
        _displayError: function (jqXHR) {
            ss.components.Error.displayAjaxError(jqXHR);
        },

        /**
         * Gets complete function
         *
         * @returns {Function}
         *
         * @private
         */
        _getComplete: function () {
            if ($.type(this._options.complete) === "function") {
                return this._options.complete;
            }

            return null;
        },

        /**
         * Gets before send function
         *
         * @returns {Function}
         *
         * @private
         */
        _getXhr: function () {
            if ($.type(this._options.xhr) === "function") {
                return this._options.xhr;
            }

            return null;
        }
    };
}(window.jQuery, window.ss);
