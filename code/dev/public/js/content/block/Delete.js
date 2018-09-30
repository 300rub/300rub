!function ($, ss) {
    'use strict';

    /**
     * Block delete
     *
     * @param {Array} idList
     */
    ss.content.block.Delete = function (idList) {
        this._idList = idList;

        this.init();
    };

    /**
     * Constructor
     */
    ss.content.block.Delete.prototype.constructor = ss.content.block.Delete;

    /**
     * Init
     */
    ss.content.block.Delete.prototype.init = function () {
        $.each(this._idList, $.proxy(function(i, blockId) {
            var block = $(".block-" + blockId);

            if (block.length > 0) {
                block.remove();
            }
        }, this));
    };
}(window.jQuery, window.ss);
