!function ($, TestS) {
    'use strict';

    /**
     * Window
     *
     * @type {Object}
     */
    TestS.Window = function (options) {
        this._options = $.extend({}, options);
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Window.prototype = {

        /**
         * _options
         *
         * @var {Object}
         */
        _options: {},

        instance: null,
        overlay: null,

        /**
         * Init
         */
        init: function () {
            this.instance = TestS.getTemplates().find(".window").clone();
            this.overlay = TestS.getTemplates().find(".window-overlay").clone();

            TestS.appendToAjaxWrapper(this.instance);
            TestS.appendToAjaxWrapper(this.overlay);
        }
    };
}(window.jQuery, window.TestS);