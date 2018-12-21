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
         * Background position list
         *
         * @type {Array}
         */
        backgroundPositionList: [
            {value: 0, icon: "fas fa-arrow-right", css: "deg-45"},
            {value: 1, icon: "fas fa-arrow-down"},
            {value: 2, icon: "fas fa-arrow-down", css: "deg-45"},
            {value: 3, icon: "fas fa-arrow-right"},
            {value: 4, icon: "fas fa-arrows-alt"},
            {value: 5, icon: "fas fa-arrow-left"},
            {value: 6, icon: "fas fa-arrow-up", css: "deg-45"},
            {value: 7, icon: "fas fa-arrow-up"},
            {value: 8, icon: "fas fa-arrow-left", css: "deg-45"}
        ],

        /**
         * Background position CSS list
         *
         * @type {Object}
         */
        backgroundPositionCssList: {
            0: "left top",
            1: "center top",
            2: "right top",
            3: "left center",
            4: "center center",
            5: "right center",
            6: "left bottom",
            7: "center bottom",
            8: "right bottom"
        },

        /**
         * Background repeat list
         *
         * @type {Array}
         */
        backgroundRepeatList: [
            {value: 0, icon: "fas fa-ban"},
            {value: 1, icon: "fas fa-arrow-right"},
            {value: 2, icon: "fas fa-arrow-down"},
            {value: 3, icon: "fas fa-arrows-alt"}
        ],

        /**
         * Background repeat CSS list
         *
         * @type {Array}
         */
        backgroundRepeatCssList: {
            0: "no-repeat",
            1: "repeat-x",
            2: "repeat-y",
            3: "repeat"
        },

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
                .setIsBackgroundCover()
                .setBackgroundPosition()
                .setBackgroundRepeat();
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
                                this.url = data.url;
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
         * Sets backgroundPosition
         */
        setBackgroundPosition: function() {
            if (this.backgroundPosition === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormRadioButtons",
                {
                    value: this.backgroundPosition,
                    css: "icon-buttons big",
                    grid: 3,
                    type: "int",
                    data: this.backgroundPositionList,
                    appendTo: this.relativeContainer,
                    onChange: $.proxy(
                        function(value) {
                            this.backgroundPosition = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets backgroundRepeat
         */
        setBackgroundRepeat: function() {
            if (this.backgroundRepeat === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormRadioButtons",
                {
                    value: this.backgroundRepeat,
                    data: this.backgroundRepeatList,
                    appendTo: this.relativeContainer,
                    onChange: $.proxy(
                        function (value) {
                            this.backgroundRepeat = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Generates styles
         */
        generateCss: function () {
            if (this.imageInstanceId === null) {
                return "";
            }

            var css = "";

            css += "background-image:url(";
            css += this.url;
            css += ");";

            if (this.isBackgroundCover === true) {
                css += "background-size:cover;";
                return css;
            }

            css += "background-position:";
            css += this.getBackgroundPositionCss();
            css += ";";

            css += "background-repeat:";
            css += this.getBackgroundRepeatCss();
            css += ";";

            return css;
        },

        /**
         * Gets background position CSS
         *
         * @returns {String}
         */
        getBackgroundPositionCss: function() {
            var value
                = this.backgroundPositionCssList[this.backgroundPosition];
            if (value === undefined) {
                return this.backgroundPositionCssList[0];
            }

            return value;
        },

        /**
         * Gets background repeat CSS
         *
         * @returns {String}
         */
        getBackgroundRepeatCss: function() {
            var value = this.backgroundRepeatCssList[this.backgroundRepeat];
            if (value === undefined) {
                return this.backgroundRepeatCssList[0];
            }

            return value;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
