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
        var data = {};

        if (options.groupId !== undefined) {
            data = {
                name: "image-content-group",
                parent: "image-content",
                level: 2
            };
        }

        ss.window.Abstract.call(
            this,
            $.extend(
                {},
                {
                    group: "image",
                    controller: "content",
                    data: {
                        id: options.blockId
                    },
                    success: $.proxy(this._onLoadDataSuccess, this),
                    name: "image-content"
                },
                data
            )
        );

        this._blockId = options.blockId;
        this._groupContainer = null;
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
        if (data.useAlbums === false) {
            this._setImages(data);
        } else {
            this._setAlbums(data);
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
     * Sets albums
     *
     * @param {Object} data
     *
     * @private
     */
    ss.window.blocks.image.Content.prototype._setAlbums = function (data) {
        this
            ._createContainer()
            ._setAlbumList(data.list);
    };

    ss.window.blocks.image.Content.prototype._setAlbumList = function (list) {
        $.each(list, $.proxy(function(i, data) {
            if (data.id === 0) {
                return this;
            }

            var itemElement = ss.components.Template.get("image-group-sort-item");
            itemElement.find("img").attr("src", data.cover.url);

            this._groupContainer.append(itemElement);
        }, this));
    };

    /**
     * Creates container
     *
     * @returns {ss.content.block.image.ImageList}
     *
     * @private
     */
    ss.window.blocks.image.Content.prototype._createContainer = function () {
        this._groupContainer = ss.components.Template.get(
            "image-group-sort-container"
        );
        this._groupContainer.appendTo(this.getBody());

        return this;
    };

    /**
     * Sets images
     *
     * @param {Object} data
     *
     * @private
     */
    ss.window.blocks.image.Content.prototype._setImages = function (data) {
        new ss.content.block.image.ImageList(
            {
                appendTo: this.getBody(),
                isSortable: true,
                list: data.list,
                create: {
                    hasOperation: data.canCreate,
                    isSingleton: false,
                    group: "image",
                    controller: "image",
                    data: {
                        blockId: data.id,
                        imageGroupId: data.groupId
                    }
                },
                update: {
                    hasOperation: data.canUpdate,
                    blockId: data.id,
                    level: 2,
                    parent: "image-content"
                },
                delete: {
                    hasOperation: data.canDelete,
                    group: "image",
                    controller: "image",
                    data: {
                        blockId: data.id
                    },
                    confirm: {
                        text: data.labels.deleteConfirm,
                        yes: data.labels.delete,
                        no: data.labels.no
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
    ss.window.blocks.image.Content.prototype._onSendSuccess = function () {
        this.remove();

        if (this._blockId !== 0) {
            new ss.content.block.Update([this._blockId]);
        }
    };
}(window.jQuery, window.ss);
