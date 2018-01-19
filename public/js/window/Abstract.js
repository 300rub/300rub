!function ($, TestS) {
    'use strict';

    /**
     * Abstract window
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    TestS.Window.Abstract = function (options) {
        this._set(options);
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Window.Abstract.prototype = {

        /**
         * Constructor
         */
        constructor: TestS.Window.Abstract,

        /**
         * Instance
         *
         * @var {Object}
         */
        _instance: null,

        /**
         * Body
         *
         * @var {Object}
         */
        _body: null,

        /**
         * Overlay
         *
         * @var {Object}
         */
        _overlay: null,

        /**
         * Init
         *
         * @param {Object} options
         */
        _set: function (options) {
            this._instance = TestS.Components.Template.get("window");
            this._body = this._instance.find(".body");
            this._overlay = TestS.Components.Template.get("window-overlay");

            this._options = $.extend({}, options);

            return this;
        }
    };
}(window.jQuery, window.TestS);