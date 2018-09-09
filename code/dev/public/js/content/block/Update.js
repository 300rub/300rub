!function ($, ss) {
    'use strict';

    /**
     * Block update
     *
     * @param {Array} idList
     */
    ss.content.block.Update = function (idList) {
        this._idList = idList;
        this._filteredIdList = [];

        this.init();
    };

    /**
     * Constructor
     */
    ss.content.block.Update.prototype.constructor = ss.content.block.Update;

    /**
     * Init
     */
    ss.content.block.Update.prototype.init = function () {
        this
            ._setFilteredIdList()
            ._loadContent();
    };

    /**
     * Sets filtered ID list
     *
     * @returns {ss.content.block.Update}
     *
     * @private
     */
    ss.content.block.Update.prototype._setFilteredIdList = function () {
        $.each(this._idList, $.proxy(function(i, blockId) {
            if ($(".block-" + blockId).length > 0) {
                this._filteredIdList.push(blockId);
            }
        }, this));

        return this;
    };

    /**
     * Loads blocks content
     *
     * @returns {ss.content.block.Update}
     *
     * @private
     */
    ss.content.block.Update.prototype._loadContent = function () {
        var uri = window.location.pathname + window.location.search;

        new ss.components.Ajax(
            {
                data: {
                    group: "block",
                    controller: "content",
                    data: {
                        idList: this._filteredIdList,
                        uri: uri
                    }
                },
                error: $.proxy(this._onError, this),
                success: $.proxy(this._onSuccess, this)
            }
        );

        return this;
    };

    /**
     * On error
     *
     * @private
     */
    ss.content.block.Update.prototype._onError = function () {
    };

    /**
     * On success
     *
     * @param {Object} data
     *
     * @private
     */
    ss.content.block.Update.prototype._onSuccess = function (data) {
        $.each(data.content, $.proxy(function(blockId, blockData) {
            var blockElement = $(".block-" + blockId);

            if (blockElement.length === 0) {
                return false;
            }

            var gridElement = blockElement.parent();
            blockElement.remove();
            gridElement.append(blockData.html);

            $.each(blockData.css, $.proxy(function(cssId, cssValue) {
                var cssElement = $("#" + cssId);
                if (cssElement.length === 0) {
                    return false;
                }

                cssValue = "<style>" + cssValue + "</style>";

                cssElement.html(cssValue);
            }, this));

            $.each(blockData.js, $.proxy(function(i, jsValue) {
                var fullJs = "<script>!function(){" + jsValue + "}();</script>";
                $("body").append(fullJs);
            }, this));
        }, this));
    };
}(window.jQuery, window.ss);
