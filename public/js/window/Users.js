!function ($, TestS) {
    'use strict';

    /**
     * Users window
     *
     * @type {Object}
     */
    TestS.Window.Users = function () {
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Window.Users.prototype = {

        /**
         * @var {Window.TestS.Window}
         */
        _window: null,

        /**
         * Init
         */
        init: function () {
            this._window = new TestS.Window({
                controller: "user",
                action: "users",
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "users"
            });
        },

        /**
         * On load window success
         *
         * @param {Object} [data]
         *
         * @private
         */
        _onLoadDataSuccess: function(data) {
            this._window.getInstance().find(".footer").remove();

            this._window
                .setTitle(data.title)
                .removeLoading();
        }
    };
}(window.jQuery, window.TestS);