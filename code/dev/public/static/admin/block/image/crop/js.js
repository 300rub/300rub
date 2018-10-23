!function ($, ss) {
    "use strict";

    var name = "adminBlockImageCrop";

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
         * Init
         */
        init: function () {
            this.viewContainer = null;
            this.viewImage = null;

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
                .setView()
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
                            controller: "content",
                            data: $.proxy(
                                function () {
                                    return {
                                        blockId: this.getData("blockId"),
                                        id: this.getData("id"),
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
                                },
                                this
                            )
                        },
                        type: "PUT",
                        success: $.proxy(this.onSendSuccess, this)
                    }
                }
            );
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

        setView: function () {
            this.viewImage = this.viewContainer.find(".view-image");
            this.viewImage.attr("src", this.getData("url"));

            /* jshint ignore:start */
            this.viewImage.cropper(
                {
                    viewMode: 2,
                    preview: this.viewContainer.find(".preview"),
                    aspectRatio: 1,
                    autoCropArea: 1,
                    movable: false,
                    crop: function (event) {
                        /*ignore jslint start */
                        // console.log(event.detail.x);
                        // console.log(event.detail.y);
                        // console.log(event.detail.width);
                        // console.log(event.detail.height);
                        // console.log(event.detail.rotate);
                        // console.log(event.detail.scaleX);
                        // console.log(event.detail.scaleY);
                        /*jsl:end */
                    }
                }
            );
            /* jshint ignore:end */

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
