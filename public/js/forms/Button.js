!function ($, TestS) {
    'use strict';

    /**
     * Text form
     */
    TestS.Form.prototype.setButton = function () {
        this.$_instance = $("<button />");
        this.$_instance.addClass("form-instance");

        var html = "";
        if (this._options.icon !== undefined) {
            html += '<i class="fa ' + this._options.icon + '"></i>';
        }

        if (this._options.value !== undefined) {
            html += html + " " + this._options.value;
        }

        this.$_instance.html(html);
    };
}(window.jQuery, window.TestS);