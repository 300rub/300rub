!function ($, ss) {
    "use strict";

    var name = "adminBlockImageImagesCrop";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsWindowAbstract",

        /**
         * View container
         *
         * @var {Object}
         */
        viewContainer: null,

        /**
         * View image
         *
         * @var {Object}
         */
        viewImage: null,

        /**
         * Thumb container
         *
         * @var {Object}
         */
        thumbContainer: null,

        /**
         * Thumb image
         *
         * @var {Object}
         */
        thumbImage: null,

        /**
         * View X
         *
         * @var {Integer}
         */
        viewX: 0,

        /**
         * View Y
         *
         * @var {Integer}
         */
        viewY: 0,

        /**
         * View width
         *
         * @var {Integer}
         */
        viewWidth: 0,

        /**
         * View height
         *
         * @var {Integer}
         */
        viewHeight: 0,

        /**
         * View Rotate
         *
         * @var {Integer}
         */
        viewRotate: 0,

        /**
         * View Scale X
         *
         * @var {Integer}
         */
        viewScaleX: 1,

        /**
         * View Scale Y
         *
         * @var {Integer}
         */
        viewScaleY: 1,

        /**
         * Thumb X
         *
         * @var {Integer}
         */
        thumbX: 0,

        /**
         * Thumb Y
         *
         * @var {Integer}
         */
        thumbY: 0,

        /**
         * Thumb width
         *
         * @var {Integer}
         */
        thumbWidth: 0,

        /**
         * Thumb height
         *
         * @var {Integer}
         */
        thumbHeight: 0,

        /**
         * Thumb Rotate
         *
         * @var {Integer}
         */
        thumbRotate: 0,

        /**
         * Thumb Scale X
         *
         * @var {Integer}
         */
        thumbScaleX: 1,

        /**
         * Thumb Scale Y
         *
         * @var {Integer}
         */
        thumbScaleY: 1,

        /**
         * Flip types
         *
         * @var {Object}
         */
        flipTypes: {
            NONE: 0,
            HORIZONTAL: 1,
            VERTICAL: 2,
            BOTH: 3
        },

        /**
         * Init
         */
        init: function () {
            this.viewContainer = null;
            this.viewImage = null;
            this.thumbContainer = null;
            this.thumbImage = null;

            this.viewX = 0;
            this.viewY = 0;
            this.viewWidth = 0;
            this.viewHeight = 0;
            this.viewRotate = 0;
            this.viewScaleX = 1;
            this.viewScaleY = 1;
            this.thumbX = 0;
            this.thumbY = 0;
            this.thumbWidth = 0;
            this.thumbHeight = 0;
            this.thumbRotate = 0;
            this.thumbScaleX = 1;
            this.thumbScaleY = 1;

            this.create(
                {
                    group: this.getOption("group"),
                    controller: this.getOption("controller"),
                    data: {
                        blockId: this.getOption("blockId"),
                        id: this.getOption("id")
                    },
                    name: "image-crop"
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            this
                .setViewContainer()
                .setViewCropper()
                .setViewRotate()
                .setViewFlip()
                .setViewZoom()
                .setViewAspectRatio()
                .setViewReset();

            if (this.getData("hasThumb") === true) {
                this
                    .setThumbContainer()
                    .setThumbCropper()
                    .setThumbRotate()
                    .setThumbFlip()
                ;
            }

            this.setSubmit(
                {
                    label: this.getLabel("button"),
                    icon: "fas fa-crop-alt",
                    ajax: {
                        data: {
                            group: "image",
                            controller: "crop",
                            data: $.proxy(this.generateData, this)
                        },
                        type: "PUT",
                        success: $.proxy(this.onSendSuccess, this)
                    }
                }
            );
        },

        /**
         * Sets view container
         */
        setViewContainer: function () {
            this.viewContainer
                = ss.init("template").get("image-crop-container");
            this.getBody().append(this.viewContainer);

            return this;
        },

        /**
         * Sets thumb container
         */
        setThumbContainer: function () {
            this.thumbContainer
                = ss.init("template").get("image-crop-container");
            this.getBody().append(this.thumbContainer);

            return this;
        },

        /**
         * Sets view cropper
         */
        setViewCropper: function () {
            this.viewImage = this.viewContainer.find(".cropper");
            this.viewImage.attr("src", this.getData("url"));

            var aspectRatio = NaN;
            var width = this.getData("viewWidth");
            var height = this.getData("viewHeight");
            var viewCropX = this.getData("viewCropX");
            var viewCropY = this.getData("viewCropY");
            if (width > 0
                && height > 0
            ) {
                aspectRatio = (width / height);
            } else if (viewCropX > 0
                && viewCropY > 0
            ) {
                aspectRatio = (viewCropX / viewCropY);
            }

            this.viewImage.cropper(
                {
                    viewMode: 2,
                    preview: this.viewContainer.find(".preview"),
                    aspectRatio: aspectRatio,
                    autoCropArea: 1,
                    movable: false,
                    data: this.getViewCropData(),
                    crop: $.proxy(function (event) {
                        this.viewX = event.detail.x;
                        this.viewY = event.detail.y;
                        this.viewWidth = event.detail.width;
                        this.viewHeight = event.detail.height;
                        this.viewRotate = event.detail.rotate;
                        this.viewScaleX = event.detail.scaleX;
                        this.viewScaleY = event.detail.scaleY;
                    }, this)
                }
            );

            return this;
        },

        /**
         * Sets thumb cropper
         */
        setThumbCropper: function () {
            this.thumbImage = this.thumbContainer.find(".cropper");
            this.thumbImage.attr("src", this.getData("url"));

            var aspectRatio = NaN;
            var width = this.getData("thumbWidth");
            var height = this.getData("thumbHeight");
            var thumbCropX = this.getData("thumbCropX");
            var thumbCropY = this.getData("thumbCropY");
            if (width > 0
                && height > 0
            ) {
                aspectRatio = (width / height);
            } else if (thumbCropX > 0
                && thumbCropY > 0
            ) {
                aspectRatio = (thumbwCropX / thumbCropY);
            }

            this.thumbImage.cropper(
                {
                    viewMode: 2,
                    preview: this.thumbContainer.find(".preview"),
                    aspectRatio: aspectRatio,
                    autoCropArea: 1,
                    movable: false,
                    data: this.getThumbCropData(),
                    crop: $.proxy(function (event) {
                        this.thumbX = event.detail.x;
                        this.thumbY = event.detail.y;
                        this.thumbWidth = event.detail.width;
                        this.thumbHeight = event.detail.height;
                        this.thumbRotate = event.detail.rotate;
                        this.thumbScaleX = event.detail.scaleX;
                        this.thumbScaleY = event.detail.scaleY;
                    }, this)
                }
            );

            return this;
        },

        /**
         * Sets view rotate
         */
        setViewRotate: function () {
            var rotateContainer = this.viewContainer.find(".rotate-container");

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-icon",
                    icon: "fas fa-undo",
                    label: '',
                    appendTo: rotateContainer,
                    onClick: $.proxy(
                        function () {
                            this.viewImage.cropper("rotate", -45);
                        },
                        this
                    )
                }
            );

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-icon",
                    icon: "fas fa-redo",
                    label: '',
                    appendTo: rotateContainer,
                    onClick: $.proxy(
                        function () {
                            this.viewImage.cropper("rotate", 45);
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets thumb rotate
         */
        setThumbRotate: function () {
            var rotateContainer = this.thumbContainer.find(".rotate-container");

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-icon",
                    icon: "fas fa-undo",
                    label: '',
                    appendTo: rotateContainer,
                    onClick: $.proxy(
                        function () {
                            this.thumbImage.cropper("rotate", -45);
                        },
                        this
                    )
                }
            );

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-icon",
                    icon: "fas fa-redo",
                    label: '',
                    appendTo: rotateContainer,
                    onClick: $.proxy(
                        function () {
                            this.thumbImage.cropper("rotate", 45);
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Function to generate request data
         *
         * @return {Object}
         */
        generateData: function() {
            var data = {
                blockId: parseInt(this.getData("blockId")),
                id: parseInt(this.getData("id")),
                viewX: parseInt(this.viewX),
                viewY: parseInt(this.viewY),
                viewWidth: parseInt(this.viewWidth),
                viewHeight: parseInt(this.viewHeight),
                viewAngle: parseInt(this.viewRotate),
                viewFlip: this.getFlip(this.viewScaleX, this.viewScaleY)
            };

            if (this.getData("hasThumb") === false) {
                return data;
            }

            return $.extend(
                {},
                data,
                {
                    thumbX: parseInt(this.thumbX),
                    thumbY: parseInt(this.thumbY),
                    thumbWidth: parseInt(this.thumbWidth),
                    thumbHeight: parseInt(this.thumbHeight),
                    thumbAngle: parseInt(this.thumbRotate),
                    thumbFlip: this.getFlip(this.thumbScaleX, this.thumbScaleY)
                }
            );
        },

        /**
         * Gets view crop data
         *
         * @returns {Object}
         */
        getViewCropData: function() {
            return {
                x: this.getData("viewX"),
                y: this.getData("viewY"),
                width: this.getData("viewWidth"),
                height: this.getData("viewHeight"),
                rotate: this.getData("viewAngle"),
                scaleX: this.getScaleX(this.getData("viewFlip")),
                scaleY: this.getScaleY(this.getData("viewFlip"))
            };
        },

        /**
         * Gets thumb crop data
         *
         * @returns {Object}
         */
        getThumbCropData: function() {
            return {
                x: this.getData("thumbX"),
                y: this.getData("thumbY"),
                width: this.getData("thumbWidth"),
                height: this.getData("thumbHeight"),
                rotate: this.getData("thumbAngle"),
                scaleX: this.getScaleX(this.getData("thumbFlip")),
                scaleY: this.getScaleY(this.getData("thumbFlip"))
            };
        },

        /**
         * Gets scale X
         *
         * @param {int} flip
         *
         * @returns {int}
         */
        getScaleX: function(flip) {
            switch (flip) {
                case this.flipTypes.BOTH:
                    return -1;
                case this.flipTypes.HORIZONTAL:
                    return -1;
                default:
                    return 1;
            }
        },

        /**
         * Gets scale Y
         *
         * @param {int} flip
         *
         * @returns {int}
         */
        getScaleY: function(flip) {
            switch (flip) {
                case this.flipTypes.BOTH:
                    return -1;
                case this.flipTypes.VERTICAL:
                    return -1;
                default:
                    return 1;
            }
        },

        /**
         * Gets flip
         *
         * @param {Integer} scaleX
         * @param {Integer} scaleY
         *
         * @returns {Integer}
         */
        getFlip: function(scaleX, scaleY) {
            if (scaleX === -1
                && scaleY === -1
            ) {
                return this.flipTypes.BOTH;
            }

            if (scaleX === -1) {
                return this.flipTypes.HORIZONTAL;
            }

            if (scaleY === -1) {
                return this.flipTypes.VERTICAL;
            }

            return this.flipTypes.NONE;
        },

        /**
         * Sets view flip
         */
        setViewFlip: function () {
            var flipContainer = this.viewContainer.find(".flip-container");

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-icon",
                    icon: "fas fa-arrows-alt-h",
                    label: '',
                    appendTo: flipContainer,
                    onClick: $.proxy(
                        function () {
                            if (flipContainer.hasClass("flipped-x") === true) {
                                this.viewImage.cropper("scaleX", 1);
                                flipContainer.removeClass("flipped-x");
                            } else {
                                this.viewImage.cropper("scaleX", -1);
                                flipContainer.addClass("flipped-x");
                            }
                        },
                        this
                    )
                }
            );

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-icon",
                    icon: "fas fa-arrows-alt-v",
                    label: '',
                    appendTo: flipContainer,
                    onClick: $.proxy(
                        function () {
                            if (flipContainer.hasClass("flipped-y") === true) {
                                this.viewImage.cropper("scaleY", 1);
                                flipContainer.removeClass("flipped-y");
                            } else {
                                this.viewImage.cropper("scaleY",-1);
                                flipContainer.addClass("flipped-y");
                            }
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets thumb flip
         */
        setThumbFlip: function () {
            var flipContainer = this.thumbContainer.find(".flip-container");

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-icon",
                    icon: "fas fa-arrows-alt-h",
                    label: '',
                    appendTo: flipContainer,
                    onClick: $.proxy(
                        function () {
                            if (flipContainer.hasClass("flipped-x") === true) {
                                this.thumbImage.cropper("scaleX", 1);
                                flipContainer.removeClass("flipped-x");
                            } else {
                                this.thumbImage.cropper("scaleX", -1);
                                flipContainer.addClass("flipped-x");
                            }
                        },
                        this
                    )
                }
            );

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-icon",
                    icon: "fas fa-arrows-alt-v",
                    label: '',
                    appendTo: flipContainer,
                    onClick: $.proxy(
                        function () {
                            if (flipContainer.hasClass("flipped-y") === true) {
                                this.thumbImage.cropper("scaleY", 1);
                                flipContainer.removeClass("flipped-y");
                            } else {
                                this.thumbImage.cropper("scaleY",-1);
                                flipContainer.addClass("flipped-y");
                            }
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets view zoom
         */
        setViewZoom: function () {
            var zoomContainer = this.viewContainer.find(".zoom-container");

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-icon",
                    icon: "fas fa-search-plus",
                    label: '',
                    appendTo: zoomContainer,
                    onClick: $.proxy(
                        function () {
                            this.viewImage.cropper("zoom", 0.1);
                        },
                        this
                    )
                }
            );

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-icon",
                    icon: "fas fa-search-minus",
                    label: '',
                    appendTo: zoomContainer,
                    onClick: $.proxy(
                        function () {
                            this.viewImage.cropper("zoom", -0.1);
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets view aspect ratio
         */
        setViewAspectRatio: function () {
            var userAspectRatio
                = this.viewContainer.find(".user-aspect-container");
            var defaultAspectRatio
                = this.viewContainer.find(".default-aspect-container");

            var viewCropX = this.getData("viewCropX");
            var viewCropY = this.getData("viewCropY");
            if (viewCropX > 0
                && viewCropY > 0
            ) {
                ss.init(
                    "commonComponentsFormButton",
                    {
                        css: "btn btn-blue",
                        label: viewCropX + ":" + viewCropY,
                        appendTo: userAspectRatio,
                        onClick: $.proxy(
                            function () {
                                this.viewImage.cropper(
                                    "setAspectRatio",
                                    (viewCropX / viewCropY)
                                );
                            },
                            this
                        )
                    }
                );
            }

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue",
                    label: "Free",
                    appendTo: userAspectRatio,
                    onClick: $.proxy(
                        function () {
                            this.viewImage.cropper("setAspectRatio", NaN);
                        },
                        this
                    )
                }
            );

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue",
                    label: "16:9",
                    appendTo: defaultAspectRatio,
                    onClick: $.proxy(
                        function () {
                            this.viewImage.cropper("setAspectRatio", (16 / 9));
                        },
                        this
                    )
                }
            );

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue",
                    label: "4:3",
                    appendTo: defaultAspectRatio,
                    onClick: $.proxy(
                        function () {
                            this.viewImage.cropper("setAspectRatio", (4 / 3));
                        },
                        this
                    )
                }
            );

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue",
                    label: "1:1",
                    appendTo: defaultAspectRatio,
                    onClick: $.proxy(
                        function () {
                            this.viewImage.cropper("setAspectRatio", 1);
                        },
                        this
                    )
                }
            );

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue",
                    label: "2:3",
                    appendTo: defaultAspectRatio,
                    onClick: $.proxy(
                        function () {
                            this.viewImage.cropper("setAspectRatio", (2 / 3));
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets view reset
         */
        setViewReset: function () {
            var resetContainer = this.viewContainer.find(".reset-container");

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-icon",
                    icon: "fas fa-retweet",
                    label: "",
                    appendTo: resetContainer,
                    onClick: $.proxy(
                        function () {
                            this.viewImage.cropper("reset");
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * On send success
         *
         * @param {Object} data
         */
        onSendSuccess: function (data) {
            console.log(data);
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
