!function ($, TestS) {
    'use strict';

    /**
     * Text form
     */
    TestS.Form.prototype.setButtonForm = function () {
        this.$_form = $("<button />");
        this.$_form.addClass("form-instance");

        var html = "";
        if (this.options.icon !== undefined) {
            html += '<i class="fa ' + this.options.icon + '"></i>';
        }

        if (this.options.value !== undefined) {
            html += html + " " + this.options.value;
        }

        this.$_form.html(html);
    };
}(window.jQuery, window.TestS);