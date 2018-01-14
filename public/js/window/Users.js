!function ($, TestS) {
    'use strict';

    /**
     * Users window
     *
     * @type {Object}
     */
    TestS.Window.Users = function () {
        this._window = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Window.Users.prototype = {
        /**
         * Init
         */
        init: function () {
            this._window = new TestS.Window({
                group: "user",
                controller: "users",
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

            var $table = TestS.Template.get("window-users-table");
            $table.find(".name-label").text(data.labels.name);
            $table.find(".email-label").text(data.labels.email);
            $table.find(".access-label").text(data.labels.access);
            var $trTemplate = $table.find(".tr-template");

            $.each(data.list, $.proxy(function (i, user) {
                var $tr = $trTemplate.clone();
                $tr.find(".name-value").text(user.name);
                $tr.find(".email-value").text(user.email);
                $tr.find(".access-value").text(user.access);
                var $buttons = $tr.find(".buttons");
                $buttons.addClass("align-right");

                if (user.canViewSessions === true) {
                    new TestS.Form.Button({
                        css: "gray-button button-small",
                        icon: "fa-users",
                        label: data.labels.sessions,
                        appendTo: $buttons,
                        onClick: function() {
                            new TestS.Window.Users.Sessions({id: user.id});
                        }
                    });
                }

                if (user.canUpdate === true) {
                    new TestS.Form.Button({
                        css: "gray-button button-small",
                        icon: "fa-pencil",
                        label: data.labels.edit,
                        appendTo: $buttons,
                        onClick: function() {
                            new TestS.Window.Users.Form({id: user.id});
                        }
                    });
                }

                if (user.canDelete === true) {
                    new TestS.Form.Button({
                        css: "gray-button button-small",
                        icon: "fa-trash",
                        label: data.labels.delete,
                        appendTo: $buttons,
                        confirm: {
                            text: data.labels.deleteUserConfirmText,
                            yes: {
                                label: data.labels.delete,
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
                            error: $.proxy(this._window.onError, this._window),
                            success: function() {
                                $tr.remove();
                            }
                        }
                    });
                }

                $table.append($tr);
            }, this));
            $trTemplate.remove();

            this._window.getBody().append($table);

            new TestS.Form.Button({
                css: "gray-button button-medium margin-bottom-15",
                icon: "fa-user-plus",
                label: data.labels.add,
                appendTo: this._window.getBody(),
                onClick: function() {
                    new TestS.Window.Users.Form({id: 0});
                }
            });

            this._window
                .setTitle(data.title)
                .removeLoading();
        }
    };
}(window.jQuery, window.TestS);