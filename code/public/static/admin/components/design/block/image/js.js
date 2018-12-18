!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignBlockImage";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Relative container
         *
         * @var {Object}
         */
        relativeContainer: null,

        /**
         * Background position
         *
         * @var {integer|null}
         */
        backgroundPosition: null,

        /**
         * Image instance URL
         *
         * @var {String|null}
         */
        imageInstanceUrl: null,

        /**
         * Image instance ID
         *
         * @var {integer|null}
         */
        imageInstanceId: null,

        /**
         * Is background cover
         *
         * @var {bool|null}
         */
        isBackgroundCover: null,

        /**
         * Position
         *
         * @var {integer|null}
         */
        position: null,

        /**
         * Repeat
         *
         * @var {integer|null}
         */
        repeat: null,

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [
            "backgroundPosition"
        ],

        /**
         * Init
         */
        init: function () {
            this.backgroundPosition = null;
            this.relativeContainer = null;

            this.imageInstanceUrl = null;
            this.imageInstanceId = null;
            this.isBackgroundCover = null;
            this.position = null;
            this.repeat = null;

            this.create(
                {
                    groupContainerSelector: ".image-container",
                    updateSampleEventName: "update-image-sample",
                    title: this.getOption(["labels", "backgroundImage"])
                }
            );

            this
                .setRelativeContainer()
                .setManualUpload();
        },

        /**
         * Sets relative container
         */
        setRelativeContainer: function () {
            this.relativeContainer
                = this.getGroupContainer().find(".relative-container");
            return this;
        },

        setManualUpload: function() {
            var list = [];
            var imageInstanceId = this.getOption(["image", "id"]);
            if (imageInstanceId !== null) {
                list = [
                    {
                        id: this.getOption(["image", "id"]),
                        name: "",
                        url: this.getOption(["image", "url"])
                    }
                ];
            }

            ss.init(
                "adminBlockImageImagesView",
                {
                    blockId: this.getOption("blockId"),
                    appendTo: this.relativeContainer,
                    list: list,
                    create: {
                        hasOperation: true,
                        isSingleton: true,
                        group: this.getOption(
                            ["image", "create", "group"]
                        ),
                        controller: this.getOption(
                            ["image", "create", "controller"]
                        ),
                        imageGroupId: null
                    },
                    edit: {
                        hasOperation: false
                    },
                    crop: {
                        hasOperation: true,
                        group: this.getOption(
                            ["image", "crop", "group"]
                        ),
                        controller: this.getOption(
                            ["image", "crop", "controller"]
                        ),
                        level: 1,
                        parent: null
                    },
                    remove: {
                        hasOperation: true,
                        group: this.getOption(
                            ["image", "remove", "group"]
                        ),
                        controller: this.getOption(
                            ["image", "remove", "controller"]
                        ),
                        confirm: {
                            text: "",
                            yes: "",
                            no: ""
                        }
                    },
                    sort: {
                        hasOperation: false
                    }
                }
            );

            return this;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
