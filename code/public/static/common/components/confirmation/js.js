!function ($, ss) {
    "use strict";

    var name = "commonComponentsConfirmation";

    var parameters = {
        /**
         * Window
         *
         * @var {Object}
         */
        window: null,

        /**
         * Overlay
         *
         * @var {Object}
         */
        overlay: null,

        /**
         * Init
         */
        init: function () {
            this
                .setOverlay()
                .setWindow()
                .setButtons()
                .setPosition();
        },

        /**
         * Sets window
         */
        setWindow: function () {
            this.window = ss.init("template").get("confirmation-window");
            this.window.find(".text").text(this.getOption("text"));
            ss.init("app").append(this.window);

            return this;
        },

        /**
         * Sets overlay
         */
        setOverlay: function () {
            this.overlay = ss.init("template").get("confirmation-overlay");

            ss.init("app").append(this.overlay);

            this.overlay.on(
                "click",
                $.proxy(
                    function () {
                        this.window.remove();
                        this.overlay.remove();
                    },
                    this
                )
            );

            return this;
        },

        /**
         * Sets buttons
         */
        setButtons: function () {
            var buttons = this.window.find(".buttons");

            if ($.type(this.getOption("ajax")) === "object") {
                ss.init(
                    "commonComponentsFormButton",
                    {
                        css: "btn btn-red btn-small",
                        icon: this.getOption(["yes", "icon"]),
                        label: this.getOption(["yes", "label"]),
                        appendTo: buttons,
                        ajax: $.extend(
                            {},
                            this.getOption("ajax"),
                            {
                                complete: $.proxy(
                                    function () {
                                        this.window.remove();
                                        this.overlay.remove();
                                    },
                                    this
                                )
                            }
                        )
                    }
                );
            } else {
                ss.init(
                    "commonComponentsFormButton",
                    {
                        css: "btn btn-red btn-small",
                        icon: this.getOption(["yes", "icon"]),
                        label: this.getOption(["yes", "label"]),
                        appendTo: buttons,
                        onClick: $.proxy(
                            function () {
                                var onClick = this.getOption("onClick");
                                if ($.type(onClick) === "function") {
                                    onClick();
                                }

                                this.window.remove();
                                this.overlay.remove();
                            },
                            this
                        )
                    }
                );
            }

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-gray btn-small",
                    icon: "fas fa-ban",
                    label: this.getOption("no"),
                    appendTo: buttons,
                    onClick: $.proxy(
                        function () {
                            this.window.remove();
                            this.overlay.remove();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets window position
         */
        setPosition: function () {
            var element = this.getOption("element");
            if (element === null) {
                return this;
            }

            var elementLeft = element.offset().left;
            var elementTop = element.offset().top;
            var elementWidth = element.outerWidth();
            var elementHeight = element.outerHeight();
            var windowWidth = this.window.outerWidth();

            var elementLeftCenter = (elementWidth / 2);
            var confirmLeftCenter = (windowWidth / 2);
            var left = elementLeft + (elementLeftCenter - confirmLeftCenter);
            if (left < 0) {
                left = 0;
            }

            var elementTopCenter = (elementHeight / 2);
            var confirmTopCenter = (windowWidth / 2);
            var top = elementTop + (elementTopCenter - confirmTopCenter);
            if (top < 0) {
                top = 0;
            }

            this.window.css(
                {
                    "left": left,
                    "top": top
                }
            );

            return this;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
