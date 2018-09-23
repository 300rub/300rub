!function ($, ss) {
    'use strict';

    /**
     * Block text settings panel
     *
     * @param {int} blockId
     *
     * @type {Object}
     */
    ss.panel.blocks.image.Settings = function (blockId) {
        if (blockId === undefined) {
            blockId = 0;
        }

        ss.panel.Abstract.call(
            this,
            {
                group: "image",
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
    ss.panel.blocks.image.Settings.prototype
        = Object.create(ss.panel.Abstract.prototype);

    /**
     * Constructor
     */
    ss.panel.blocks.image.Settings.prototype.constructor
        = ss.panel.blocks.image.Settings;

    /**
     * Auto crop data
     *
     * @type {Array}
     */
    ss.panel.blocks.image.Settings.prototype.autoCropData = [
        {value: 1, icon: "fas fa-arrow-right", css: "deg-45"},
        {value: 2, icon: "fas fa-arrow-down"},
        {value: 3, icon: "fas fa-arrow-down", css: "deg-45"},
        {value: 4, icon: "fas fa-arrow-right"},
        {value: 5, icon: "fas fa-arrows-alt"},
        {value: 6, icon: "fas fa-arrow-left"},
        {value: 7, icon: "fas fa-arrow-up", css: "deg-45"},
        {value: 8, icon: "fas fa-arrow-up"},
        {value: 9, icon: "fas fa-arrow-left", css: "deg-45"}
    ];

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.panel.blocks.image.Settings.prototype._onLoadDataSuccess = function (
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
                    new ss.panel.blocks.image.List();
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
                            group: "image",
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
     * @returns {ss.panel.blocks.image.Settings}
     *
     * @private
     */
    ss.panel.blocks.image.Settings.prototype._setLabels = function (labels) {
        this._labels = labels;
        return this;
    };

    /**
     * Sets forms
     *
     * @param {Object} forms
     *
     * @returns {ss.panel.blocks.image.Settings}
     *
     * @private
     */
    ss.panel.blocks.image.Settings.prototype._setForms = function (forms) {
        var container = ss.components.Template.get("image-settings-container");
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

        if (forms.type.value === 0) {
            container.addClass("zoom");
        }

        this._forms.type = new ss.forms.Select(
            $.extend(
                {},
                forms.type,
                {
                    appendTo: container,
                    onChange: function (value) {
                        if (value === 0) {
                            container.addClass("zoom");
                        } else {
                            container.removeClass("zoom");
                        }
                    }
                }
            )
        );

        this._forms.useAlbums = new ss.forms.CheckboxOnOff(
            $.extend(
                {},
                forms.useAlbums,
                {
                    appendTo: container
                }
            )
        );

        var useCrop = false;
        if (forms.cropX.value > 0
            && forms.cropY.value > 0
        ) {
            useCrop = true;
            container.addClass("use-crop");
        }

        new ss.forms.CheckboxOnOff(
            {
                value: useCrop,
                label: this._labels.configureCrop,
                appendTo: container,
                onCheck: function() {
                    container.addClass("use-crop");
                },
                onUnCheck: function() {
                    container.removeClass("use-crop");
                }
            }
        );

        var cropContainer = ss.components.Template.get("image-settings-crop-container");

        cropContainer.find(".label-text").text(this._labels.cropProportions);

        new ss.forms.Spinner(
            $.extend(
                {},
                forms.cropX,
                {
                    appendTo: cropContainer.find(".crop-x"),
                    min: 0
                }
            )
        );

        new ss.forms.Spinner(
            $.extend(
                {},
                forms.cropY,
                {
                    appendTo: cropContainer.find(".crop-y"),
                    min: 0
                }
            )
        );

        container.append(cropContainer);

        var hasAutoCrop = false;
        if (forms.autoCropType.value > 0) {
            hasAutoCrop = true;
            container.addClass("auto-crop");
        }

        new ss.forms.CheckboxOnOff(
            {
                value: hasAutoCrop,
                label: this._labels.hasAutoCrop,
                css: "auto-crop-container",
                appendTo: container,
                onCheck: function() {
                    container.addClass("auto-crop");
                },
                onUnCheck: function() {
                    container.removeClass("auto-crop");
                }
            }
        );

        new ss.forms.RadioButtons(
            $.extend(
                {},
                forms.autoCropType,
                {
                    css: "auto-crop-type icon-buttons big",
                    grid: 3,
                    data: this.autoCropData,
                    appendTo: container
                }
            )
        );

        var thumbCropContainer = ss.components.Template.get("image-settings-crop-container");

        thumbCropContainer.removeClass("image-settings-crop-container");
        thumbCropContainer.addClass("image-settings-thumb-crop-container");
        thumbCropContainer.find(".label-text").text(this._labels.thumbCropProportions);

        new ss.forms.Spinner(
            $.extend(
                {},
                forms.thumbCropX,
                {
                    appendTo: thumbCropContainer.find(".crop-x"),
                    min: 0
                }
            )
        );

        new ss.forms.Spinner(
            $.extend(
                {},
                forms.thumbCropY,
                {
                    appendTo: thumbCropContainer.find(".crop-y"),
                    min: 0
                }
            )
        );

        container.append(thumbCropContainer);

        var hasThumbAutoCrop = false;
        if (forms.autoCropType.value > 0) {
            hasThumbAutoCrop = true;
            container.addClass("thumb-auto-crop");
        }

        new ss.forms.CheckboxOnOff(
            {
                value: hasThumbAutoCrop,
                label: this._labels.hasThumbAutoCrop,
                css: "thumb-auto-crop-container",
                appendTo: container,
                onCheck: function() {
                    container.addClass("thumb-auto-crop");
                },
                onUnCheck: function() {
                    container.removeClass("thumb-auto-crop");
                }
            }
        );

        new ss.forms.RadioButtons(
            $.extend(
                {},
                forms.thumbAutoCropType,
                {
                    css: "thumb-auto-crop-type icon-buttons big",
                    grid: 3,
                    data: this.autoCropData,
                    appendTo: container
                }
            )
        );

        return this;
    };

    /**
     * Sets buttons
     *
     * @returns {ss.panel.blocks.image.Settings}
     *
     * @private
     */
    ss.panel.blocks.image.Settings.prototype._setButtons = function () {
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
                            group: "image",
                            controller: "blockDuplication",
                            data: {
                                id: this._blockId
                            }
                        },
                        type: "POST",
                        success: function(data) {
                            new ss.panel.blocks.image.Settings(data.id);
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
                            group: "image",
                            controller: "block",
                            data: {
                                id: this._blockId
                            }
                        },
                        type: "DELETE",
                        success: $.proxy(function() {
                            new ss.panel.blocks.image.List();
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
    ss.panel.blocks.image.Settings.prototype._onSendDataSuccess = function (
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

            new ss.panel.blocks.image.List();
        }
    };
}(window.jQuery, window.ss);
