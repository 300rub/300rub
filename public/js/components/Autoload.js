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
                success: $.proxy(function (data) {
                    this._options.container.append(data.html);
                    console.log(data.html);
                    console.log(this._options.container);
                }, this),
                error: function (data) {
                    console.log(data);
                }
            });
        }
    };
}(window.jQuery, window.ss);
