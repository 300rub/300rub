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
         * @var {boolean}
         */
        hasMarginHover: false,

        /**
         * Has margin animation
         *
         * @var {boolean}
         */
        hasMarginAnimation: false,

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
                    updateSampleEvent: "update-margin-sample"
                }
            );

            this
                .setRelativeContainer()
                .setMarginTop()
            ;
        },

        /**
         * Sets relative container
         */
        setRelativeContainer: function() {
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
                        iconBefore: "fa-mouse-pointer",
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
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
