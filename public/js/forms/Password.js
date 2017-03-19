!function ($, TestS) {
    'use strict';

    /**
     * Text form
     */
    TestS.Form.prototype.setPassword = function () {
        this.$_instance = $("<input />");
        this.$_instance
            .attr("type", "password")
            .addClass("form-instance");
    };
}(window.jQuery, window.TestS);