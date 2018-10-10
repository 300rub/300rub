!function ($, ss) {
    "use strict";

    ss.add(
        "adminBlockImageAlbums",
        {
            /**
             * Default options
             *
             * @type {Object}
             */
            defaultOptions: {
                appendTo: null,
                list: [
                {
                    id: 0,
                    name: null,
                    cover: {
                        url: null
                    }
                }
                ],
                isSortable: false,
                images: {
                    label: null
                },
                create: {
                    hasOperation: false,
                    label: null,
                    appendTo: null
                },
                update: {
                    hasOperation: false,
                    label: null
                },
                remove: {
                    hasOperation: false,
                    label: null,
                    confirm: {
                        text: "",
                        yes: "",
                        no: ""
                    }
                }
            },

            /**
             * Container
             *
             * @var {Object}
             */
            container: null,

            /**
             * Init
             */
            init: function () {
                this
                .extendDefaultOptions(this.defaultOptions)
                .createContainer()
                .setAlbumList()
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
            },

            /**
             * Sets album list
             */
            setAlbumList: function () {
                $.each(
                    this.getOption("list", {}),
                    $.proxy(
                        function (i, itemData) {
                            if (itemData.id === 0) {
                                return this;
                            }

                            var itemElement
                            = ss.init("template").get("image-group-sort-item");

                            var coverContainer = itemElement.find(".cover-container");
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
                if (this.getOption(["create", "hasOperation"]) !== true
                    || this.getOption(["create", "appendTo"]) === null
                ) {
                    return this;
                }

                // this.addFooterButton(
                // {
                // label: this.getOption(["create", "label"]),
                // icon: "fas fa-plus"
                // }
                // );
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

                            },
                            this
                        )
                    }
                );

                if (this.getOption(["update", "hasOperation"]) === true) {
                    ss.init(
                        "commonComponentsFormButton",
                        {
                            css: "btn btn-blue",
                            icon: "fas fa-edit",
                            label: this.getOption(["update", "label"]),
                            appendTo: buttons,
                            onClick: $.proxy(
                                function () {

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
                                text: this.getOption(["remove", "confirm", "text"]),
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
        }
    );
}(window.jQuery, window.ss);
