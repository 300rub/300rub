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
            var $tr, $buttons;
            $.each(data.list, $.proxy(function (i, user) {
                $tr = $trTemplate.clone();
                $tr.find(".name-value").text(user.name);
                $tr.find(".email-value").text(user.email);
                $tr.find(".access-value").text(user.access);
                $buttons = $tr.find(".buttons");
                $buttons.addClass("align-right");

                new TestS.Form({
                    type: "button",
                    class: "gray-button button-small",
                    icon: "fa-lock",
                    label: data.labels.sessions,
                    appendTo: $buttons,
                    onClick: $.proxy(this._sessionsOnClick)
                });

                new TestS.Form({
                    type: "button",
                    class: "gray-button button-small",
                    icon: "fa-lock",
                    label: data.labels.edit,
                    appendTo: $buttons
                });

                new TestS.Form({
                    type: "button",
                    class: "gray-button button-small",
                    icon: "fa-lock",
                    label: data.labels.delete,
                    appendTo: $buttons
                });

                $table.append($tr);
            }, this));
            $trTemplate.remove();

            this._window.getBody().append($table);

            new TestS.Form({
                type: "button",
                class: "gray-button button-medium margin-bottom-15",
                icon: "fa-plus",
                label: data.labels.add,
                appendTo: this._window.getBody()
            });

            this._window
                .setTitle(data.title)
                .removeLoading();
        },

        _sessionsOnClick: function () {
            console.log(123);
        }
    };
}(window.jQuery, window.TestS);