!function ($, ss) {
    'use strict';

    /**
     * Menu horizontal
     *
     * @param {Object} options
     */
    ss.content.menu.Horizontal = function (options) {
        ss.content.menu.Abstract.call(this, options);
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
    ss.content.menu.Horizontal.prototype.constructor = ss.forms.Select;

    /**
     * Init
     */
    ss.content.menu.Horizontal.prototype.init = function () {
        console.log(this.getMenu());
    };
}(window.jQuery, window.ss);
