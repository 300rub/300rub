!function ($, ss) {
    "use strict";

    var name = "adminSettingsUserSession";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsWindowAbstract",

        /**
         * Init
         */
        init: function () {
            this.create(
                {
                    group: "user",
                    controller: "sessions",
                    data: {
                        id: this.getOption("id")
                    },
                    name: "users-sessions",
                    level: 2,
                    parent: "users",
                    hasFooter: false
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            var table = ss.init("template").get(
                "window-users-sessions-table"
            );
            table.find(".browser-label").text(this.getLabel("browser"));
            table.find(".current-label").text(this.getLabel("current"));
            table.find(".online-label").text(this.getLabel("online"));
            table.find(".last-activity-label").text(
                this.getLabel("lastActivity")
            );
            table.find(".platform-label").text(this.getLabel("platform"));
            table.find(".token-label").text(this.getLabel("token"));

            var trTemplate = table.find(".tr-template");
            var canDeleteAll = false;
            $.each(
                this.getData("list", {}),
                $.proxy(
                    function (i, session) {
                        var tr = trTemplate.clone();
                        tr.find(".browser-value").text(
                            session.browser + " " + session.version
                        );
                        tr.find(".last-activity-value").text(
                            session.lastActivity
                        );
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

                        if (this.getData("canDelete") === true
                            && session.token !== ss.init("app").getToken()
                        ) {
                            this.setDeleteButton(session, tr, buttons);

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
                this.setDeleteAllButton();
            }
        },

        /**
         * Sets delete button
         *
         * @param {Object} session
         * @param {Object} tr
         * @param {Object} buttons
         */
        setDeleteButton: function (
            session,
            tr,
            buttons
        ) {
            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-red btn-small",
                    icon: "fas fa-trash",
                    label: this.getLabel("deleteLabel"),
                    appendTo: buttons,
                    confirm: {
                        text: this.getLabel("deleteConfirmText"),
                        yes: {
                            label: this.getLabel("deleteConfirmYes"),
                            icon: "fas fa-trash"
                        },
                        no: this.getLabel("deleteConfirmNo")
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
                        success: function () {
                            if (session.token === ss.init("app").getToken()) {
                                window.location.reload();
                            } else {
                                tr.remove();
                            }
                        }
                    }
                }
            );
        },

        /**
         * Sets delete all button
         */
        setDeleteAllButton: function () {
            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-red margin-bottom-15",
                    icon: "fas fa-trash",
                    label: this.getLabel("deleteAllSessions"),
                    appendTo: this.getBody(),
                    confirm: {
                        text: this.getLabel("deleteAllConfirmText"),
                        yes: {
                            label: this.getLabel("deleteAllConfirmYes"),
                            icon: "fas fa-trash"
                        },
                        no: this.getLabel("deleteAllConfirmNo")
                    },
                    ajax: {
                        data: {
                            group: "user",
                            controller: "sessions",
                            data: {
                                id: this.getData("id")
                            }
                        },
                        type: "DELETE",
                        success: $.proxy(this.remove, this)
                    }
                }
            );
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
