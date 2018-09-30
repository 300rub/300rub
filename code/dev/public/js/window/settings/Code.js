!function ($, ss) {
    'use strict';

    /**
     * Code window
     *
     * @param {String} type
     *
     * @type {Object}
     */
    ss.window.settings.Code = function (type) {
        ss.window.Abstract.call(
            this,
            {
                group: "settings",
                controller: "code",
                data: {
                    type: type
                },
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "create-site"
            }
        );

        this._valueForm = null;
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.settings.Code.prototype
        = Object.create(ss.window.Abstract.prototype);

    /**
     * Constructor
     */
    ss.window.settings.Code.prototype.constructor = ss.window.settings.Code;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.settings.Code.prototype._onLoadDataSuccess = function (data) {
        this._valueForm = new ss.forms.Textarea(
            $.extend(
                {},
                data.forms.value,
                {
                    appendTo: this.getBody(),
                    rows: 15
                }
            )
        );

        this
            .setTitle(data.title)
            .setSubmit(
                {
                    label: data.forms.button.label,
                    icon: "fas fa-save",
                    forms: [
                        this._valueForm
                    ],
                    ajax: {
                        data: {
                            group: "settings",
                            controller: "code",
                            data: {
                                type: data.type
                            }
                        },
                        type: "PUT",
                        success: $.proxy(this._onSendSuccess, this)
                    }
                }
            );
    };

    /**
     * On send success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.settings.Code.prototype._onSendSuccess = function (data) {
        window.location.reload();
    };
}(window.jQuery, window.ss);
