!function ($, ss) {
    'use strict';

    
    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.panel.blocks.image.Settings.prototype.onLoadDataSuccess = function (
        data
    ) {


        this
            .setButtons()
            .setName()
            .setType()
            .setUseAlbums()
            .setConfigureCrop()
            .setCropProportions()
            .setAutoCrop()
            .setThumbCropProportions()
            .setThumbAutoCrop()
            .setSubmit(
                {
                    label: data.forms.button.label,
                    icon: icon,
                    forms: this.forms,
                    ajax: {
                        data: {
                            group: "image",
                            controller: "block",
                            data: {
                                id: this.getOption("blockId", 0)
                            }
                        },
                        type: type,
                        success: $.proxy(this.onSendSuccess, this)
                    }
                }
            );
    };

    /**
     * Sets name
     *
     * @returns {ss.panel.blocks.image.Settings}
     *
     * @private
     */
    ss.panel.blocks.image.Settings.prototype.setName = function () {
        this.forms.name = new ss.forms.Text(
            $.extend(
                {},
                this.getData(["forms", "name"], {}),
                {
                    appendTo: this.container
                }
            )
        );

        return this;
    };

    /**
     * Sets type
     *
     * @returns {ss.panel.blocks.image.Settings}
     *
     * @private
     */
    ss.panel.blocks.image.Settings.prototype.setType = function () {
        if (this.getData(["forms", "type", "value"], 0) === 0) {
            this.container.addClass("zoom");
        }

        this.forms.type = new ss.forms.Select(
            $.extend(
                {},
                this.getData(["forms", "type"], {}),
                {
                    appendTo: this.container,
                    type: "int",
                    onChange: $.proxy(function (value) {
                        if (value === 0) {
                            this.container.addClass("zoom");
                        } else {
                            this.container.removeClass("zoom");
                        }
                    }, this)
                }
            )
        );

        return this;
    };

    /**
     * Sets use albums form
     *
     * @returns {ss.panel.blocks.image.Settings}
     *
     * @private
     */
    ss.panel.blocks.image.Settings.prototype.setUseAlbums = function () {
        this.forms.useAlbums = new ss.forms.CheckboxOnOff(
            $.extend(
                {},
                this.getData(["forms", "useAlbums"], {}),
                {
                    appendTo: this.container
                }
            )
        );

        return this;
    };

    /**
     * Sets configure crop
     *
     * @returns {ss.panel.blocks.image.Settings}
     *
     * @private
     */
    ss.panel.blocks.image.Settings.prototype.setConfigureCrop = function () {
        var useCrop = false;
        if ((this.getData(["forms", "cropX", "value"], 0) > 0
            && this.getData(["forms", "cropY", "value"], 0) > 0)
            || (this.getData(["forms", "thumbCropX", "value"], 0) > 0
            && this.getData(["forms", "thumbCropY", "value"], 0) > 0)
        ) {
            useCrop = true;
            this.container.addClass("use-crop");
        }

        new ss.forms.CheckboxOnOff(
            {
                value: useCrop,
                label: this.getLabel("configureCrop"),
                appendTo: this.container,
                onCheck: $.proxy(function() {
                    this.container.addClass("use-crop");
                }, this),
                onUnCheck: $.proxy(function() {
                    this.container.removeClass("use-crop");

                    this.forms.cropX.setValue(0);
                    this.forms.cropY.setValue(0);
                    this.forms.thumbCropX.setValue(0);
                    this.forms.thumbCropY.setValue(0);
                }, this)
            }
        );

        return this;
    };

    /**
     * Sets crop proportions
     *
     * @returns {ss.panel.blocks.image.Settings}
     *
     * @private
     */
    ss.panel.blocks.image.Settings.prototype.setCropProportions = function () {
        var cropContainer = ss.components.Template.get("image-settings-crop-container");
        cropContainer.find(".label-text").text(this.getLabel("cropProportions"));

        this.forms.cropX = new ss.forms.Spinner(
            $.extend(
                {},
                this.getData(["forms", "cropX"], {}),
                {
                    appendTo: cropContainer.find(".crop-x"),
                    min: 0
                }
            )
        );

        this.forms.cropY = new ss.forms.Spinner(
            $.extend(
                {},
                this.getData(["forms", "cropY"], {}),
                {
                    appendTo: cropContainer.find(".crop-y"),
                    min: 0
                }
            )
        );

        this.container.append(cropContainer);

        return this;
    };

    /**
     * Sets auto crop
     *
     * @returns {ss.panel.blocks.image.Settings}
     *
     * @private
     */
    ss.panel.blocks.image.Settings.prototype.setAutoCrop = function () {
        var hasAutoCrop = false;
        if (this.getData(["forms", "autoCropType", "value"], 0) > 0) {
            hasAutoCrop = true;
            this.container.addClass("auto-crop");
        }

        new ss.forms.CheckboxOnOff(
            {
                value: hasAutoCrop,
                label: this.getLabel("hasAutoCrop"),
                css: "auto-crop-container",
                appendTo: this.container,
                onCheck: $.proxy(function() {
                    this.container.addClass("auto-crop");
                    this.forms.autoCropType.setValue(5);
                }, this),
                onUnCheck: $.proxy(function() {
                    this.container.removeClass("auto-crop");
                    this.forms.autoCropType.setValue(0);
                }, this)
            }
        );

        this.forms.autoCropType = new ss.forms.RadioButtons(
            $.extend(
                {},
                this.getData(["forms", "autoCropType"], {}),
                {
                    css: "auto-crop-type icon-buttons big",
                    grid: 3,
                    type: "int",
                    data: this.autoCropData,
                    appendTo: this.container
                }
            )
        );

        return this;
    };

    /**
     * Sets thumb crop proportions
     *
     * @returns {ss.panel.blocks.image.Settings}
     *
     * @private
     */
    ss.panel.blocks.image.Settings.prototype.setThumbCropProportions = function () {
        var thumbCropContainer = ss.components.Template.get("image-settings-crop-container");

        thumbCropContainer.removeClass("image-settings-crop-container");
        thumbCropContainer.addClass("image-settings-thumb-crop-container");
        thumbCropContainer.find(".label-text").text(this.getLabel("thumbCropProportions"));

        this.forms.thumbCropX = new ss.forms.Spinner(
            $.extend(
                {},
                this.getData(["forms", "thumbCropX"], {}),
                {
                    appendTo: thumbCropContainer.find(".crop-x"),
                    min: 0
                }
            )
        );

        this.forms.thumbCropY =new ss.forms.Spinner(
            $.extend(
                {},
                this.getData(["forms", "thumbCropY"], {}),
                {
                    appendTo: thumbCropContainer.find(".crop-y"),
                    min: 0
                }
            )
        );

        this.container.append(thumbCropContainer);

        return this;
    };

    /**
     * Sets thumb auto crop
     *
     * @param {Object} forms
     *
     * @returns {ss.panel.blocks.image.Settings}
     *
     * @private
     */
    ss.panel.blocks.image.Settings.prototype.setThumbAutoCrop = function (forms) {
        var hasThumbAutoCrop = false;
        if (this.getData(["forms", "thumbAutoCropType", "value"], 0) > 0) {
            hasThumbAutoCrop = true;
            this.container.addClass("thumb-auto-crop");
        }

        new ss.forms.CheckboxOnOff(
            {
                value: hasThumbAutoCrop,
                label: this.getLabel("hasThumbAutoCrop"),
                css: "thumb-auto-crop-container",
                appendTo: this.container,
                onCheck: $.proxy(function() {
                    this.container.addClass("thumb-auto-crop");
                    this.forms.thumbAutoCropType.setValue(5);
                }, this),
                onUnCheck: $.proxy(function() {
                    this.container.removeClass("thumb-auto-crop");
                    this.forms.thumbAutoCropType.setValue(0);
                }, this)
            }
        );

        this.forms.thumbAutoCropType = new ss.forms.RadioButtons(
            $.extend(
                {},
                this.getData(["forms", "thumbAutoCropType"], {}),
                {
                    css: "thumb-auto-crop-type icon-buttons big",
                    grid: 3,
                    data: this.autoCropData,
                    appendTo: this.container
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
    ss.panel.blocks.image.Settings.prototype.setButtons = function () {
        if (this.getOption("blockId", 0) === 0) {
            return this;
        }

        return this
            .addHeaderButton(
                {
                    label: this.getLabel("duplicate"),
                    icon: "fas fa-clone",
                    css: "btn btn-gray btn-small",
                    ajax: {
                        data: {
                            group: "image",
                            controller: "blockDuplication",
                            data: {
                                id: this.getOption("blockId", 0)
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
                    label: this.getLabel("delete"),
                    icon: "fas fa-trash",
                    css: "btn btn-red btn-small",
                    confirm: {
                        text: this.getLabel("deleteConfirmText"),
                        yes: {
                            label: this.getLabel("delete"),
                            icon: "fas fa-trash"
                        },
                        no: this.getLabel("no")
                    },
                    ajax: {
                        data: {
                            group: "image",
                            controller: "block",
                            data: {
                                id: this.getOption("blockId", 0)
                            }
                        },
                        type: "DELETE",
                        success: $.proxy(function() {
                            new ss.panel.blocks.image.List();
                            new ss.content.block.Delete([this.getOption("blockId", 0)]);
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
    ss.panel.blocks.image.Settings.prototype.onSendSuccess = function (
        data
    ) {
        if ($.type(data.errors) === "object"
            && data.errors.name !== undefined
        ) {
            this.forms.name
                .setError(data.errors.name)
                .scrollTo()
                .focus();
        } else {
            if (this.getOption("blockId", 0) === 0) {
                ss.init("app").setIsBlockSection(false);
            } else {
                new ss.content.block.Update([this.getOption("blockId", 0)]);
            }

            new ss.panel.blocks.image.List();
        }
    };
}(window.jQuery, window.ss);
