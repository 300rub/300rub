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
            $.each(data.list, $.proxy(function(key, name) {
                item = TestS.Template.get("panel-list-item");

                item.addClass("without-buttons");
                item.find(".settings").remove();
                item.find(".design").remove();
                item.find(".text").text(name);

                switch (key) {
                    case "users":
                        item.find(".icon").addClass("fa-user");
                        item.find(".label").on("click", function() {
                            new TestS.Window.Users();
                        });
                        break;
                    case "icon":
                        item.find(".icon").addClass("fa-picture-o");
                        break;
                    default:
                        break;
                }

                this._panel.getBody().append(item);
            }, this));

            this._panel
                .setMaxHeight()
                .removeLoading();
        }
    };
}(window.jQuery, window.TestS);