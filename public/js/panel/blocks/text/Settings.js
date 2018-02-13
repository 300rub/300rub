!function ($, Ss) {
    'use strict';

    /**
     * Block text settings panel
     *
     * @type {Object}
     */
    Ss.Panel.Blocks.Text.Settings = function (id) {
        Ss.Panel.Abstract.call(
            this,
            {
                group: "text",
                controller: "settings",
                id: id,
                success: $.proxy(this._onLoadDataSuccess, this)
            }
        );

        this._name = null;
        this._type = null;
        this._hasEditor = null;
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    Ss.Panel.Blocks.Text.Settings.prototype
        = Object.create(Ss.Panel.Abstract.prototype);

    /**
     * Constructor
     */
    Ss.Panel.Blocks.Text.Settings.prototype.constructor
        = Ss.Panel.Blocks.Text.Settings;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    Ss.Panel.Blocks.Text.Settings.prototype._onLoadDataSuccess = function (
        data
    ) {
        this._name = new Ss.Form.Text(
            $.extend(
                {
                    appendTo: this._panel.getBody()
                },
                data.forms.name
            )
        );

        this._type = new Ss.Form.Select(
            $.extend(
                {
                    appendTo: this._panel.getBody()
                },
                data.forms.type
            )
        );

        this._hasEditor = new Ss.Form.CheckboxOnOff(
            $.extend(
                {
                    appendTo: this._panel.getBody()
                },
                data.forms.hasEditor
            )
        );

        var type = "PUT";
        var icon = "fa-check";
        if (data.id === 0) {
            type = "POST";
            icon = "fa-plus";
        }

        this
            .setTitle(data.title)
            .setDescription(data.description)
            .setBack(
                function () {
                    new Ss.Panel.Blocks.Text.List();
                }
            )
            .setSubmit(
                {
                    label: data.button.label,
                    icon: icon,
                    forms: [this._name, this._type, this._hasEditor],
                    ajax: {
                        data: {
                            group: "text",
                            controller: "block"
                        },
                        type: type,
                        success: $.proxy(this._onSendDataSuccess, this),
                        error: Ss.System.App.showError
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
    Ss.Panel.Blocks.Text.Settings.prototype._onSendDataSuccess = function (
        data
    ) {
        if ($.type(data.errors) === "object"
            && data.errors.name !== undefined
        ) {
            this._name
                .setError(data.errors.name)
                .scrollTo()
                .focus();
        } else {
            new Ss.Panel.Blocks.Text.List();
        }
    };
}(window.jQuery, window.Ss);
