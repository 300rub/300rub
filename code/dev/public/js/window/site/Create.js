!function ($, ss) {
    'use strict';

    /**
     * Create window
     *
     * @type {Object}
     */
    ss.window.site.Create = function () {
        ss.window.Abstract.call(
            this,
            {
                group: "site",
                controller: "createForm",
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "create-site"
            }
        );
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.site.Create.prototype
        = Object.create(ss.window.Abstract.prototype);

    /**
     * Constructor
     */
    ss.window.site.Create.prototype.constructor = ss.window.site.Create;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.site.Create.prototype._onLoadDataSuccess = function (data) {
        this.setTitle(123);
    };

    /**
     * On send success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.site.Create.prototype._onSendSuccess = function (data) {

    };
}(window.jQuery, window.ss);
