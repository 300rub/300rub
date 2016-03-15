!function ($, c) {
    "use strict";

    c.Design = function ($container, data) {
        this.$container = $container;
        this.data = data;
        this.init();
    };

    c.Design.prototype = {
        constructor: c.Design,

        init: function () {
            if (this.data.angle !== undefined) {
                $.each(this.data.angle, function (i, data) {
                    this._setAngles(data);
                });
            }
        },

        _setAngles: function (data) {

        }
    };

    $.design = function ($container, data) {
        return new c.Design($container, data);
    };
}(window.jQuery, window.Core);