!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignBlockMargin";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Margin top
         *
         * @var {int|null}
         */
        marginTop: null,

        /**
         * Margin right
         *
         * @var {int|null}
         */
        marginRight: null,

        /**
         * Margin bottom
         *
         * @var {int|null}
         */
        marginBottom: null,

        /**
         * Margin left
         *
         * @var {int|null}
         */
        marginLeft: null,

        /**
         * Margin top hover
         *
         * @var {int|null}
         */
        marginTopHover: null,

        /**
         * Margin right hover
         *
         * @var {int|null}
         */
        marginRightHover: null,

        /**
         * Margin bottom hover
         *
         * @var {int|null}
         */
        marginBottomHover: null,

        /**
         * Margin left hover
         *
         * @var {int|null}
         */
        marginLeftHover: null,

        /**
         * Has margin hover
         *
         * @var {boolean|null}
         */
        hasMarginHover: null,

        /**
         * Has margin animation
         *
         * @var {boolean|null}
         */
        hasMarginAnimation: null,

        /**
         * Relative container
         *
         * @var {Object}
         */
        relativeContainer: null,

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [
            "marginTop",
            "marginRight",
            "marginBottom",
            "marginLeft",
            "marginTopHover",
            "marginRightHover",
            "marginBottomHover",
            "marginLeftHover",
            "hasMarginHover",
            "hasMarginAnimation"
        ],

        /**
         * Init
         */
        init: function () {
            this.marginTop = null;
            this.marginRight = null;
            this.marginBottom = null;
            this.marginLeft = null;
            this.marginTopHover = null;
            this.marginRightHover = null;
            this.marginBottomHover = null;
            this.marginLeftHover = null;
            this.hasMarginHover = false;
            this.hasMarginAnimation = false;

            this.relativeContainer = null;

            this.create(
                {
                    groupContainerSelector: ".margin-container",
                    updateSampleEventName: "update-margin-sample",
                    title: this.getOption(["labels", "margin"])
                }
            );

            this
                .setRelativeContainer()
                .setMarginTop()
                .setMarginRight()
                .setMarginBottom()
                .setMarginLeft()
                .setMarginHover()
                .setHasAnimation()
                .updateSample();
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
         * Sets margin-top
         */
        setMarginTop: function () {
            if (this.marginTop === null) {
                return this;
            }

            var hover = null;

            if (this.marginTopHover !== null) {
                hover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.marginTopHover,
                        css: "margin-top-hover",
                        iconBefore: "fas fa-mouse-pointer",
                        appendTo: this.relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this.marginTopHover = value;
                                this.update();
                            },
                            this
                        )
                    }
                );
            }

            ss.init(
                "commonComponentsFormSpinner",
                {
                    value: this.marginTop,
                    css: "margin-top",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var marginTop = this.marginTop;
                            var marginTopHover
                                = this.marginTopHover;
                            if (marginTop === marginTopHover
                                && hover !== null
                            ) {
                                this.marginTopHover = value;
                                hover.setValue(value);
                            }

                            this.marginTop = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets margin-right
         */
        setMarginRight: function () {
            if (this.marginRight === null) {
                return this;
            }

            var hover = null;

            if (this.marginRightHover !== null) {
                hover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.marginRightHover,
                        css: "margin-right-hover",
                        iconBefore: "fas fa-mouse-pointer",
                        appendTo: this.relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this.marginRightHover = value;
                                this.update();
                            },
                            this
                        )
                    }
                );
            }

            ss.init(
                "commonComponentsFormSpinner",
                {
                    value: this.marginRight,
                    css: "margin-right",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var marginRight
                                = this.marginRight;
                            var marginRightHover
                                = this.marginRightHover;
                            if (marginRight === marginRightHover
                                && hover !== null
                            ) {
                                this.marginRightHover = value;
                                hover.setValue(value);
                            }

                            this.marginRight = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets margin-bottom
         */
        setMarginBottom: function () {
            if (this.marginBottom === null) {
                return this;
            }

            var hover = null;

            if (this.marginBottomHover !== null) {
                hover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.marginBottomHover,
                        css: "margin-bottom-hover",
                        iconBefore: "fas fa-mouse-pointer",
                        appendTo: this.relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this.marginBottomHover = value;
                                this.update();
                            },
                            this
                        )
                    }
                );
            }

            ss.init(
                "commonComponentsFormSpinner",
                {
                    value: this.marginBottom,
                    css: "margin-bottom",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var marginBottom
                                = this.marginBottom;
                            var marginBottomHover
                                = this.marginBottomHover;
                            if (marginBottom === marginBottomHover
                                && hover !== null
                            ) {
                                this.marginBottomHover = value;
                                hover.setValue(value);
                            }

                            this.marginBottom = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets margin-left
         */
        setMarginLeft: function () {
            if (this.marginLeft === null) {
                return this;
            }

            var hover = null;

            if (this.marginLeftHover !== null) {
                hover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.marginLeftHover,
                        css: "margin-left-hover",
                        iconBefore: "fas fa-mouse-pointer",
                        appendTo: this.relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this.marginLeftHover = value;
                                this.update();
                            },
                            this
                        )
                    }
                );
            }

            ss.init(
                "commonComponentsFormSpinner",
                {
                    value: this.marginLeft,
                    css: "margin-left",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var marginLeft
                                = this.marginLeft;
                            var marginLeftHover
                                = this.marginLeftHover;
                            if (marginLeft === marginLeftHover
                                && hover !== null
                            ) {
                                this.marginLeftHover = value;
                                hover.setValue(value);
                            }

                            this.marginLeft = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets margin hover
         */
        setMarginHover: function () {
            if (this.hasMarginHover === true) {
                this.getGroupContainer().addClass("has-hover");
            }

            if (this.hasMarginHover === null) {
                return this;
            }

            var onCheck = $.proxy(
                function () {
                    this.hasMarginHover = true;
                    this.getGroupContainer().addClass("has-hover");
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this.hasMarginHover = false;
                    this.getGroupContainer().removeClass("has-hover");
                    this.update();
                },
                this
            );

            console.log(this.getGroupContainer());

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    value: this.hasMarginHover,
                    label: this.getLabel("mouseHoverEffect"),
                    onCheck: onCheck,
                    onUnCheck: onUnCheck,
                    appendTo: this.getGroupContainer()
                }
            );

            return this;
        },

        /**
         * Sets margin animation
         */
        setHasAnimation: function () {
            if (this.hasMarginAnimation === null) {
                return this;
            }

            var onCheck = $.proxy(
                function () {
                    this.hasMarginAnimation = true;
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this.hasMarginAnimation = false;
                    this.update();
                },
                this
            );

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    value: this.hasMarginAnimation,
                    label: this.getLabel("mouseHoverAnimation"),
                    css: "has-animation",
                    onCheck: onCheck,
                    onUnCheck: onUnCheck,
                    appendTo: this.getGroupContainer()
                }
            );

            return this;
        },

        /**
         * Generates margin styles
         */
        generateCss: function (isHover) {
            if (isHover === true) {
                if (this.hasMarginHover !== true) {
                    return "";
                }

                return this.getCss(
                    this.getIntValue(
                        this.marginTopHover
                    ),
                    this.getIntValue(
                        this.marginRightHover
                    ),
                    this.getIntValue(
                        this.marginBottomHover
                    ),
                    this.getIntValue(
                        this.marginLeftHover
                    )
                );
            }

            return this.getCss(
                this.getIntValue(
                    this.marginTop
                ),
                this.getIntValue(
                    this.marginRight
                ),
                this.getIntValue(
                    this.marginBottom
                ),
                this.getIntValue(
                    this.marginLeft
                )
            );
        },

        /**
         * Gets margin CSS
         *
         * @param {Number|String} marginTop
         * @param {Number|String} marginRight
         * @param {Number|String} marginBottom
         * @param {Number|String} marginLeft
         *
         * @returns {String}
         */
        getCss: function (marginTop, marginRight, marginBottom, marginLeft) {
            if (marginTop !== 0) {
                marginTop += "px";
            }

            if (marginRight !== 0) {
                marginRight += "px";
            }

            if (marginBottom !== 0) {
                marginBottom += "px";
            }

            if (marginLeft !== 0) {
                marginLeft += "px";
            }

            var css = "margin:";
            css += marginTop;
            css += " ";
            css += marginRight;
            css += " ";
            css += marginBottom;
            css += " ";
            css += marginLeft;
            css += ";";

            return css;
        },

        /**
         * Has animation
         *
         * @return {boolean}
         */
        hasAnimation: function () {
            return this.hasMarginHover === true
                && this.hasMarginAnimation === true;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
