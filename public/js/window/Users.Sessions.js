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
        this._options = $.extend({}, options);
        this._window = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Window.Users.Sessions.prototype = {
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
                parent: "users"
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
            $table.find(".browser-label").text(data["labels"]["browser"]);
            $table.find(".current-label").text(data["labels"]["current"]);
            $table.find(".online-label").text(data["labels"]["online"]);
            $table.find(".last-activity-label").text(data["labels"]["lastActivity"]);
            $table.find(".platform-label").text(data["labels"]["platform"]);
            $table.find(".token-label").text(data["labels"]["token"]);

            var $trTemplate = $table.find(".tr-template");
            var canDeleteAll = false;
            $.each(data["list"], $.proxy(function (i, session) {
                var $tr = $trTemplate.clone();
                $tr.find(".browser-value").text(session["browser"] + " " + session["version"]);
                $tr.find(".last-activity-value").text(session["lastActivity"]);
                $tr.find(".ip-value").text(session["ip"]);
                $tr.find(".platform-value").text(session["platform"]);
                if (session["isCurrent"] !== true) {
                    $tr.find(".current-value").text("");
                }
                if (session["isOnline"] !== true) {
                    $tr.find(".online-value").text("");
                }

                var $buttons = $tr.find(".buttons");
                $buttons.addClass("align-right");

                if (data["canDelete"] === true
                    && session.token !== TestS.getToken()
                ) {
                    new TestS.Form({
                        type: "button",
                        class: "gray-button button-small",
                        icon: "fa-trash",
                        label: data["labels"].delete,
                        appendTo: $buttons,
                        confirm: {
                            text: data["labels"]["deleteConfirm"]["text"],
                            yes: {
                                label: data["labels"]["deleteConfirm"]["yes"],
                                icon: "fa-trash"
                            },
                            no: data["labels"]["deleteConfirm"]["no"]
                        },
                        ajax: {
                            data: {
                                controller: "user",
                                action: "session",
                                data: {
                                    token: session.token
                                }
                            },
                            type: "DELETE",
                            error: $.proxy(this._window.onError, this._window),
                            success: function() {
                                if (session.token === TestS.getToken()) {
                                    window.location.reload();
                                } else {
                                    $tr.remove();
                                }
                            }
                        }
                    });

                    canDeleteAll = true;
                }

                $table.append($tr);
            }, this));
            $trTemplate.remove();

            this._window.getBody().append($table);

            if (canDeleteAll === true) {
                new TestS.Form({
                    type: "button",
                    class: "gray-button button-medium margin-bottom-15",
                    icon: "fa-trash",
                    label: data["labels"]["deleteAllSessions"],
                    appendTo: this._window.getBody(),
                    confirm: {
                        text: data["labels"]["deleteAllConfirm"]["text"],
                        yes: {
                            label: data["labels"]["deleteAllConfirm"]["yes"],
                            icon: "fa-trash"
                        },
                        no: data["labels"]["deleteAllConfirm"]["no"]
                    },
                    ajax: {
                        data: {
                            controller: "user",
                            action: "sessions",
                            data: {
                                id: id
                            }
                        },
                        type: "DELETE",
                        error: $.proxy(this._window.onError, this._window),
                        success: $.proxy(this._window.remove, this._window)
                    }
                });
            }

            this._window
                .setTitle(data["title"])
                .removeLoading();
        }
    };
}(window.jQuery, window.TestS);