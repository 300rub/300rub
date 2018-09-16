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
                controller: "image",
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

        var actions = container.find(".actions");

        new ss.forms.Button(
            {
                css: "btn btn-blue btn-icon",
                icon: "fas fa-undo",
                label: '',
                appendTo: actions,
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
                appendTo: actions,
                onClick: $.proxy(function() {
                    viewImage.cropper("rotate", 45);
                }, this)
            }
        );

        this.getBody().append(container);
    };

    /**
     * On send success
     *
     * @private
     */
    ss.window.blocks.image.Crop.prototype._onSendSuccess = function () {
        
    };
}(window.jQuery, window.ss);
