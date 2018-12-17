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
            ss.init(
                "adminBlockImageImagesView",
                {
                    blockId: this.getOption("blockId"),
                    appendTo: this.relativeContainer,
                    list: {},
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
                        hasOperation: true,
                        group: this.getOption(
                            ["image", "edit", "group"]
                        ),
                        controller: this.getOption(
                            ["image", "edit", "controller"]
                        ),
                        level: 1,
                        parent: null
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
