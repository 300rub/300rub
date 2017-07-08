!function ($, TestS) {
    'use strict';

    /**
     * Accordion
     */
    TestS.Accordion = {

        /**
         * Init
         *
         * @param {Object} $container
         */
        set: function ($container) {
            this.$_container.find(".accordion-container:first-child").addClass("opened");

            this._setClickEvent($container);
        },

        /**
         * Sets click event
         *
         * @param {Object} $container
         *
         * @return {TestS.Accordion}
         *
         * @private
         */
        _setClickEvent: function ($container) {
            $container.find(".accordion-title").off().on("click", function () {
                var $accordionContainer = $(this).parent();
                if ($accordionContainer.hasClass("opened")) {
                    $accordionContainer.removeClass("opened");
                } else {
                    $accordionContainer.parent().find(".accordion-container").removeClass("opened");
                    $accordionContainer.addClass("opened");
                }
            });

            return this;
        },

        /**
         * Gets element
         *
         * @param {String} title
         * @param {Object} $body
         *
         * @returns {Object}
         */
        getElement: function (title, $body) {
            var $element = TestS.Template.get("accordion-container");

            $element.find(".accordion-title").text(title);
            $element.find(".accordion-body").append($body);

            return $element;
        }
    };
}(window.jQuery, window.TestS);