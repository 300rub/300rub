!function ($, c) {
    "use strict";

    c.Form = function () {
        this.init();
    };

    c.Form.prototype = {
        init: function () {

        }
    };

    $.form = function() {
        return new c.Form();
    };
}(window.jQuery, window.Core);