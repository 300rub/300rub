!function ($, ss) {
    "use strict";

    var name = "adminBlockImageContent";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsWindowAbstract",

        /**
         * Init
         */
        init: function () {
            var data = {};
            if (this.getOption("groupId") !== null) {
                data = {
                    name: "image-content-group",
                    parent: "image-content",
                    level: 2,
                    data: {
                        blockId: this.getOption("blockId"),
                        groupId: this.getOption("groupId")
                    }
                };
            }

            this.create(
                $.extend(
                    {},
                    {
                        group: "image",
                        controller: "content",
                        data: {
                            blockId: this.getOption("blockId")
                        },
                        name: "image-content"
                    },
                    data
                )
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            if (this.getData("useAlbums") === false) {
                this.setImages();
            } else {
                this.setAlbums();
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
        },

        /**
         * Sets images
         */
        setImages: function () {
            ss.init(
                "adminBlockImageImages",
                {
                    blockId: this.getData("id"),
                    appendTo: this.getBody(),
                    isSortable: true,
                    list: this.getData("list", {}),
                    create: {
                        hasOperation: this.getData("canCreate"),
                        isSingleton: false,
                        group: "image",
                        controller: "image",
                        imageGroupId: this.getData("groupId")
                    },
                    edit: {
                        hasOperation: this.getData("canUpdate"),
                        group: "image",
                        controller: "image",
                        level: 2,
                        parent: "image-content"
                    },
                    crop: {
                        hasOperation: this.getData("canUpdate"),
                        group: "image",
                        controller: "crop",
                        level: 2,
                        parent: "image-content"
                    },
                    remove: {
                        hasOperation: this.getData("canDelete"),
                        group: "image",
                        controller: "image",
                        confirm: {
                            text: this.getLabel("deleteConfirm"),
                            yes: this.getLabel("delete"),
                            no: this.getLabel("no")
                        }
                    }
                }
            );
        },

        /**
         * Sets albums
         */
        setAlbums: function () {
            this
                .setAlbumList()
                .setAddAlbumButton();
        },

        /**
         * Sets album list
         */
        setAlbumList: function () {
            var groupContainer
                = ss.init("template").get("image-group-sort-container");

            groupContainer.appendTo(this.getBody());

            $.each(
                this.getData("list", {}),
                $.proxy(
                    function (i, itemData) {
                        if (itemData.id === 0) {
                            return this;
                        }

                        var itemElement = ss.init("template").get(
                            "image-group-sort-item"
                        );

                        var coverContainer
                            = itemElement.find(".cover-container");
                        if (itemData.cover === null) {
                            coverContainer.remove();
                        } else {
                            coverContainer
                                .find(".cover")
                                .attr("src", itemData.cover.url);
                        }

                        itemElement.find(".title").text(itemData.name);

                        this.setAlbumButtons(itemElement, itemData);

                        groupContainer.append(itemElement);
                    },
                    this
                )
            );

            if (this.getOption("isSortable") === true) {
                this.container.sortable(
                    {
                        items: ".image-group-sort-item"
                    }
                );
            }

            return this;
        },

        /**
         * Sets add album button
         */
        setAddAlbumButton: function () {
            if (this.getData("canCreate") !== true) {
                return this;
            }

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-gray",
                    icon: "fas fa-plus",
                    label: this.getLabel("addAlbum"),
                    appendTo: this.getFooter(),
                    onClick: $.proxy(function() {
                        ss.init(
                            "adminBlockImageAlbumAdd",
                            {
                                blockId: this.getOption("blockId")
                            }
                        );
                    }, this)
                }
            );

            return this;
        },

        /**
         * Sets album buttons
         *
         * @param {Object} itemElement
         * @param {Object} itemData
         */
        setAlbumButtons: function (itemElement, itemData) {
            var buttons = itemElement.find(".buttons");

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-gray",
                    icon: "fas fa-images",
                    label: this.getLabel("images"),
                    appendTo: buttons,
                    onClick: $.proxy(
                        function () {
                            ss.init(
                                "adminBlockImageContent",
                                {
                                    groupId: itemData.id,
                                    blockId: this.getOption("blockId")
                                }
                            );
                        },
                        this
                    )
                }
            );

            if (this.getData("canUpdate") === true) {
                ss.init(
                    "commonComponentsFormButton",
                    {
                        css: "btn btn-blue",
                        icon: "fas fa-edit",
                        label: this.getLabel("edit"),
                        appendTo: buttons,
                        onClick: $.proxy(
                            function () {
                                ss.init(
                                    "adminBlockImageAlbumUpdate",
                                    {
                                        groupId: itemData.id,
                                        blockId: this.getOption("blockId")
                                    }
                                );
                            },
                            this
                        )
                    }
                );
            }

            if (this.getData("canDelete") === true) {
                ss.init(
                    "commonComponentsFormButton",
                    {
                        css: "btn btn-red",
                        icon: "fas fa-trash",
                        label: this.getLabel("delete"),
                        appendTo: buttons,
                        confirm: {
                            text: this.getLabel("deleteConfirm"),
                            yes: {
                                label: this.getLabel("delete"),
                                icon: "fas fa-trash"
                            },
                            no: this.getLabel("no")
                        },
                        ajax: {
                            data: {
                                group: "image",
                                controller: "album",
                                data: {
                                    id: itemData.id,
                                    blockId: this.getOption("blockId")
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
        },

        /**
         * On send success
         */
        onSendSuccess: function () {
            this.remove();

            if (this.getOption("blockId") !== 0) {
                ss.init(
                    "commonContentBlockUpdate",
                    {
                        list: [
                            this.getOption("blockId")
                        ]
                    }
                );
            }
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
