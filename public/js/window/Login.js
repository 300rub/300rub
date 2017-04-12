!function ($, TestS) {
    'use strict';

    /**
     * Window
     *
     * @type {Object}
     */
    TestS.Window.Login = function () {
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Window.Login.prototype = {

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
                action: "loginForms",
                success: $.proxy(this._onLoadDataSuccess, this)
            });

            this._window.getInstance().addClass("window-login");
        },

        /**
         * On load window success
         *
         * @param {Object} [data]
         *
         * @private
         */
        _onLoadDataSuccess: function(data) {
            var user = new TestS.Form(
                $.extend(
                    {
                        appendTo: this._window.getBody()
                    },
                    data.forms.user
                )
            );

            var password = new TestS.Form(
                $.extend(
                    {
                        appendTo: this._window.getBody()
                    },
                    data.forms.password
                )
            );

            var isRemember = new TestS.Form(
                $.extend(
                    {
                        appendTo: this._window.getBody()
                    },
                    data.forms.isRemember
                )
            );

            this._window
                .setTitle(data.title)
                .setSubmit(
                    $.extend(
                        data.forms.button,
                        {
                            icon: "fa-lock",
                            forms: [user, password, isRemember],
                            ajax: {
                                data: {
                                    controller: data.forms.button.controller,
                                    action: data.forms.button.action,
                                    data: {
                                        user: "asd"
                                    }
                                },
                                type: "PUT"
                            }
                        }
                    )
                )
                .removeLoading();
        }
    };
}(window.jQuery, window.TestS);