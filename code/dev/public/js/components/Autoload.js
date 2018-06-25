!function ($, ss) {
    'use strict';

    /**
     * Autoload
     *
     * @param {Object} [options]
     *
     * @type {Object}
     */
    ss.components.Autoload = function (options) {
        this._options = $.extend({}, options);
        this._page = 1;
        this._canLoad = true;
        this._interval = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.components.Autoload.prototype = {

        /**
         * Constructor
         */
        constructor: ss.components.Autoload,

        /**
         * Init
         */
        init: function () {
            this._interval = setInterval($.proxy(function() {
                if (this._isLoad() === true) {
                    this._load();
                }
            }, this), 1000);
        },

        /**
         * Loads data
         *
         * @private
         */
        _load: function() {
            new ss.components.Ajax({
                data: {
                    group: this._options.group,
                    controller: this._options.controller,
                    data: {
                        page: this._page + 1,
                        blockId: this._options.blockId,
                        sectionId: ss.system.App.getSectionId()
                    }
                },
                beforeSend: $.proxy(function () {
                    this._canLoad = false;
                }, this),
                success: $.proxy(function (data) {
                    var html = $.trim(data.html);
                    if (html === "") {
                        clearInterval(this._interval);
                        this._options.element.remove();
                    }
                    this._options.container.append(html);
                }, this),
                error: $.proxy(function () {
                    clearInterval(this._interval);
                    this._options.element.remove();
                }, this),
                complete: $.proxy(function () {
                    this._canLoad = true;
                    this._page++;
                }, this)
            });
        },

        /**
         * Is load data?
         *
         * @returns {boolean}
         *
         * @private
         */
        _isLoad: function () {
            if (this._canLoad === false) {
                return false;
            }

            var top = this._options.element.offset().top - 100;

            return ($(document).scrollTop() + $(window).height()) > top;
        }
    };
}(window.jQuery, window.ss);
