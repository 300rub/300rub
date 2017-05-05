!function ($, TestS) {
    'use strict';

    /**
     * Users window
     *
     * @type {Object}
     */
    TestS.Window.Users = function () {
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Window.Users.prototype = {

        /**
         * @var {Window.TestS.Window}
         */
        _window: null,

        /**
         * Init
         */
        init: function () {
            this._window = new TestS.Window({
                controller: "user",
                action: "users",
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "users"
            });
        },

        /**
         * On load window success
         *
         * @param {Object} [data]
         *
         * @private
         */
        _onLoadDataSuccess: function(data) {
            this._window.getInstance().find(".footer").remove();

            console.log(data);
            var $table = TestS.Template.get("window-users-table");
            $table.find(".name-label").text(data.labels.name);
            $table.find(".email-label").text(data.labels.email);
            $table.find(".access-label").text(data.labels.access);

            var $trTemplate = $table.find(".tr-template");
            var $tr;
            $.each(data.list, function (i, user) {
                $tr = $trTemplate.clone();
                $tr.find(".name-value").text(user.name);
                $tr.find(".email-value").text(user.email);
                $tr.find(".access-value").text(user.access);
                $table.append($tr);
            });
            $trTemplate.remove();

            this._window.getBody().append($table);

            this._window
                .setTitle(data.title)
                .removeLoading();
        }
    };
}(window.jQuery, window.TestS);