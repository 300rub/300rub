!function ($, ss) {
    'use strict';

    /**
     * Section structure window
     *
     * @param {int} blockId
     *
     * @type {Object}
     */
    ss.window.blocks.image.Content = function (blockId) {
        ss.window.Abstract.call(
            this,
            {
                group: "image",
                controller: "content",
                data: {
                    id: blockId
                },
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "image-content"
            }
        );

        this._blockId = blockId;
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.blocks.image.Content.prototype
        = Object.create(ss.window.Abstract.prototype);

    /**
     * Constructor
     */
    ss.window.blocks.image.Content.prototype.constructor = ss.window.blocks.image.Content;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.blocks.image.Content.prototype._onLoadDataSuccess = function (data) {
        console.log(data);

        if (data.useAlbums === false) {
            new ss.content.block.image.ImageList(
                $.extend(
                    data,
                    {
                        appendTo: this.getBody()
                    }
                )
            );
        }

        this
            .setTitle(data.name)
            .setSubmit(
                {
                    label: data.button.label,
                    icon: "fas fa-save",
                    ajax: {
                        data: {
                            group: "image",
                            controller: "content",
                            data: {
                                id: data.id
                            }
                        },
                        type: "PUT",
                        success: $.proxy(this._onSendSuccess, this)
                    }
                }
            );
    };

    /**
     * On send success
     *
     * @private
     */
    ss.window.blocks.image.Content.prototype._onSendSuccess = function () {
        this.remove();

        if (this._blockId !== 0) {
            new ss.content.block.Update([this._blockId]);
        }
    };
}(window.jQuery, window.ss);
