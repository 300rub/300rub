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
                {
                    appendTo: this.getBody()
                },
                data.forms.email
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
        console.log(data);
    };
}(window.jQuery, window.ss);
