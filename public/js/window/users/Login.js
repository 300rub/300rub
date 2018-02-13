!function ($, Ss) {
    'use strict';

    /**
     * Login window
     *
     * @type {Object}
     */
    Ss.Window.Users.Login = function () {
        Ss.Window.Abstract.call(
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
    Ss.Window.Users.Login.prototype
        = Object.create(Ss.Window.Abstract.prototype);

    /**
     * Constructor
     */
    Ss.Window.Users.Login.prototype.constructor = Ss.Window.Users.Login;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    Ss.Window.Users.Login.prototype._onLoadDataSuccess = function (data) {
        this._userForm = new Ss.Form.Text(
            $.extend(
                {
                    appendTo: this.getBody()
                },
                data.forms.user
            )
        );

        this._passwordForm = new Ss.Form.Password(
            $.extend(
                {
                    appendTo: this.getBody()
                },
                data.forms.password
            )
        );

        this._isRememberForm = new Ss.Form.Checkbox(
            $.extend(
                {
                    appendTo: this.getBody()
                },
                data.forms.isRemember
            )
        );

        this
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
                        error: Ss.System.App.showError
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
    Ss.Window.Users.Login.prototype._onSendSuccess = function (data) {
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
}(window.jQuery, window.Ss);
