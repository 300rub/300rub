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
         * Image instance ID
         *
         * @var {integer|null}
         */
        imageInstanceId: null,

        /**
         * Background position
         *
         * @var {integer|null}
         */
        backgroundPosition: null,

        /**
         * Background repeat
         *
         * @var {integer|null}
         */
        backgroundRepeat: null,

        /**
         * Is background cover
         *
         * @var {boolean|null}
         */
        isBackgroundCover: null,

        /**
         * URL
         *
         * @var {String|null}
         */
        url: null,

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [
            "imageInstanceId",
            "backgroundPosition",
            "backgroundRepeat",
            "isBackgroundCover"
        ],

        /**
         * Init
         */
        init: function () {
            this.relativeContainer = null;

            this.imageInstanceId = null;
            this.backgroundPosition = null;
            this.backgroundRepeat = null;
            this.isBackgroundCover = null;
            this.url = null;

            this.create(
                {
                    groupContainerSelector: ".image-container",
                    updateSampleEventName: "update-image-sample",
                    title: this.getOption(["labels", "backgroundImage"])
                }
            );

            this
                .setRelativeContainer()
                .setUrl()
                .setImageUploader()
                .setIsBackgroundCover();
        },

        /**
         * Sets relative container
         */
        setRelativeContainer: function () {
            this.relativeContainer
                = this.getGroupContainer().find(".relative-container");
            return this;
        },

        /**
         * Sets URL
         */
        setUrl: function () {
            this.url = this.getOption(["image", "url"]);
            return this;
        },

        /**
         * Sets image uploader
         */
        setImageUploader: function() {
            var list = [];
            if (this.imageInstanceId !== null) {
                list = [
                    {
                        id: this.imageInstanceId,
                        name: "",
                        url: this.url
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
                        imageGroupId: null,
                        callback: $.proxy(
                            function(data) {
                                this.imageInstanceId = data.id;
                                this.update();
                            },
                            this
                        )
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
                        parent: null,
                        callback: $.proxy(
                            function(data) {
                                this.url = data.url;
                                // update image src
                                this.update();
                            },
                            this
                        )
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
                            text: this.getLabels(
                                ['imageDeleteConfirm', 'text']
                            ),
                            yes: this.getLabels(
                                ['imageDeleteConfirm', 'yes']
                            ),
                            no: this.getLabels(
                                ['imageDeleteConfirm', 'no']
                            )
                        },
                        callback: $.proxy(
                            function() {
                                this.imageInstanceId = null;
                                this.update();
                            },
                            this
                        )
                    }
                }
            );

            return this;
        },

        /**
         * Sets isBackgroundCover
         */
        setIsBackgroundCover: function() {
            if (this.isBackgroundCover === null) {
                return this;
            }

            var onCheck = $.proxy(
                function () {
                    this.isBackgroundCover = true;
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this.isBackgroundCover = false;
                    this.update();
                },
                this
            );

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    value: this.isBackgroundCover,
                    label: this.getLabel("isBackgroundCover"),
                    onCheck: onCheck,
                    onUnCheck: onUnCheck,
                    appendTo: this.relativeContainer
                }
            );

            return this;
        },

        /**
         * Generates styles
         */
        generateCss: function () {
            return "";
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
