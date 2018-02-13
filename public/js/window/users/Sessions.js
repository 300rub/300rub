!function ($, Ss) {
    'use strict';

    /**
     * Users sessions window
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    Ss.Window.Users.Sessions = function (options) {
        Ss.Window.Abstract.call(
            this,
            {
                group: "user",
                controller: "sessions",
                data: {
                    id: options.id
                },
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "users.sessions",
                level: 2,
                parent: "users"
            }
        );

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    Ss.Window.Users.Sessions.prototype
        = Object.create(Ss.Window.Abstract.prototype);

    /**
     * Constructor
     */
    Ss.Window.Users.Sessions.prototype.constructor
        = Ss.Window.Users.Sessions;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    Ss.Window.Users.Sessions.prototype._onLoadDataSuccess = function (data) {
        this.getWindow().find(".footer").remove();

        this.setTitle(data.title);

        var table = Ss.Components.Template.get(
            "window-users-sessions-table"
        );
        table.find(".browser-label").text(data.labels.browser);
        table.find(".current-label").text(data.labels.current);
        table.find(".online-label").text(data.labels.online);
        table.find(".last-activity-label").text(data.labels.lastActivity);
        table.find(".platform-label").text(data.labels.platform);
        table.find(".token-label").text(data.labels.token);

        var trTemplate = table.find(".tr-template");
        var canDeleteAll = false;
        $.each(
            data.list,
            $.proxy(
                function (i, session) {
                    var tr = trTemplate.clone();
                    tr.find(".browser-value").text(
                        session.browser + " " + session.version
                    );
                    tr.find(".last-activity-value").text(session.lastActivity);
                    tr.find(".ip-value").text(session.ip);
                    tr.find(".platform-value").text(session.platform);
                    if (session.isCurrent !== true) {
                        tr.find(".current-value").text("");
                    }

                    if (session.isOnline !== true) {
                        tr.find(".online-value").text("");
                    }

                    var buttons = tr.find(".buttons");
                    buttons.addClass("align-right");

                    if (data.canDelete === true
                        && session.token !== Ss.System.App.getToken()
                    ) {
                        this._addDelete(data, session, tr, buttons);

                        canDeleteAll = true;
                    }

                    table.append(tr);
                },
                this
            )
        );
        trTemplate.remove();

        this.getBody().append(table);

        if (canDeleteAll === true) {
            this._addDeleteAll(data);
        }
    };

    /**
     * Adds delete button
     *
     * @param {Object} data
     * @param {Object} session
     * @param {Object} tr
     * @param {Object} buttons
     *
     * @private
     */
    Ss.Window.Users.Sessions.prototype._addDelete = function (
        data,
        session,
        tr,
        buttons
    ) {
        new Ss.Form.Button(
            {
                css: "gray-button button-small",
                icon: "fa-trash",
                label: data.labels.deleteLabel,
                appendTo: buttons,
                confirm: {
                    text: data.labels.deleteConfirm.text,
                    yes: {
                        label: data.labels.deleteConfirm.yes,
                        icon: "fa-trash"
                    },
                    no: data.labels.deleteConfirm.no
                },
                ajax: {
                    data: {
                        group: "user",
                        controller: "session",
                        data: {
                            token: session.token
                        }
                    },
                    type: "DELETE",
                    error: $.proxy(this.onError, this),
                    success: function () {
                        if (session.token === Ss.System.App.getToken()) {
                            window.location.reload();
                        } else {
                            tr.remove();
                        }
                    }
                }
            }
        );
    };

    /**
     * On load window success
     *
     * @param {Object} data
     *
     * @private
     */
    Ss.Window.Users.Sessions.prototype._addDeleteAll = function (data) {
        new Ss.Form.Button(
            {
                css: "gray-button button-medium margin-bottom-15",
                icon: "fa-trash",
                label: data.labels.deleteAllSessions,
                appendTo: this.getBody(),
                confirm: {
                    text: data.labels.deleteAllConfirm.text,
                    yes: {
                        label: data.labels.deleteAllConfirm.yes,
                        icon: "fa-trash"
                    },
                    no: data.labels.deleteAllConfirm.no
                },
                ajax: {
                    data: {
                        group: "user",
                        controller: "sessions",
                        data: {
                            id: data.id
                        }
                    },
                    type: "DELETE",
                    error: $.proxy(this.onError, this),
                    success: $.proxy(this.remove, this)
                }
            }
        );
    };
}(window.jQuery, window.Ss);
