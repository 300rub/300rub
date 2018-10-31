!function ($, ss) {
    "use strict";

    var name = "commonContentMenuHorizontal";

    var parameters = {
        /**
         * Menu
         *
         * @var {Object}
         */
        menuElement: null,

        /**
         * Init
         */
        init: function () {
            this.menuElement = null;

            $(window).resize(
                $.proxy(
                    function () {
                        this.setMenu();
                    },
                    this
                )
            );

            this
                .setMenuElement()
                .setMenu();
        },

        /**
         * Sets menu element
         */
        setMenuElement: function () {
            this.menuElement = $(this.getOption("selector"));
            return this;
        },

        /**
         * Sets menu
         */
        setMenu: function () {
            this.width = this.menuElement.width();
            this.setRight(this.menuElement.find("> ul"), 0);
        },

        /**
         * Sets right class for overlaid menu items
         *
         * @param {Object} object
         * @param {int}    leftPosition
         */
        setRight: function (object, leftPosition) {
            var t = this;

            object.find("> li").each(
                function () {
                    var liWidth = $(this).width();
                    var liLeft = $(this).position().left;
                    var ulElement = $(this).find("> ul");
                    var ulWidth = ulElement.width();
                    var rightValue = leftPosition + liLeft + liWidth + ulWidth;
                    var left = 0;

                    if (rightValue > t.width) {
                        ulElement.addClass("right");
                        if (leftPosition > 0) {
                            left = leftPosition + (liLeft - ulWidth);
                        } else {
                            left = liLeft + (liWidth - ulWidth);
                        }
                    } else {
                        left = leftPosition + liLeft + liWidth;
                    }

                    t.setRight(ulElement, left);
                }
            );
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
