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
