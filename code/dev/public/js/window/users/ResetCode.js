!function ($, ss) {
    'use strict';

    /**
     * ResetCode window
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    ss.window.users.ResetCode = function (options) {
        ss.window.Abstract.call(
            this,
            {
                group: "user",
                controller: "resetCodeForm",
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "reset-code",
                level: 2,
                parent: "login"
            }
        );

        this._form = null;
        this._id = options.id;
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.users.ResetCode.prototype
        = Object.create(ss.window.Abstract.prototype);

    /**
     * Constructor
     */
    ss.window.users.ResetCode.prototype.constructor = ss.window.users.ResetCode;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.users.ResetCode.prototype._onLoadDataSuccess = function (data) {
        this._form = new ss.forms.Text(
            $.extend(
                {
                    appendTo: this.getBody()
                },
                data.forms.code
            )
        );

        var idForm = new ss.forms.Hidden(
            {
                name: 'id',
                value: this._id,
                appendTo: this.getBody()
            }
        );

        this
            .setTitle(data.title)
            .setSubmit(
                {
                    label: data.forms.button.label,
                    icon: "fas fa-lock",
                    forms: [
                        this._form,
                        idForm
                    ],
                    ajax: {
                        data: {
                            group: "user",
                            controller: "resetCode"
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
    ss.window.users.ResetCode.prototype._onSendSuccess = function (data) {
        if ($.type(data.errors) === "object") {
            if (data.errors.code !== undefined) {
                this._form
                    .setError(data.errors.code)
                    .scrollTo()
                    .focus();
            }

            return false;
        }

        window.location.reload();
    };
}(window.jQuery, window.ss);
