!function ($, Ss) {
    'use strict';

    /**
     * Users window
     *
     * @type {Object}
     */
    Ss.Window.Users.List = function () {
        Ss.Window.Abstract.call(
            this,
            {
                group: "user",
                controller: "users",
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "users"
            }
        );
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    Ss.Window.Users.List.prototype
        = Object.create(Ss.Window.Abstract.prototype);

    /**
     * Constructor
     */
    Ss.Window.Users.List.prototype.constructor = Ss.Window.Users.List;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    Ss.Window.Users.List.prototype._onLoadDataSuccess = function (data) {
        this.getWindow().find(".footer").remove();

        this.setTitle(data.title);

        var table = Ss.Components.Template.get("window-users-table");
        table.find(".name-label").text(data.labels.name);
        table.find(".email-label").text(data.labels.email);
        table.find(".access-label").text(data.labels.access);
        var trTemplate = table.find(".tr-template");

        $.each(
            data.list,
            $.proxy(
                function (i, user) {
                    var tr = trTemplate.clone();
                    tr.find(".name-value").text(user.name);
                    tr.find(".email-value").text(user.email);
                    tr.find(".access-value").text(user.access);
                    var buttons = tr.find(".buttons");
                    buttons.addClass("align-right");

                    if (user.canViewSessions === true) {
                        new Ss.Form.Button(
                            {
                                css: "gray-button button-small",
                                icon: "fa-users",
                                label: data.labels.sessions,
                                appendTo: buttons,
                                onClick: function () {
                                    new Ss.Window.Users.Sessions(
                                        {
                                            id: user.id
                                        }
                                    );
                                }
                            }
                        );
                    }

                    if (user.canUpdate === true) {
                        new Ss.Form.Button(
                            {
                                css: "gray-button button-small",
                                icon: "fa-pencil",
                                label: data.labels.edit,
                                appendTo: buttons,
                                onClick: function () {
                                    new Ss.Window.Users.Form({id: user.id});
                                }
                            }
                        );
                    }

                    if (user.canDelete === true) {
                        new Ss.Form.Button(
                            {
                                css: "gray-button button-small",
                                icon: "fa-trash",
                                label: data.labels.deleteLabel,
                                appendTo: buttons,
                                confirm: {
                                    text: data.labels.deleteUserConfirmText,
                                    yes: {
                                        label: data.labels.deleteLabel,
                                        icon: "fa-trash"
                                    },
                                    no: data.labels.no
                                },
                                ajax: {
                                    data: {
                                        group: "user",
                                        controller: "user",
                                        data: {
                                            id: user.id
                                        }
                                    },
                                    type: "DELETE",
                                    error: $.proxy(this.onError, this),
                                    success: function () {
                                        tr.remove();
                                    }
                                }
                            }
                        );
                    }

                    table.append(tr);
                },
                this
            )
        );
        trTemplate.remove();

        this.getBody().append(table);

        new Ss.Form.Button(
            {
                css: "gray-button button-medium margin-bottom-15",
                icon: "fa-user-plus",
                label: data.labels.add,
                appendTo: this.getBody(),
                onClick: function () {
                    new Ss.Window.Users.Form({id: 0});
                }
            }
        );
    };
}(window.jQuery, window.Ss);
