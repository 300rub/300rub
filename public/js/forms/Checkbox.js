!function ($, TestS) {
    'use strict';

    /**
     * Checkbox form
     */
    TestS.Form.prototype.setCheckbox = function () {
        var $labelContainer = $("<label/>")
            .addClass("checkbox-label-container");

        var $inputCheckbox = $("<input/>")
            .attr("type", "checkbox")
            .addClass("checkbox");

        var $iconsContainer = $("<span/>")
            .addClass("icons");

        var $unchecked = $("<i/>")
            .addClass("fa")
            .addClass("fa-square-o");

        var $checked = $("<i/>")
            .addClass("fa")
            .addClass("fa-check-square-o");

        var $labelText = $("<span/>")
            .addClass("label-text")
            .text(123);

        $labelContainer.append($inputCheckbox);
        $labelContainer.append($iconsContainer);
        $labelContainer.append($labelText);
        $iconsContainer.append($unchecked);
        $iconsContainer.append($checked);

        this.$_instance = $labelContainer;
    };
}(window.jQuery, window.TestS);