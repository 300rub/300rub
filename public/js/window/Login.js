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
            this._window
                .setTitle(data.title)
                .setSubmit(
                    $.extend(
                        {
                            icon: "fa-lock"
                        },
                        data.forms.button
                    )
                )
                .removeLoading();

            var login = new TestS.Form(
                $.extend(
                    {
                        appendTo: this._window.getBody()
                    },
                    data.forms.login
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
        }
    };
}(window.jQuery, window.TestS);