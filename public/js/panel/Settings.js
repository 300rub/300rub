!function ($, TestS) {
    'use strict';

    /**
     * Settings panel
     *
     * @type {Object}
     */
    TestS.Panel.Settings = function () {
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Settings.prototype = {

        /**
         * @var {Window.TestS.Panel}
         */
        _panel: null,

        /**
         * Init
         */
        init: function () {
            this._panel = new TestS.Panel({
                controller: "settings",
                action: "settings",
                success: $.proxy(this._onLoadDataSuccess, this)
            });
        },

        /**
         * On load panel success
         *
         * @param {Object} [data]
         *
         * @private
         */
        _onLoadDataSuccess: function(data) {
            this._panel
                .setTitle(data.title)
                .setDescription(data.description);

            var item;
            $.each(data.list, $.proxy(function(key, values) {
                item = TestS.Template.get("panel-list-item");
                item.find(".label .text").text(values.name);
                this._panel.getBody().append(item);

            }, this));

            this._panel.removeLoading();
        }
    };
}(window.jQuery, window.TestS);