!function ($, ss) {
    'use strict';

    /**
     * Image cropper
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    ss.window.blocks.image.Crop = function (options) {
        ss.window.Abstract.call(
            this,
            {
                group: "image",
                controller: "crop",
                data: {
                    blockId: options.blockId,
                    id: options.id
                },
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "image-crop",
                level: options.level,
                parent: options.parent
            }
        );
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.blocks.image.Crop.prototype
        = Object.create(ss.window.Abstract.prototype);

    /**
     * Constructor
     */
    ss.window.blocks.image.Crop.prototype.constructor = ss.window.blocks.image.Crop;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.blocks.image.Crop.prototype._onLoadDataSuccess = function (data) {
        var container = ss.components.Template.get("image-crop-container");

        var viewImage = container.find(".view-image");
        viewImage.attr("src", data.url);

        var viewPreview = container.find(".preview");

        viewImage.cropper({
            viewMode: 2,
            preview: viewPreview,
            aspectRatio: 1,
            autoCropArea: 1,
            movable: false,
            crop: function(event) {
                //console.log(event.detail.x);
                //console.log(event.detail.y);
                //console.log(event.detail.width);
                //console.log(event.detail.height);
                //console.log(event.detail.rotate);
                //console.log(event.detail.scaleX);
                //console.log(event.detail.scaleY);
            }
        });

        var rotateContainer = container.find(".rotate-container");

        new ss.forms.Button(
            {
                css: "btn btn-blue btn-icon",
                icon: "fas fa-undo",
                label: '',
                appendTo: rotateContainer,
                onClick: $.proxy(function() {
                    viewImage.cropper("rotate", -45);
                }, this)
            }
        );

        new ss.forms.Button(
            {
                css: "btn btn-blue btn-icon",
                icon: "fas fa-redo",
                label: '',
                appendTo: rotateContainer,
                onClick: $.proxy(function() {
                    viewImage.cropper("rotate", 45);
                }, this)
            }
        );

        var flipContainer = container.find(".flip-container");

        new ss.forms.Button(
            {
                css: "btn btn-blue btn-icon",
                icon: "fas fa-arrows-alt-h",
                label: '',
                appendTo: flipContainer,
                onClick: $.proxy(function() {
                    if (flipContainer.hasClass("flipped-x") === true) {
                        viewImage.cropper("scaleX", 1);
                        flipContainer.removeClass("flipped-x");
                    } else {
                        viewImage.cropper("scaleX", -1);
                        flipContainer.addClass("flipped-x");
                    }
                }, this)
            }
        );

        new ss.forms.Button(
            {
                css: "btn btn-blue btn-icon",
                icon: "fas fa-arrows-alt-v",
                label: '',
                appendTo: flipContainer,
                onClick: $.proxy(function() {
                    if (flipContainer.hasClass("flipped-y") === true) {
                        viewImage.cropper("scaleY", 1);
                        flipContainer.removeClass("flipped-y");
                    } else {
                        viewImage.cropper("scaleY",-1);
                        flipContainer.addClass("flipped-y");
                    }
                }, this)
            }
        );

        var zoomContainer = container.find(".zoom-container");

        new ss.forms.Button(
            {
                css: "btn btn-blue btn-icon",
                icon: "fas fa-search-plus",
                label: '',
                appendTo: zoomContainer,
                onClick: $.proxy(function() {
                    viewImage.cropper("zoom", 0.1);
                }, this)
            }
        );

        new ss.forms.Button(
            {
                css: "btn btn-blue btn-icon",
                icon: "fas fa-search-minus",
                label: '',
                appendTo: zoomContainer,
                onClick: $.proxy(function() {
                    viewImage.cropper("zoom", -0.1);
                }, this)
            }
        );

        var userAspectRatio = container.find(".user-aspect-container");
        var defaultAspectRatio = container.find(".default-aspect-container");

        new ss.forms.Button(
            {
                css: "btn btn-blue",
                label: "1024:200",
                appendTo: userAspectRatio,
                onClick: $.proxy(function() {
                    viewImage.cropper("setAspectRatio", 1024 / 200);
                }, this)
            }
        );

        new ss.forms.Button(
            {
                css: "btn btn-blue",
                label: "Free",
                appendTo: userAspectRatio,
                onClick: $.proxy(function() {
                    viewImage.cropper("setAspectRatio", NaN);
                }, this)
            }
        );

        new ss.forms.Button(
            {
                css: "btn btn-blue",
                label: "16:9",
                appendTo: defaultAspectRatio,
                onClick: $.proxy(function() {
                    viewImage.cropper("setAspectRatio", 16 / 9);
                }, this)
            }
        );

        new ss.forms.Button(
            {
                css: "btn btn-blue",
                label: "4:3",
                appendTo: defaultAspectRatio,
                onClick: $.proxy(function() {
                    viewImage.cropper("setAspectRatio", 4 / 3);
                }, this)
            }
        );

        new ss.forms.Button(
            {
                css: "btn btn-blue",
                label: "1:1",
                appendTo: defaultAspectRatio,
                onClick: $.proxy(function() {
                    viewImage.cropper("setAspectRatio", 1);
                }, this)
            }
        );

        new ss.forms.Button(
            {
                css: "btn btn-blue",
                label: "2:3",
                appendTo: defaultAspectRatio,
                onClick: $.proxy(function() {
                    viewImage.cropper("setAspectRatio", 2 / 3);
                }, this)
            }
        );

        var resetContainer = container.find(".reset-container");

        new ss.forms.Button(
            {
                css: "btn btn-blue btn-icon",
                icon: "fas fa-retweet",
                label: "",
                appendTo: resetContainer,
                onClick: $.proxy(function() {
                    viewImage.cropper("reset");
                }, this)
            }
        );

        this.getBody().append(container);

        this
            .setTitle(data.title)
            .setSubmit(
                {
                    label: data.button.label,
                    icon: "fas fa-crop-alt",
                    ajax: {
                        data: {
                            group: "image",
                            controller: "content",
                            data: function() {
                                return {
                                    blockId: data.blockId,
                                    id: data.id,
                                    isCover: false,
                                    x1: 0,
                                    y1: 0,
                                    x2: 0,
                                    y2: 0,
                                    thumbX1: 0,
                                    thumbY1: 0,
                                    thumbX2: 0,
                                    thumbY2: 0,
                                    angle: 0,
                                    flip: 0
                                };
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
     * @private
     */
    ss.window.blocks.image.Crop.prototype._onSendSuccess = function () {
        
    };
}(window.jQuery, window.ss);
