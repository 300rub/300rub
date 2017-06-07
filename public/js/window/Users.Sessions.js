!function ($, TestS) {
    'use strict';

    /**
     * Users sessions window
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    TestS.Window.Users.Sessions = function (options) {
        this._options = options;
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Window.Users.Sessions.prototype = {

        /**
         * @type {Window.TestS.Window}
         */
        _window: null,

        /**
         * @type {Object}
         */
        _options: {},

        /**
         * Init
         */
        init: function () {
            this._window = new TestS.Window({
                controller: "user",
                action: "sessions",
                data: {
                    id: this._options.id
                },
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "users.sessions",
                level: 2,
                parent: {
                    name:"users",
                    isHide: true
                }
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
            $.each(data.list, $.proxy(function (i, session) {
                $tr = $trTemplate.clone();
                $tr.find(".browser-value").text(session.browser + " " + session.version);
                $tr.find(".last-activity-value").text(session.lastActivity);
                $tr.find(".ip-value").text(session.ip);
                $tr.find(".platform-value").text(session.platform);
                if (session.isCurrent !== true) {
                    $tr.find(".current-value").text("");
                }
                if (session.isOnline !== true) {
                    $tr.find(".online-value").text("");
                }

                $buttons = $tr.find(".buttons");
                $buttons.addClass("align-right");

                if (data.canDelete === true) {
                    new TestS.Form({
                        type: "button",
                        class: "gray-button button-small",
                        icon: "fa-trash",
                        label: data.labels.delete,
                        appendTo: $buttons
                        // onClick: this._sessionsOnClick,
                        // data: {
                        //     id: user.id
                        // }
                    });
                }

                $table.append($tr);
            }, this));
            $trTemplate.remove();

            this._window.getBody().append($table);

            if (data.canDelete === true) {
                new TestS.Form({
                    type: "button",
                    class: "gray-button button-medium margin-bottom-15",
                    icon: "fa-trash",
                    label: data.labels.deleteAllSessions,
                    appendTo: this._window.getBody()
                });
            }

            this._window
                .setTitle(data.title)
                .removeLoading();
        }
    };
}(window.jQuery, window.TestS);