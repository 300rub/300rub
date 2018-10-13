!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignHover";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Has hover effect
         *
         * @var {boolean|null}
         */
        hasHover: null,

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [
            "hasHover"
        ],

        /**
         * Init
         */
        init: function () {
            this.hasHover = null;
            this.create();
            this.setHover();
        },

        /**
         * Sets hasHover
         */
        setHover: function () {
            var hoverContainer = this.getOption("hoverContainer");

            if (this.hasHover === null) {
                hoverContainer.addClass("hidden");
                return this;
            }

            if (this.hasHover === true) {
                hoverContainer.removeClass("hidden");
            } else {
                hoverContainer.addClass("hidden");
            }

            var onCheck = $.proxy(
                function () {
                    this.hasHover = true;
                    hoverContainer.removeClass("hidden");
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this.hasHover = false;
                    hoverContainer.addClass("hidden");
                    this.update();
                },
                this
            );

            var checkboxContainer = this.getEditorContainer()
                .find(".hover-checkbox-container");

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    value: this.hasHover,
                    label: this.getLabel("mouseHoverEffect"),
                    appendTo: checkboxContainer,
                    onCheck: onCheck,
                    onUnCheck: onUnCheck
                }
            );

            return this;
        },

        /**
         * Gets hasHover value
         *
         * @returns {boolean}
         */
        getHasHover: function () {
            return this.hasHover;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
