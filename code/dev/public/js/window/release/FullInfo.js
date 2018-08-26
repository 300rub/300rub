!function ($, ss) {
    'use strict';

    /**
     * Create window
     *
     * @type {Object}
     */
    ss.window.release.FullInfo = function () {
        ss.window.Abstract.call(
            this,
            {
                group: "release",
                controller: "fullInfo",
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "release-full-info"
            }
        );
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.release.FullInfo.prototype
        = Object.create(ss.window.Abstract.prototype);

    /**
     * Constructor
     */
    ss.window.release.FullInfo.prototype.constructor = ss.window.release.FullInfo;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.release.FullInfo.prototype._onLoadDataSuccess = function (data) {
        this.setTitle(data.title);
    };
}(window.jQuery, window.ss);
