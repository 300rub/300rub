!function ($, ss) {
    'use strict';

    /**
     * Section structure window
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    ss.window.blocks.image.Edit = function (options) {
        ss.window.Abstract.call(
            this,
            {
                group: "image",
                controller: "image",
                data: {
                    blockId: options.blockId,
                    id: options.id
                },
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "image-edit",
                level: options.level,
                parent: options.parent
            }
        );
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.blocks.image.Edit.prototype
        = Object.create(ss.window.Abstract.prototype);

    /**
     * Constructor
     */
    ss.window.blocks.image.Edit.prototype.constructor = ss.window.blocks.image.Edit;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.blocks.image.Edit.prototype._onLoadDataSuccess = function (data) {
        console.log(data);
    };

    /**
     * On send success
     *
     * @private
     */
    ss.window.blocks.image.Edit.prototype._onSendSuccess = function () {
        
    };
}(window.jQuery, window.ss);
