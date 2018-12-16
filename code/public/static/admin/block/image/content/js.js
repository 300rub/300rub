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
                        name: "image-content",
                        hasFooter: false
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
        },

        /**
         * Sets images
         */
        setImages: function () {
            ss.init(
                "adminBlockImageImagesView",
                {
                    blockId: this.getData("id"),
                    groupId: this.getData("groupId"),
                    appendTo: this.getBody(),
                    list: this.getData("list", {}),
                    create: {
                        hasOperation: this.getData("canCreate"),
                        isSingleton: false,
                        group: "image",
                        controller: "image"
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
                    },
                    sort: {
                        hasOperation: true,
                        group: "image",
                        controller: "content"
                    }
                }
            );
        },

        /**
         * Sets albums
         */
        setAlbums: function () {
            ss.init(
                "adminBlockImageAlbumsView",
                {
                    blockId: this.getData("id"),
                    appendTo: this.getBody(),
                    list: this.getData("list", {}),
                    create: {
                        hasOperation: this.getData("canCreate"),
                        appendTo: this.getFooter(),
                        label: this.getLabel("addAlbum")
                    },
                    images: {
                        label: this.getLabel("images")
                    },
                    edit: {
                        hasOperation: this.getData("canUpdate"),
                        label: this.getLabel("edit")
                    },
                    remove: {
                        hasOperation: this.getData("canDelete"),
                        label: this.getLabel("delete"),
                        confirm: {
                            text: this.getLabel("deleteConfirm"),
                            yes: this.getLabel("delete"),
                            no: this.getLabel("no")
                        }
                    },
                    sort: {
                        hasOperation: true,
                        group: "image",
                        controller: "content"
                    }
                }
            );
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
