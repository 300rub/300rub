!function ($, TestS) {
    'use strict';

    /**
     * Users sessions window
     *
     * @type {Object}
     */
    TestS.Window.Users.Sessions = function () {
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Window.Users.Sessions.prototype = {

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
                action: "sessions",
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "users.sessions"
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

            var $table = TestS.Template.get("window-users-sessions-table");
            $table.find(".browser-label").text(data.labels.browser);
            $table.find(".current-label").text(data.labels.current);
            $table.find(".online-label").text(data.labels.online);
            $table.find(".last-activity-label").text(data.labels.lastActivity);
            $table.find(".platform-label").text(data.labels.platform);
            $table.find(".token-label").text(data.labels.token);

            var $trTemplate = $table.find(".tr-template");
            var $tr, $buttons;
            $.each(data.list, $.proxy(function (i, user) {
                $tr = $trTemplate.clone();
                $tr.find(".browser-value").text(user.browser + " " + user.version);
                $tr.find(".last-activity-value").text(user.lastActivity);
                $tr.find(".ip-value").text(user.ip);
                $tr.find(".platform-value").text(user.platform);
                if (user.isCurrent !== true) {
                    $tr.find(".current-value").text("");
                }
                if (user.isOnline !== true) {
                    $tr.find(".online-value").text("");
                }

                $table.append($tr);
            }, this));
            $trTemplate.remove();

            console.log(data);

            this._window.getBody().append($table);

            this._window
                .setTitle(data.title)
                .removeLoading();
        }
    };
}(window.jQuery, window.TestS);