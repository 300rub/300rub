!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignBlockBackground";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Background color from
         *
         * @var {String}
         */
        backgroundColorFrom: null,

        /**
         * Background color from hover
         *
         * @var {String}
         */
        backgroundColorFromHover: null,

        /**
         * Background color to
         *
         * @var {String}
         */
        backgroundColorTo: null,

        /**
         * Background color to hover
         *
         * @var {String}
         */
        backgroundColorToHover: null,

        /**
         * Background direction
         *
         * @var {int|null}
         */
        gradientDirection: null,

        /**
         * Background direction hover
         *
         * @var {int|null}
         */
        gradientDirectionHover: null,

        /**
         * Has Background Gradient
         *
         * @var {Boolean}
         */
        hasBackgroundGradient: false,

        /**
         * Has Background hover
         *
         * @var {Boolean}
         */
        hasBackgroundHover: false,

        /**
         * Has Background animation
         *
         * @var {Boolean}
         */
        hasBackgroundAnimation: false,

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
            "backgroundColorFrom",
            "backgroundColorFromHover",
            "backgroundColorTo",
            "backgroundColorToHover",
            "gradientDirection",
            "gradientDirectionHover",
            "hasBackgroundGradient",
            "hasBackgroundHover",
            "hasBackgroundAnimation",
            "imageInstanceId",
            "backgroundPosition",
            "backgroundRepeat",
            "isBackgroundCover"
        ],

        /**
         * Gradient directions
         *
         * @type {Array}
         */
        gradientDirections: [
            {value: 0, icon: "fas fa-long-arrow-alt-right"},
            {value: 1, icon: "fas fa-long-arrow-alt-down"},
            {value: 2, icon: "fas fa-long-arrow-alt-right", css: "deg-45"},
            {value: 3, icon: "fas fa-long-arrow-alt-up", css: "deg-45"}
        ],

        /**
         * List of gradient directions options
         *
         * @var {Object}
         */
        gradientDirectionList: {
            0: {
                "mozLinear": "left",
                "webkit": "linear, left top, right top",
                "webkitLinear": "left",
                "oLinear": "left",
                "msLinear": "left",
                "linear": "to right",
                "ie": 1
            },
            1: {
                "mozLinear": "top",
                "webkit": "linear, left top, left bottom",
                "webkitLinear": "top",
                "oLinear": "top",
                "msLinear": "top",
                "linear": "to bottom",
                "ie": 0
            },
            2: {
                "mozLinear": "-45deg",
                "webkit": "linear, left top, right bottom",
                "webkitLinear": "-45deg",
                "oLinear": "-45deg",
                "msLinear": "-45deg",
                "linear": "135deg",
                "ie": 1
            },
            3: {
                "mozLinear": "45deg",
                "webkit": "linear, left bottom, right top",
                "webkitLinear": "45deg",
                "oLinear": "45deg",
                "msLinear": "45deg",
                "linear": "45deg",
                "ie": 1
            }
        },

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
            this.backgroundColorFrom = null;
            this.backgroundColorFromHover = null;
            this.backgroundColorTo = null;
            this.backgroundColorToHover = null;
            this.gradientDirection = null;
            this.gradientDirectionHover = null;
            this.hasBackgroundGradient = false;
            this.hasBackgroundHover = false;
            this.hasBackgroundAnimation = false;
            this.imageInstanceId = null;
            this.backgroundPosition = null;
            this.backgroundRepeat = null;
            this.isBackgroundCover = null;
            this.url = null;

            this.relativeContainer = null;

            this.create(
                {
                    groupContainerSelector: ".background-container",
                    updateSampleEventName: "update-background-sample",
                    title: this.getOption(["labels", "background"])
                }
            );

            this
                .setRelativeContainer()
                .setColorPicker()
                .setColorFrom()
                .setColorTo()
                .setHasHover()
                .setHasAnimation()
                .setHasImage()
                .setHasGradient()
                .setGradientDirection()
                .setGradientDirectionHover()
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
         * Sets color picker
         */
        setColorPicker: function () {
            var region = "";

            $.colorpicker.regional[region].none = this.getLabel("clear");
            $.colorpicker.regional[region].ok = this.getLabel("save");
            $.colorpicker.regional[region].cancel = this.getLabel("cancel");

            return this;
        },

        /**
         * Sets background-color from
         */
        setColorFrom: function () {
            if (this.backgroundColorFrom === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormColor",
                {
                    value: this.backgroundColorFrom,
                    css: "background-color-from",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (color) {
                            this.backgroundColorFrom = color;
                            this.update();
                        },
                        this
                    )
                }
            );

            if (this.backgroundColorFromHover === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormColor",
                {
                    value: this.backgroundColorFromHover,
                    css: "background-color-from-hover",
                    iconBefore: "fas fa-mouse-pointer",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (color) {
                            this.backgroundColorFromHover = color;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets background-color to
         */
        setColorTo: function () {
            if (this.backgroundColorTo === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormColor",
                {
                    value: this.backgroundColorTo,
                    css: "background-color-to",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (color) {
                            this.backgroundColorTo = color;
                            this.update();
                        },
                        this
                    )
                }
            );

            if (this.backgroundColorToHover === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormColor",
                {
                    value: this.backgroundColorToHover,
                    css: "background-color-to-hover",
                    iconBefore: "fas fa-mouse-pointer",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (color) {
                            this.backgroundColorToHover = color;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets has image
         */
        setHasImage: function () {
            var hasImage = false;
            if (this.imageInstanceId !== null) {
                this.getGroupContainer().addClass("has-image");
                hasImage = true;
            }

            var onCheck = $.proxy(
                function () {
                    this.getGroupContainer().addClass("has-image");
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this.getGroupContainer().removeClass("has-image");
                },
                this
            );

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    value: hasImage,
                    label: this.getLabel("useImage"),
                    appendTo: this.getGroupContainer(),
                    onCheck: onCheck,
                    onUnCheck: onUnCheck
                }
            );

            return this;
        },

        /**
         * Sets has gradient
         */
        setHasGradient: function () {
            if (this.hasBackgroundGradient === true) {
                this.getGroupContainer().addClass("has-gradient");
            }

            var onCheck = $.proxy(
                function () {
                    this.getGroupContainer().addClass("has-gradient");
                    this.hasBackgroundGradient = true;
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this.getGroupContainer().removeClass("has-gradient");
                    this.hasBackgroundGradient = false;
                    this.update();
                },
                this
            );

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    css: "use-gradient-checkbox",
                    value: this.hasBackgroundGradient,
                    label: this.getLabel("useGradient"),
                    appendTo: this.getGroupContainer(),
                    onCheck: onCheck,
                    onUnCheck: onUnCheck
                }
            );

            return this;
        },

        /**
         * Sets gradient direction
         */
        setGradientDirection: function () {
            if (this.gradientDirection === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormRadioButtons",
                {
                    value: this.gradientDirection,
                    label: this.getLabel("gradientDirection"),
                    css: "gradient-direction",
                    data: this.gradientDirections,
                    appendTo: this.getGroupContainer(),
                    onChange: $.proxy(
                        function (value) {
                            this.gradientDirection = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets has hover
         */
        setHasHover: function () {
            if (this.hasBackgroundHover === true) {
                this.getGroupContainer().addClass("has-hover");
            }

            var onCheck = $.proxy(
                function () {
                    this.getGroupContainer().addClass("has-hover");
                    this.hasBackgroundHover = true;
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this.getGroupContainer().removeClass("has-hover");
                    this.hasBackgroundHover = false;
                    this.update();
                },
                this
            );

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    value: this.hasBackgroundHover,
                    label: this.getLabel("mouseHoverEffect"),
                    appendTo: this.getGroupContainer(),
                    onCheck: onCheck,
                    onUnCheck: onUnCheck
                }
            );

            return this;
        },

        /**
         * Sets has hover
         */
        setHasAnimation: function () {
            if (this.hasBackgroundAnimation === null) {
                return this;
            }

            var onCheck = $.proxy(
                function () {
                    this.hasBackgroundAnimation = true;
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this.hasBackgroundAnimation = false;
                    this.update();
                },
                this
            );

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    value: this.hasBackgroundAnimation,
                    label: this.getLabel("mouseHoverAnimation"),
                    css: "has-animation",
                    appendTo: this.getGroupContainer(),
                    onCheck: onCheck,
                    onUnCheck: onUnCheck
                }
            );

            return this;
        },

        /**
         * Sets gradient direction hover
         */
        setGradientDirectionHover: function () {
            if (this.gradientDirectionHover === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormRadioButtons",
                {
                    value: this.gradientDirectionHover,
                    label: this.getLabel("gradientDirectionHover"),
                    css: "gradient-direction-hover",
                    data: this.gradientDirections,
                    appendTo: this.getGroupContainer(),
                    onChange: $.proxy(
                        function (value) {
                            this.gradientDirectionHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );

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
                    appendTo: this.getGroupContainer(),
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
                                this.url = data.viewUrl;
                                data.cropper.remove();
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
                            text: this.getLabel(
                                ['imageDeleteConfirm', 'text']
                            ),
                            yes: this.getLabel(
                                ['imageDeleteConfirm', 'yes']
                            ),
                            no: this.getLabel(
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

            if (this.isBackgroundCover === true) {
                this.getGroupContainer().addClass("has-background-cover");
            }

            var onCheck = $.proxy(
                function () {
                    this.isBackgroundCover = true;
                    this.getGroupContainer().addClass("has-background-cover");
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this.isBackgroundCover = false;
                    this
                        .getGroupContainer()
                        .removeClass("has-background-cover");
                    this.update();
                },
                this
            );

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    css: "is-background-cover",
                    value: this.isBackgroundCover,
                    label: this.getLabel("isBackgroundCover"),
                    onCheck: onCheck,
                    onUnCheck: onUnCheck,
                    appendTo: this.getGroupContainer()
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
                    label: this.getLabel("position"),
                    value: this.backgroundPosition,
                    css: "icon-buttons big background-position",
                    grid: 3,
                    type: "int",
                    data: this.backgroundPositionList,
                    appendTo: this.getGroupContainer(),
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
                    label: this.getLabel("repeat"),
                    css: "background-repeat",
                    value: this.backgroundRepeat,
                    data: this.backgroundRepeatList,
                    appendTo: this.getGroupContainer(),
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
         *
         * @param {boolean} isHover
         *
         * @returns {String}
         */
        generateCss: function (isHover) {
            var backgroundColorFrom = "", backgroundColorTo = "";

            if (isHover === true) {
                if (this.hasBackgroundHover !== true) {
                    return "";
                }

                backgroundColorFrom = this.backgroundColorFromHover;
                backgroundColorTo = this.backgroundColorToHover;
            } else {
                backgroundColorFrom = this.backgroundColorFrom;
                backgroundColorTo = this.backgroundColorTo;
            }

            if (backgroundColorFrom === null) {
                backgroundColorFrom = "";
            }

            if (backgroundColorTo === null) {
                backgroundColorTo = "";
            }

            if (this.hasBackgroundGradient !== true) {
                backgroundColorTo = "";
            } else if (isHover === true) {
                if (backgroundColorFrom !== ""
                    && backgroundColorTo === ""
                ) {
                    backgroundColorTo = backgroundColorFrom;
                } else if (backgroundColorFrom === ""
                    && backgroundColorTo !== ""
                ) {
                    backgroundColorFrom = backgroundColorTo;
                }
            }

            return this.generateBackgroundCss(
                isHover,
                backgroundColorFrom,
                backgroundColorTo
            );
        },

        /**
         * Generates styles
         *
         * @param {boolean} isHover
         * @param {String}  colorFrom
         * @param {String}  colorTo
         *
         * @returns {String}
         */
        generateBackgroundCss: function (isHover, colorFrom, colorTo) {
            if (colorFrom !== ""
                && colorTo === ""
            ) {
                return "background-color: " + colorFrom + ";";
            }

            if (colorFrom === ""
                && colorTo !== ""
            ) {
                return "background-color: " + colorTo + ";";
            }

            if (colorFrom !== ""
                && colorTo !== ""
                && this.hasBackgroundGradient !== true
            ) {
                return "background-color: " + colorFrom + ";";
            }

            if (colorFrom === ""
                || colorTo === ""
            ) {
                return "";
            }

            return this.generateGradientCss(
                isHover,
                colorFrom,
                colorTo
            );
        },

        /**
         * Generates styles
         *
         * @param {boolean} isHover
         * @param {String}  colorFrom
         * @param {String}  colorTo
         *
         * @returns {String}
         */
        generateGradientCss: function (isHover, colorFrom, colorTo) {
            var css = "";
            var gradientDirection = this.getGradientDirection(isHover);

            css += "background: " + colorFrom + ";";
            css += "background: -moz-linear-gradient(";
            css += gradientDirection.mozLinear;
            css += ", " + colorFrom + " 0%, ";
            css += colorTo + " 100%);";

            css += "background: -webkit-gradient(";
            css += gradientDirection.webkit;
            css += ", color-stop(0%, " + colorFrom;
            css += "), color-stop(100%, " + colorTo + "));";

            css += "background: -webkit-linear-gradient(";
            css += gradientDirection.webkitLinear;
            css += ", " + colorFrom + " 0%, ";
            css += colorTo + " 100%);";

            css += "background: -o-linear-gradient(";
            css += gradientDirection.oLinear + ", ";
            css += colorFrom + " 0%, " + colorTo + " 100%);";

            css += "background: -ms-linear-gradient(";
            css += gradientDirection.msLinear + ", ";
            css += colorFrom + " 0%, " + colorTo + " 100%);";

            css += "background: linear-gradient(";
            css += gradientDirection.linear + ", ";
            css += colorFrom + " 0%, " + colorTo + " 100%);";

            css += "filter: progid:DXImageTransform.";
            css += "Microsoft.gradient( startColorstr='";
            css += colorFrom + "', endColorstr='";
            css += colorTo + "',GradientType=";
            css += gradientDirection.ie + ");";

            return css;
        },

        /**
         * Gets gradient direction
         *
         * @param {boolean} isHover
         *
         * @return {Object}
         */
        getGradientDirection: function (isHover) {
            var gradientDirection;

            if (isHover === true) {
                gradientDirection = this.gradientDirectionHover;
            } else {
                gradientDirection = this.gradientDirection;
            }

            if (this.gradientDirectionList[gradientDirection] !== undefined) {
                return this.gradientDirectionList[gradientDirection];
            }

            return this.gradientDirectionList[0];
        },

        /**
         * Has animation
         *
         * @return {boolean}
         */
        hasAnimation: function () {
            return this.hasBackgroundGradient === false
                && this.hasBackgroundHover === true
                && this.hasBackgroundAnimation === true;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
