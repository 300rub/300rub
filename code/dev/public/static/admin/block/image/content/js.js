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
                    level: 2
                };
            }

            this.create(
                $.extend(
                    {},
                    {
                        group: "image",
                        controller: "content",
                        data: {
                            id: this.getOption("blockId")
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
                    appendTo: this.getBody(),
                    isSortable: true,
                    list: this._data.list,
                    create: {
                        hasOperation: this.getData("canCreate"),
                        isSingleton: false,
                        group: "image",
                        controller: "image",
                        data: {
                            blockId: this.getData("id"),
                            imageGroupId: this.getData("groupId")
                        }
                    },
                    update: {
                        hasOperation: this.getData("canUpdate"),
                        blockId: this.getData("id"),
                        level: 2,
                        parent: "image-content"
                    },
                    remove: {
                        hasOperation: this.getData("canDelete"),
                        group: "image",
                        controller: "image",
                        data: {
                            blockId: this.getData("id")
                        },
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
