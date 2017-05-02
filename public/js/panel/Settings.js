!function ($, TestS) {
    'use strict';

    /**
     * Settings panel
     *
     * @type {Object}
     */
    TestS.Panel.Settings = function () {
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Settings.prototype = {

        /**
         * @var {Window.TestS.Panel}
         */
        _panel: null,

        /**
         * Init
         */
        init: function () {
            this._panel = new TestS.Panel({
                controller: "settings",
                action: "settings",
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
            console.log(data);



            this._panel.removeLoading();
        }
    };
}(window.jQuery, window.TestS);