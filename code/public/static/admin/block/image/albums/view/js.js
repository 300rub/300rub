!function ($, ss) {
    "use strict";

    var name = "adminBlockImageAlbumsView";

    var parameters = {
        /**
         * Default options
         *
         * @type {Object}
         */
        defaultOptions: {
            blockId: 0,
            appendTo: null,
            list: [
                {cover: {url: ""}, id: 0, name: ""}
            ],
            create: {
                hasOperation: false,
                appendTo: null,
                label: ""
            },
            images: {
                label: ""
            },
            edit: {
                hasOperation: false,
                label: ""
            },
            remove: {
                hasOperation: false,
                label: "",
                confirm: {
                    text: "",
                    yes: "",
                    no: ""
                }
            }
        },

        /**
         * Init
         */
        init: function () {
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

            groupContainer.appendTo(this.getOption("appendTo"));

            $.each(
                this.getOption("list", {}),
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
            if (this.getOption(["create", "hasOperation"]) !== true) {
                return this;
            }

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-gray",
                    icon: "fas fa-plus",
                    label: this.getOption(["create", "label"]),
                    appendTo: this.getOption(["create", "appendTo"]),
                    onClick: $.proxy(function() {
                        ss.init(
                            "adminBlockImageAlbumsSettings",
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
                    label: this.getOption(["images", "label"]),
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

            if (this.getOption(["edit", "hasOperation"]) === true) {
                ss.init(
                    "commonComponentsFormButton",
                    {
                        css: "btn btn-blue",
                        icon: "fas fa-edit",
                        label: this.getOption(["edit", "label"]),
                        appendTo: buttons,
                        onClick: $.proxy(
                            function () {
                                ss.init(
                                    "adminBlockImageAlbumsSettings",
                                    {
                                        blockId: this.getOption("blockId"),
                                        id: itemData.id
                                    }
                                );
                            },
                            this
                        )
                    }
                );
            }

            if (this.getOption(["remove", "hasOperation"]) === true) {
                ss.init(
                    "commonComponentsFormButton",
                    {
                        css: "btn btn-red",
                        icon: "fas fa-trash",
                        label: this.getOption(["remove", "label"]),
                        appendTo: buttons,
                        confirm: {
                            text: this.getOption(
                                ["remove", "confirm", "text"]
                            ),
                            yes: {
                                label: this.getOption(
                                    ["remove", "confirm", "yes"]
                                ),
                                icon: "fas fa-trash"
                            },
                            no: this.getOption(["remove", "confirm", "no"])
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
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);