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
        this._data = {};
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
        this._setData(data);

        if (data.useAlbums === false) {
            this._setImages();
        } else {
            this._setAlbums();
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
     * Sets labels
     *
     * @param {Object} data
     *
     * @private
     */
    ss.window.blocks.image.Content.prototype._setData = function (data) {
        this._data = data;
        return this;
    };

    /**
     * Sets albums
     *
     * @private
     */
    ss.window.blocks.image.Content.prototype._setAlbums = function () {
        this
            ._createContainer()
            ._setAlbumList()
            ._setAddAlbumButton();
    };

    /**
     * Sets album list
     *
     * @returns {ss.window.blocks.image.Content}
     *
     * @private
     */
    ss.window.blocks.image.Content.prototype._setAlbumList = function () {
        $.each(this._data.list, $.proxy(function(i, itemData) {
            if (itemData.id === 0) {
                return this;
            }

            var itemElement = ss.components.Template.get("image-group-sort-item");

            var coverContainer = itemElement.find(".cover-container");
            if (itemData.cover === null) {
                coverContainer.remove();
            } else {
                coverContainer.find(".cover").attr("src", itemData.cover.url);
            }

            itemElement.find(".title").text(itemData.name);

            this._setAlbumButtons(itemElement, itemData);

            this._groupContainer.append(itemElement);
        }, this));

        this._groupContainer.sortable(
            {
                items: ".image-group-sort-item"
            }
        );

        return this;
    };

    /**
     * Sets add album button
     *
     * @returns {ss.window.blocks.image.Content}
     *
     * @private
     */
    ss.window.blocks.image.Content.prototype._setAddAlbumButton = function () {
        if (this._data.canCreate !== true) {
            return this;
        }

        this.addFooterButton(
            {
                label: this._data.labels.addAlbum,
                icon: "fas fa-plus"
            }
        );

        return this;
    };

    /**
     * Sets album buttons
     *
     * @param {Object} itemElement
     * @param {Object} itemData
     *
     * @returns {ss.window.blocks.image.Content}
     *
     * @private
     */
    ss.window.blocks.image.Content.prototype._setAlbumButtons = function (
        itemElement,
        itemData
    ) {
        var buttons = itemElement.find(".buttons");

        new ss.forms.Button(
            {
                css: "btn btn-gray",
                icon: "fas fa-images",
                label: this._data.labels.images,
                appendTo: buttons,
                onClick: $.proxy(function() {

                }, this)
            }
        );

        if (this._data.canUpdate === true) {
            new ss.forms.Button(
                {
                    css: "btn btn-blue",
                    icon: "fas fa-edit",
                    label: this._data.labels.edit,
                    appendTo: buttons,
                    onClick: $.proxy(function () {

                    }, this)
                }
            );
        }

        if (this._data.canDelete === true) {
            new ss.forms.Button(
                {
                    css: "btn btn-red",
                    icon: "fas fa-trash",
                    label: this._data.labels.delete,
                    appendTo: buttons,
                    confirm: {
                        text: this._data.labels.deleteConfirm,
                        yes: {
                            label: this._data.labels.delete,
                            icon: "fas fa-trash"
                        },
                        no: this._data.labels.no
                    },
                    ajax: {
                        data: {
                            group: "image",
                            controller: "album",
                            data: {
                                id: itemData.id,
                                blockId: this._blockId
                            }
                        },
                        type: "DELETE",
                        success: function () {
                            itemElement.remove();
                        }
                    }
                }
            );
        }

        return this;
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
     * @private
     */
    ss.window.blocks.image.Content.prototype._setImages = function () {
        new ss.content.block.image.ImageList(
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
    ss.window.blocks.image.Content.prototype._onSendSuccess = function () {
        this.remove();

        if (this._blockId !== 0) {
            new ss.content.block.Update([this._blockId]);
        }
    };
}(window.jQuery, window.ss);
