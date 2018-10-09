!function ($, ss) {
    'use strict';

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.blocks.image.Crop.prototype._onLoadDataSuccess = function (data) {


        this
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

    ss.window.blocks.image.Crop.prototype._setViewGroup = function () {

    };

    /**
     * On send success
     *
     * @private
     */
    ss.window.blocks.image.Crop.prototype._onSendSuccess = function () {
        
    };
}(window.jQuery, window.ss);
