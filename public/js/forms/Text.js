!function ($, TestS) {
    'use strict';

    /**
     * Text form
     */
    TestS.Form.prototype.setText = function () {
        this.$_instance = $("<input />");
        this.$_instance
            .attr("type", "text")
            .addClass("form-instance");
    };
}(window.jQuery, window.TestS);