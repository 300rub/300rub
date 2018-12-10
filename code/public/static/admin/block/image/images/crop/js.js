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
         * Container
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
                .setContainers()
                .setViewCropper()
                .setViewRotate()
                .setViewFlip()
                .setViewZoom()
                .setViewAspectRatio()
                .setViewReset();

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
         * Function to generate request data
         *
         * @return {Object}
         */
        generateData: function() {
            return {
                blockId: parseInt(this.getData("blockId")),
                id: parseInt(this.getData("id")),
                x1: parseInt(this.viewX),
                y1: parseInt(this.viewY),
                viewWidth: parseInt(this.viewWidth),
                viewHeight: parseInt(this.viewHeight),
                angle: parseInt(this.viewRotate),
                viewFlip: this.getFlip(this.viewScaleX, this.viewScaleY),
                thumbX: parseInt(this.thumbX),
                thumbY: parseInt(this.thumbY),
                thumbWidth: parseInt(this.thumbWidth),
                thumbHeight: parseInt(this.thumbHeight),
                thumbAngle: parseInt(this.thumbRotate),
                thumbFlip: this.getFlip(this.thumbScaleX, this.thumbScaleY)
            };
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
         * Sets container
         */
        setContainers: function () {
            this.viewContainer
                = ss.init("template").get("image-crop-container");
            this.getBody().append(this.viewContainer);

            return this;
        },

        /**
         * Sets view cropper
         */
        setViewCropper: function () {
            this.viewImage = this.viewContainer.find(".cropper");
            this.viewImage.attr("src", this.getData("url"));

            this.viewImage.cropper(
                {
                    viewMode: 2,
                    preview: this.viewContainer.find(".preview"),
                    aspectRatio: 1,
                    autoCropArea: 1,
                    movable: false,
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

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue",
                    label: "1024:200",
                    appendTo: userAspectRatio,
                    onClick: $.proxy(
                        function () {
                            this.viewImage
                                .cropper("setAspectRatio", (1024 / 200));
                        },
                        this
                    )
                }
            );

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
