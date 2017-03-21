!function ($, TestS) {
    'use strict';

    /**
     * Text form
     */
    TestS.Form.prototype.setPasswordForm = function () {
        var $formContainer = $("<div/>")
            .addClass("form-container");

        var $formInstance = $("<input />")
            .attr("type", "password")
            .addClass("form-instance");

        var $errorContainer = $("<div />")
            .addClass("error-container");
        var $errorIcon = $("<i />")
            .addClass("fa")
            .addClass("fa-remove");
        var $errorText = $("<span />");
        $errorContainer.append($errorIcon);
        $errorContainer.append($errorText);

        if (this.options.label !== undefined) {
            var $labelContainer = $("<label/>")
                .addClass("label-container");
            var $labelText = $("<span />")
                .addClass("label-text")
                .text(this.options.label);
            $labelContainer.append($labelText);

            $labelContainer.append($formInstance);
            $labelContainer.append($errorContainer);

            $formContainer.append($labelContainer);
        } else {
            $formContainer.append($formInstance);
            $formContainer.append($errorContainer);
        }

        this.$_form = $formContainer;
    };
}(window.jQuery, window.TestS);