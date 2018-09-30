!function ($, ss) {
    'use strict';

    /**
     * ResetEmail window
     *
     * @type {Object}
     */
    ss.window.users.ResetEmail = function () {
        ss.window.Abstract.call(
            this,
            {
                group: "user",
                controller: "resetEmailForm",
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "reset-email",
                level: 2,
                parent: "login"
            }
        );

        this._form = null;
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.users.ResetEmail.prototype
        = Object.create(ss.window.Abstract.prototype);

    /**
     * Constructor
     */
    ss.window.users.ResetEmail.prototype.constructor = ss.window.users.ResetEmail;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.users.ResetEmail.prototype._onLoadDataSuccess = function (data) {
        this._form = new ss.forms.Text(
            $.extend(
                {},
                data.forms.email,
                {
                    appendTo: this.getBody()
                }
            )
        );

        this
            .setTitle(data.title)
            .setSubmit(
                {
                    label: data.forms.button.label,
                    icon: "far fa-envelope",
                    forms: [
                        this._form
                    ],
                    ajax: {
                        data: {
                            group: "user",
                            controller: "resetEmail"
                        },
                        type: "POST",
                        success: $.proxy(this._onSendSuccess, this)
                    }
                }
            );

        this._form.focus();
    };

    /**
     * On send success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.users.ResetEmail.prototype._onSendSuccess = function (data) {
        if ($.type(data.errors) === "object") {
            if (data.errors.email !== undefined) {
                this._form
                    .setError(data.errors.email)
                    .scrollTo()
                    .focus();
            }

            return false;
        }

        new ss.window.users.ResetCode(
            {
                id: data.id
            }
        );
    };
}(window.jQuery, window.ss);
