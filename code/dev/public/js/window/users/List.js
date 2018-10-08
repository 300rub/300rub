!function ($, ss) {
    'use strict';

    /**
     * Users window
     *
     * @type {Object}
     */
    ss.window.users.List = function () {
        ss.window.Abstract.call(
            this,
            {
                group: "user",
                controller: "users",
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "users"
            }
        );
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.users.List.prototype
        = Object.create(ss.window.Abstract.prototype);

    /**
     * Constructor
     */
    ss.window.users.List.prototype.constructor = ss.window.users.List;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.users.List.prototype._onLoadDataSuccess = function (data) {



    };
}(window.jQuery, window.ss);
