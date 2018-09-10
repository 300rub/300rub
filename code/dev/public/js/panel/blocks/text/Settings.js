!function ($, ss) {
    'use strict';

    /**
     * Block text settings panel
     *
     * @param {int} blockId
     *
     * @type {Object}
     */
    ss.panel.blocks.text.Settings = function (blockId) {
        if (blockId === undefined) {
            blockId = 0;
        }

        ss.panel.Abstract.call(
            this,
            {
                group: "text",
                controller: "block",
                data: {
                    id: blockId
                },
                success: $.proxy(this._onLoadDataSuccess, this)
            }
        );

        this._blockId = blockId;
        this._forms = {};
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
        var container = ss.components.Template.get("text-settings-container");
        container.appendTo(this.getBody());

        this._forms.name = new ss.forms.Text(
            $.extend(
                {
                    appendTo: container
                },
                data.forms.name
            )
        );

        this._forms.type = new ss.forms.Select(
            $.extend(
                {
                    appendTo: container,
                    type: "int",
                    onChange: function(value) {
                        if (value === 0) {
                            container.removeClass("no-editor");
                        } else {
                            container.addClass("no-editor");
                        }
                    }
                },
                data.forms.type
            )
        );

        this._forms.hasEditor = new ss.forms.CheckboxOnOff(
            $.extend(
                {
                    appendTo: container,
                    css: "editor"
                },
                data.forms.hasEditor
            )
        );

        if (data.forms.type.value !== 0) {
            container.addClass("no-editor");
        }

        var type = "PUT";
        var icon = "fas fa-save";
        if (data.id === 0) {
            type = "POST";
            icon = "fas fa-plus";
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
                    label: data.forms.button.label,
                    icon: icon,
                    forms: this._forms,
                    ajax: {
                        data: {
                            group: "text",
                            controller: "block",
                            data: {
                                id: this._blockId
                            }
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
            this._forms.name
                .setError(data.errors.name)
                .scrollTo()
                .focus();
        } else {
            new ss.panel.blocks.text.List();
        }
    };
}(window.jQuery, window.ss);
