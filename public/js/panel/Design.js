!function ($, TestS) {
    'use strict';

    /**
     * Design panel
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    TestS.Panel.Design = function (options) {
        this._options = $.extend({}, options);
        this._panel = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Design.prototype = {
        /**
         * Init
         */
        init: function () {
            this._panel = new TestS.Panel({
                controller: this._options.controller,
                action: this._options.action,
                success: $.proxy(this._onLoadDataSuccess, this)
            });
        },

        /**
         * On load panel success
         *
         * @param {Object} [data]
         *
         * @private
         */
        _onLoadDataSuccess: function(data) {
            this._panel
                .setTitle(data.title)
                .setDescription(data.description);

            this._panel
                .setMaxHeight()
                .removeLoading();
        }
    };
}(window.jQuery, window.TestS);