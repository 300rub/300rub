!function ($, ss) {
    'use strict';

    /**
     * Block text settings panel
     *
     * @type {Object}
     */
    ss.panel.blocks.text.Settings = function (id) {
        ss.panel.Abstract.call(
            this,
            {
                group: "text",
                controller: "block",
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
    ss.panel.blocks.text.Settings.prototype
        = Object.create(ss.panel.Abstract.prototype);

    /**
     * Constructor
     */
    ss.panel.blocks.text.Settings.prototype.constructor
        = ss.panel.blocks.text.Settings;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.panel.blocks.text.Settings.prototype._onLoadDataSuccess = function (
        data
    ) {
        this._name = new ss.forms.Text(
            $.extend(
                {
                    appendTo: this.getBody()
                },
                data.forms.name
            )
        );

        this._type = new ss.forms.Select(
            $.extend(
                {
                    appendTo: this.getBody()
                },
                data.forms.type
            )
        );

        this._hasEditor = new ss.forms.CheckboxOnOff(
            $.extend(
                {
                    appendTo: this.getBody()
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
                    new ss.panel.blocks.text.List();
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
                        success: $.proxy(this._onSendDataSuccess, this)
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
    ss.panel.blocks.text.Settings.prototype._onSendDataSuccess = function (
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
            new ss.panel.blocks.text.List();
        }
    };
}(window.jQuery, window.ss);
