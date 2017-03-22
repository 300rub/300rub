!function ($, TestS) {
    'use strict';

    /**
     * Text form
     */
    TestS.Form.prototype.setTextForm = function () {

        if (this.options.label !== undefined) {
            this.$_form = TestS.Template.get("form-container-text-label");
        } else {
            this.$_form = TestS.Template.get("form-container-text");
        }
    };
}(window.jQuery, window.TestS);