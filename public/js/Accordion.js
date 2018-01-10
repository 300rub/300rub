!function ($, TestS) {
    'use strict';

    /**
     * Accordion
     */
    TestS.Accordion = function ($container) {
        $container.find(".accordion-title").off().on(
            "click",
            function () {
                var $accordionContainer = $(this).parent();
                if ($accordionContainer.hasClass("opened")) {
                    $accordionContainer.removeClass("opened");
                    return true;
                }

                $accordionContainer
                    .parent()
                    .find(".accordion-container")
                    .removeClass("opened");
                $accordionContainer.addClass("opened");
                return true;
            }
        );
    };

    /**
     * Accordion element
     *
     * @param {String} title
     *
     * @type {Object}
     */
    TestS.Accordion.Element = function (title) {
        this._title = title;
        this._container = null;
        this._body = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Accordion.Element.prototype = {
        /**
         * Init
         */
        init: function () {
            this._container = TestS.Template.get("accordion-container");
            this._container.find(".accordion-title .text").text(this._title);
            this._body = this._container.find(".accordion-body");
        },

        /**
         * Adds object to the body
         *
         * @param {Object} $object
         *
         * @return {TestS.Accordion.Element}
         */
        add: function ($object) {
            this._body.append($object);
            return this;
        },

        /**
         * Gets body
         *
         * @return {Object}
         */
        getBody: function () {
            return this._body;
        },

        /**
         * Gets container
         *
         * @return {Object}
         */
        get: function () {
            return this._container;
        },

        /**
         * Appends container to the object
         *
         * @param {Object} $object
         *
         * @return {TestS.Accordion.Element}
         */
        appendTo: function ($object) {
            this._container.appendTo($object);
            return this;
        }
    };
}(window.jQuery, window.TestS);
