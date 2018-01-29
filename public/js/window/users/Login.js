!function ($, TestS) {
    'use strict';

    /**
     * Login window
     *
     * @type {Object}
     */
    TestS.Window.Users.Login = function () {
        TestS.Window.Abstract.call(
            this,
            {
                group: "user",
                controller: "loginForms",
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "login"
            }
        );

        this._userForm = null;
        this._passwordForm = null;
        this._isRememberForm = null;
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Window.Users.Login.prototype
        = Object.create(TestS.Window.Abstract.prototype);

    /**
     * Constructor
     */
    TestS.Window.Users.Login.prototype.constructor = TestS.Window.Users.Login;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    TestS.Window.Users.Login.prototype._onLoadDataSuccess = function (data) {
        this._userForm = new TestS.Form.Text(
            $.extend(
                {
                    appendTo: this._window.getBody()
                },
                data.forms.user
            )
        );

        this._passwordForm = new TestS.Form.Password(
            $.extend(
                {
                    appendTo: this._window.getBody()
                },
                data.forms.password
            )
        );

        this._isRememberForm = new TestS.Form.Checkbox(
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
                {
                    label: data.forms.button.label,
                    icon: "fa-lock",
                    forms: [
                        this._userForm,
                        this._passwordForm,
                        this._isRememberForm
                    ],
                    ajax: {
                        data: {
                            group: "user",
                            controller: "session"
                        },
                        type: "POST",
                        success: $.proxy(this._onSendSuccess, this),
                        error: $.proxy(this._window.onError, this._window)
                    }
                }
            );

        this._userForm.focus();
    };

    /**
     * On send success
     *
     * @param {Object} [data]
     *
     * @private
     */
    TestS.Window.Users.Login.prototype._onSendSuccess = function (data) {
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
    };
}(window.jQuery, window.TestS);
