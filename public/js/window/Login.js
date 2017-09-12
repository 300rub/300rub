!function ($, TestS) {
    'use strict';

    /**
     * Login window
     *
     * @type {Object}
     */
    TestS.Window.Login = function () {
        this._window = null;
        this._userForm = null;
        this._passwordForm = null;
        this._isRememberForm = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Window.Login.prototype = {
        /**
         * Init
         */
        init: function () {
            this._window = new TestS.Window({
                controller: "user",
                action: "loginForms",
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "login"
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
            this._userForm = new TestS.Form(
                $.extend(
                    {
                        appendTo: this._window.getBody(),
                        type: "text"
                    },
                    data.forms.user
                )
            );

            this._passwordForm = new TestS.Form(
                $.extend(
                    {
                        appendTo: this._window.getBody(),
                        type: "password"
                    },
                    data.forms.password
                )
            );

            this._isRememberForm = new TestS.Form(
                $.extend(
                    {
                        appendTo: this._window.getBody(),
                        type: "checkbox"
                    },
                    data.forms["isRemember"]
                )
            );

            this._window
                .setTitle(data.title)
                .setSubmit({
                    label: data.forms.button.label,
                    icon: "fa-lock",
                    forms: [this._userForm, this._passwordForm, this._isRememberForm],
                    ajax: {
                        data: {
                            controller: "user",
                            action: "session"
                        },
                        type: "POST",
                        success: $.proxy(this._onSuccess, this),
                        error: $.proxy(this._window.onError, this._window)
                    }
                })
                .removeLoading();

            this._userForm.focus();
        },

        /**
         * On success
         *
         * @param {Object} data
         *
         * @private
         */
        _onSuccess: function(data) {
            if ($.type(data.errors) === "object") {
                if (data.errors.user !== undefined) {
                    this._userForm
                        .setError(data.errors.user)
                        .scrollTo()
                        .focus();
                } else if (data.errors.password !== undefined) {
                    this._passwordForm
                        .setError(data.errors.password)
                        .scrollTo()
                        .focus();
                }
            } else {
                window.location.reload();
            }
        }
    };
}(window.jQuery, window.TestS);