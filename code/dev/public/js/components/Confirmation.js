!function ($, ss) {
    'use strict';

    /**
     * Confirmation
     *
     * @param {Object} [options]
     *
     * @type {Object}
     */
    ss.components.Confirmation = function (options) {
        this._options = $.extend({}, options);

        this._window = null;
        this._overlay = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.components.Confirmation.prototype = {

        /**
         * Constructor
         */
        constructor: ss.components.Confirmation,

        /**
         * Init
         */
        init: function () {
            this
                ._setOverlay()
                ._setWindow()
                ._setButtons()
                ._setPosition();
        },

        /**
         * Sets window
         *
         * @returns {ss.components.Confirmation}
         *
         * @private
         */
        _setWindow: function() {
            this._window = ss.components.Template.get("confirm-window");
            this._window.find(".text").text(this._options.text);
            ss.system.App.append(this._window);

            return this;
        },

        /**
         * Sets overlay
         *
         * @returns {ss.components.Confirmation}
         *
         * @private
         */
        _setOverlay: function() {
            this._overlay = ss.components.Template.get("confirm-overlay");

            ss.system.App.append(this._overlay);

            this._overlay.on(
                "click",
                $.proxy(function () {
                    this._window.remove();
                    this._overlay.remove();
                }, this)
            );

            return this;
        },

        /**
         * Sets buttons
         *
         * @returns {ss.components.Confirmation}
         *
         * @private
         */
        _setButtons: function() {
            var buttons = this._window.find(".buttons");

            if ($.type(this._options.ajax) === "object") {
                new ss.forms.Button(
                    {
                        css: "btn btn-red btn-small",
                        icon: this._options.yes.icon,
                        label: this._options.yes.label,
                        appendTo: buttons,
                        ajax: $.extend(
                            this._options.ajax,
                            {
                                complete: $.proxy(function () {
                                    this._window.remove();
                                    this._overlay.remove();
                                }, this)
                            }
                        )
                    }
                );
            } else {
                new ss.forms.Button(
                    {
                        css: "btn btn-red btn-small",
                        icon: this._options.yes.icon,
                        label: this._options.yes.label,
                        appendTo: buttons,
                        onClick: $.proxy(function() {
                            this._options.onClick();

                            this._window.remove();
                            this._overlay.remove();
                        }, this)
                    }
                );
            }

            new ss.forms.Button(
                {
                    css: "btn btn-gray btn-small",
                    icon: "fas fa-ban",
                    label: this._options.no,
                    appendTo: buttons,
                    onClick: $.proxy(function () {
                        this._window.remove();
                        this._overlay.remove();
                    }, this)
                }
            );

            return this;
        },

        /**
         * Sets window position
         *
         * @returns {ss.components.Confirmation}
         *
         * @private
         */
        _setPosition: function() {
            var element = this._options.element;
            if (element === undefined) {
                return this;
            }

            var elementLeft = element.offset().left;
            var elementTop = element.offset().top;
            var elementWidth = element.outerWidth();
            var elementHeight = element.outerHeight();

            var elementLeftCenter = (elementWidth / 2);
            var confirmLeftCenter = (this._window.outerWidth() / 2);
            var left = elementLeft + (elementLeftCenter - confirmLeftCenter);
            if (left < 0) {
                left = 0;
            }

            var elementTopCenter = (elementHeight / 2);
            var confirmTopCenter = (this._window.outerWidth() / 2);
            var top = elementTop + (elementTopCenter - confirmTopCenter);
            if (top < 0) {
                top = 0;
            }

            this._window.css(
                {
                    "left": left,
                    "top": top
                }
            );

            return this;
        }
    };
}(window.jQuery, window.ss);
