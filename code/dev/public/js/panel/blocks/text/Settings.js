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
        this._labels = {};
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
            ._setLabels(data.labels)
            ._setButtons()
            ._setForms(data.forms)
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
     * Sets labels
     *
     * @returns {ss.panel.blocks.text.Settings}
     *
     * @private
     */
    ss.panel.blocks.text.Settings.prototype._setLabels = function (labels) {
        this._labels = labels;
        return this;
    };

    /**
     * Sets forms
     *
     * @param {Object} forms
     *
     * @returns {ss.panel.blocks.text.Settings}
     *
     * @private
     */
    ss.panel.blocks.text.Settings.prototype._setForms = function (forms) {
        var container = ss.components.Template.get("text-settings-container");
        container.appendTo(this.getBody());

        this._forms.name = new ss.forms.Text(
            $.extend(
                {},
                forms.name,
                {
                    appendTo: container
                }
            )
        );

        this._forms.type = new ss.forms.Select(
            $.extend(
                {},
                forms.type,
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
                }
            )
        );

        this._forms.hasEditor = new ss.forms.Checkbox(
            $.extend(
                {},
                forms.hasEditor,
                {
                    appendTo: container,
                    css: "editor"
                }
            )
        );

        if (forms.type.value !== 0) {
            container.addClass("no-editor");
        }

        return this;
    };

    /**
     * Sets buttons
     *
     * @returns {ss.panel.blocks.text.Settings}
     *
     * @private
     */
    ss.panel.blocks.text.Settings.prototype._setButtons = function () {
        if (this._blockId === 0) {
            return this;
        }

        return this
            .addHeaderButton(
                {
                    label: this._labels.duplicate,
                    icon: "fas fa-clone",
                    css: "btn btn-gray btn-small",
                    ajax: {
                        data: {
                            group: "text",
                            controller: "blockDuplication",
                            data: {
                                id: this._blockId
                            }
                        },
                        type: "POST",
                        success: function(data) {
                            new ss.panel.blocks.text.Settings(data.id);
                        }
                    }
                }
            )
            .addHeaderButton(
                {
                    label: this._labels.delete,
                    icon: "fas fa-trash",
                    css: "btn btn-red btn-small",
                    confirm: {
                        text: this._labels.deleteConfirmText,
                        yes: {
                            label: this._labels.delete,
                            icon: "fas fa-trash"
                        },
                        no: this._labels.no
                    },
                    ajax: {
                        data: {
                            group: "text",
                            controller: "block",
                            data: {
                                id: this._blockId
                            }
                        },
                        type: "DELETE",
                        success: $.proxy(function() {
                            new ss.panel.blocks.text.List();
                            new ss.content.block.Delete([this._blockId]);
                        }, this)
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
            if (this._blockId === 0) {
                ss.system.App.setIsBlockSection(false);
            } else {
                new ss.content.block.Update([this._blockId]);
            }

            new ss.panel.blocks.text.List();
        }
    };
}(window.jQuery, window.ss);
