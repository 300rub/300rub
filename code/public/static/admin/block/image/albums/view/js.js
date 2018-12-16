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
            },
            sort: {
                hasOperation: false,
                group: "",
                controller: ""
            }
        },

        /**
         * Init
         */
        init: function () {
            this
                .createContainer()
                .setList()
                .setSortable()
                .setAddAlbumButton();
        },

        /**
         * Creates container
         */
        createContainer: function () {
            this.container
                = ss.init("template").get("image-group-sort-container");

            if (this.getOption("appendTo") !== null) {
                this.container.appendTo(this.getOption("appendTo"));
            }

            return this;
        },

        /**
         * Sets album list
         */
        setList: function () {
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
                        itemElement.attr("data-id", itemData.id);

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

                        this.container.append(itemElement);
                    },
                    this
                )
            );

            return this;
        },

        /**
         * Sets sortable
         */
        setSortable: function () {
            if (this.getOption(["sort", "hasOperation"]) !== true) {
                return this;
            }

            this.container.sortable(
                {
                    items: ".image-group-sort-item",
                    stop: $.proxy(function() {
                        var items
                            = this.container.find(".image-group-sort-item");

                        var list = [];
                        items.each(function() {
                            list.push($(this).data("id"));
                        });

                        ss.init(
                            "ajax",
                            {
                                type: "PUT",
                                data: {
                                    group: this.getOption(
                                        ["sort", "group"]
                                    ),
                                    controller: this.getOption(
                                        ["sort", "controller"]
                                    ),
                                    data: {
                                        blockId: this.getOption("blockId"),
                                        groupId: 0,
                                        list: list
                                    }
                                },
                                success: $.proxy(
                                    function () {
                                        ss.init(
                                            "commonContentBlockUpdate",
                                            {
                                                list: [
                                                    this.getOption("blockId", 0)
                                                ]
                                            }
                                        );
                                    },
                                    this
                                )
                            }
                        );
                    }, this)
                }
            );

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
                    css: "btn btn-gray btn-big button",
                    icon: "fas fa-plus",
                    label: this.getOption(["create", "label"]),
                    appendTo: this.getOption(["create", "appendTo"]),
                    onClick: $.proxy(function() {
                        ss.init(
                            "adminBlockImageAlbumsEdit",
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
                                    "adminBlockImageAlbumsEdit",
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
