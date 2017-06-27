!function ($, TestS) {
    'use strict';

    /**
     * Users form window
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    TestS.Window.Users.Form = function (options) {
        this._options = options;
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Window.Users.Form.prototype = {

        /**
         * @type {Window.TestS.Window}
         */
        _window: null,

        /**
         * @type {Object}
         */
        _options: {},

        /**
         * Name
         *
         * @var {Object}
         */
        _name: null,

        /**
         * Login
         *
         * @var {Object}
         */
        _login: null,

        /**
         * Email
         *
         * @var {Object}
         */
        _email: null,

        /**
         * Init
         */
        init: function () {
            this._window = new TestS.Window({
                controller: "user",
                action: "user",
                data: {
                    id: this._options.id
                },
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "users.form",
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
            console.log(data);

            this._name = new TestS.Form(
                $.extend(
                    {
                        appendTo: this._window.getBody()
                    },
                    data.name
                )
            );

            this._login = new TestS.Form(
                $.extend(
                    {
                        appendTo: this._window.getBody()
                    },
                    data.login
                )
            );

            this._email = new TestS.Form(
                $.extend(
                    {
                        appendTo: this._window.getBody()
                    },
                    data.email
                )
            );

            this._window
                .setTitle(data.title)
                .setSubmit({
                    type: "button",
                    label: data.button.label,
                    icon: "fa-check",
                    forms: [this._name, this._login, this._email],
                    ajax: {
                        data: {
                            controller: data.button.controller,
                            action: data.button.action
                        },
                        type: "PUT"
                        // success: $.proxy(this._onSuccess, this),
                        // error: $.proxy(this._window.onError, this._window)
                    }
                })
                .removeLoading();
        }
    };
}(window.jQuery, window.TestS);