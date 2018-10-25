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
                .setManualUpload()
            ;
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
                    blockId: 0,
                    appendTo: this.relativeContainer,
                    isSortable: false,
                    list: {},
                    create: {
                        hasOperation: true,
                        isSingleton: true,
                        group: "image",
                        controller: "image",
                        imageGroupId: null
                    },
                    edit: {
                        hasOperation: true,
                        group: "image",
                        controller: "image",
                        level: 1,
                        parent: null
                    },
                    crop: {
                        hasOperation: true,
                        group: "image",
                        controller: "crop",
                        level: 1,
                        parent: null
                    },
                    remove: {
                        hasOperation: true,
                        group: "image",
                        controller: "image",
                        confirm: {
                            text: "",
                            yes: "",
                            no: ""
                        }
                    }
                }
            );

            return this;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
