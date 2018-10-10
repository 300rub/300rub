!function ($, ss) {
    'use strict';

    /**
     * Section structure window
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    ss.window.blocks.image.Content = function (options) {
        this.container = null;
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
        if (this.getData("useAlbums") === false) {
            this._setImages();
        } else {
            this._setAlbums();
        }

        this.setSubmit(
            {
                label: this.getLabel("button"),
                icon: "fas fa-save",
                ajax: {
                    data: {
                        group: "image",
                        controller: "content",
                        data: {
                            id: this.getData("id")
                        }
                    },
                    type: "PUT",
                    success: $.proxy(this.onSendSuccess, this)
                }
            }
        );
    };

    /**
     * Sets images
     *
     * @private
     */
    ss.window.blocks.image.Content.prototype._setImages = function () {
        ss.init(
            "adminBlockImageImages",
            {
                appendTo: this.getBody(),
                isSortable: true,
                list: this._data.list,
                create: {
                    hasOperation: this._data.canCreate,
                    isSingleton: false,
                    group: "image",
                    controller: "image",
                    data: {
                        blockId: this._data.id,
                        imageGroupId: this._data.groupId
                    }
                },
                update: {
                    hasOperation: this._data.canUpdate,
                    blockId: this._data.id,
                    level: 2,
                    parent: "image-content"
                },
                delete: {
                    hasOperation: this._data.canDelete,
                    group: "image",
                    controller: "image",
                    data: {
                        blockId: this._data.id
                    },
                    confirm: {
                        text: this._data.labels.deleteConfirm,
                        yes: this._data.labels.delete,
                        no: this._data.labels.no
                    }
                }
            }
        );
    };

    /**
     * On send success
     *
     * @private
     */
    ss.window.blocks.image.Content.prototype.onSendSuccess = function () {
        this.remove();

        if (this.getOption("blockId") !== 0) {
            new ss.content.block.Update([this.getOption("blockId")]);
        }
    };
}(window.jQuery, window.ss);
