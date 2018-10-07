!function ($, ss) {
    'use strict';

    /**
     * Menu horizontal
     *
     * @param {Object} options
     */
    ss.content.menu.Horizontal = function (options) {
        ss.content.menu.Abstract.call(this, options);

        this._width = 0;

        this.init();
    };

    /**
     * Menu horizontal prototype
     *
     * @type {Object}
     */
    ss.content.menu.Horizontal.prototype
        = Object.create(ss.content.menu.Abstract.prototype);

    /**
     * Constructor
     */
    ss.content.menu.Horizontal.prototype.constructor = ss.content.menu.Horizontal;

    /**
     * Init
     */
    ss.content.menu.Horizontal.prototype.init = function () {
        $(window).resize(
            $.proxy(
                function () {
                    this._setMenu();
                },
                this
            )
        );

        this._setMenu();
    };

    /**
     * Sets menu
     *
     * @private
     */
    ss.content.menu.Horizontal.prototype._setMenu = function () {
        this._width = this.getMenu().width();
        this._setRight(this.getMenu().find("> ul"), 0);
    };

    /**
     * Sets right class for overlaid menu items
     *
     * @param {Object} object
     * @param {int}    leftPosition
     *
     * @private
     */
    ss.content.menu.Horizontal.prototype._setRight = function (
        object,
        leftPosition
    ) {
        var t = this;

        object.find("> li").each(
            function () {
                var liWidth = $(this).width();
                var liLeft = $(this).position().left;
                var ulElement = $(this).find("> ul");
                var ulWidth = ulElement.width();
                var rightValue = leftPosition + liLeft + liWidth + ulWidth;
                var left = 0;

                if (rightValue > t._width) {
                    ulElement.addClass("right");
                    if (leftPosition > 0) {
                        left = leftPosition + (liLeft - ulWidth);
                    } else {
                        left = liLeft + (liWidth - ulWidth);
                    }
                } else {
                    left = leftPosition + liLeft + liWidth;
                }

                t._setRight(ulElement, left);
            }
        );
    }

}(window.jQuery, window.ss);
