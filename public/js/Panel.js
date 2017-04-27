!function ($, TestS) {
    'use strict';

    /**
     * Panel
     *
     * @type {TestS.Window}
     */
    TestS.Panel = function (options) {
        this._options = $.extend({}, options);
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.prototype = {

        /**
         * _options
         *
         * @var {Object}
         */
        _options: {},

        /**
         * Window
         *
         * @var {Object}
         */
        $_instance: null,

        /**
         * Body
         *
         * @var {Object}
         */
        $_body: null,

        /**
         * Init
         */
        init: function () {
            this.$_instance = TestS.Template.get("panel");

            this._addDomElement();

            return this;
        },

        /**
         * Gets instance
         *
         * @returns {Object}
         */
        getInstance: function() {
            return this.$_instance;
        },

        /**
         * Adds element to DOM
         *
         * @returns {TestS.Panel}
         *
         * @private
         */
        _addDomElement: function() {
            TestS.append(this.getInstance());

            setTimeout($.proxy(function() {
                this.getInstance().dialog({
                    dialogClass: "panel-dialog",
                    closeText: "",
                    title: "Title 123",
                    width: 300,
                    show: 150,
                    hide: 150,
                    open: $.proxy(function( event, ui ) {
                        var $dialog = this.getInstance().parent();
                        var $panelDescription = TestS.Template.get("panel-description");
                        this.getInstance().parent().find(".ui-dialog-titlebar").append($panelDescription);
                       // $dialog.removeClass("transparent");
                    }, this)
                });



            }, this), 50);

            return this;
        }
    };
}(window.jQuery, window.TestS);