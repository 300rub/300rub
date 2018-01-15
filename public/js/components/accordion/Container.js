!function ($, TestS) {
    'use strict';

    /**
     * Accordion
     *
     * @param {Object} container
     */
    TestS.Components.Accordion.Container = function (container) {
        container.find(".accordion-title").off().on(
            "click",
            function () {
                var accordionContainer = $(this).parent();
                if (accordionContainer.hasClass("opened")) {
                    accordionContainer.removeClass("opened");
                    return true;
                }

                accordionContainer
                    .parent()
                    .find(".accordion-container")
                    .removeClass("opened");
                accordionContainer.addClass("opened");
                return true;
            }
        );
    };
}(window.jQuery, window.TestS);
