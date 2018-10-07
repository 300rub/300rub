!function ($, ss) {
    'use strict';

    /**
     * Login window
     *
     * @type {Object}
     */
    ss.window.users.Login = function () {
        ss.window.Abstract.call(
            this,
            {
                group: "user",
                controller: "loginForms",
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "login"
            }
        );

        this._userForm = null;
        this._passwordForm = null;
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.users.Login.prototype
        = Object.create(ss.window.Abstract.prototype);

    /**
     * Constructor
     */
    ss.window.users.Login.prototype.constructor = ss.window.users.Login;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.users.Login.prototype._onLoadDataSuccess = function (data) {










        this._userForm.focus();
    };

    /**
     * On send success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.users.Login.prototype._;
}(window.jQuery, window.ss);
