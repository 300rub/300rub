!function ($, TestS) {
    'use strict';

    /**
     * Block text settings panel
     *
     * @type {Object}
     */
    TestS.Panel.Blocks.Text.Settings = function (id) {
        TestS.Panel.Abstract.call(
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
    TestS.Panel.Blocks.Text.Settings.prototype
        = Object.create(TestS.Panel.Abstract.prototype);

    /**
     * Constructor
     */
    TestS.Panel.Blocks.Text.Settings.prototype.constructor
        = TestS.Panel.Blocks.Text.Settings;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    TestS.Panel.Blocks.Text.Settings.prototype._onLoadDataSuccess = function (
        data
    ) {
        this._name = new TestS.Form.Text(
            $.extend(
                {
                    appendTo: this._panel.getBody()
                },
                data.forms.name
            )
        );

        this._type = new TestS.Form.Select(
            $.extend(
                {
                    appendTo: this._panel.getBody()
                },
                data.forms.type
            )
        );

        this._hasEditor = new TestS.Form.CheckboxOnOff(
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
                    new TestS.Panel.Blocks.Text.List();
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
                        error: TestS.System.App.showError
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
    TestS.Panel.Blocks.Text.Settings.prototype._onSendDataSuccess = function (
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
            new TestS.Panel.Blocks.Text.List();
        }
    };
}(window.jQuery, window.TestS);
