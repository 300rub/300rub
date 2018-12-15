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
         * View
         *
         * @var {Object}
         */
        view: {
            container: null,
            image: null,
            x: 0,
            y: 0,
            width: 0,
            height: 0,
            rotate: 0,
            scaleX: 0,
            scaleY: 0
        },

        /**
         * Thumb
         *
         * @var {Object}
         */
        thumb: {
            container: null,
            image: null,
            x: 0,
            y: 0,
            width: 0,
            height: 0,
            rotate: 0,
            scaleX: 0,
            scaleY: 0
        },

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
            this.view = {
                container: null,
                image: null,
                x: 0,
                y: 0,
                width: 0,
                height: 0,
                rotate: 0,
                scaleX: 0,
                scaleY: 0
            };

            this.thumb = {
                container: null,
                image: null,
                x: 0,
                y: 0,
                width: 0,
                height: 0,
                rotate: 0,
                scaleX: 0,
                scaleY: 0
            };

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
            this.setType("view");
            if (this.getData("hasThumb") === true) {
                this.setType("thumb");
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
         * Sets type
         * 
         * @param {String} type
         */
        setType: function(type) {
            return this
                .setContainer(type)
                .setCropper(type)
                .setRotate(type)
                .setFlip(type)
                .setZoom(type)
                .setAspectRatio(type)
                .setReset(type);
        },

        /**
         * Sets container
         * 
         * @param {String} type
         */
        setContainer: function (type) {
            this[type].container
                = ss.init("template").get("image-crop-container");
            this.getBody().append(this[type].container);

            this[type].container.find(".preview-label").text(
                this.getLabel("preview")
            );
            this[type].container.find(".actions-label").text(
                this.getLabel("actions")
            );
            this[type].container.find(".image-crop-title").text(
                this.getLabel(
                    this.getData([type, "title"])
                )
            );

            return this;
        },

        /**
         * Gets crop data
         *
         * @param {String} type
         *
         * @returns {Object}
         */
        getCropData: function(type) {
            var width = this.getData([type, "width"]);
            var height = this.getData([type, "height"]);

            if (width === 0
                || height === 0
            ) {
                return {};
            }

            var flip = this.getData([type, "flip"]);
            var scaleX = 1;
            var scaleY = 1;
            switch (flip) {
                case this.flipTypes.BOTH:
                    scaleX = -1;
                    scaleY = -1;
                    break;
                case this.flipTypes.HORIZONTAL:
                    scaleX = -1;
                    break;
                case this.flipTypes.VERTICAL:
                    scaleY = -1;
                    break;
                default:
                    break;
            }

            return {
                x: this.getData([type, "x"]),
                y: this.getData([type, "y"]),
                width: width,
                height: height,
                rotate: this.getData([type, "angle"]),
                scaleX: scaleX,
                scaleY: scaleY
            };
        },

        /**
         * Sets cropper
         * 
         * @param {String} type
         */
        setCropper: function (type) {
            this[type].image = this[type].container.find(".cropper");
            this[type].image.attr("src", this.getData("url"));

            var aspectRatio = NaN;
            var width = this.getData([type, "width"]);
            var height = this.getData([type, "height"]);
            var cropX = this.getData([type, "cropX"]);
            var cropY = this.getData([type, "cropY"]);
            if (width > 0
                && height > 0
            ) {
                aspectRatio = (width / height);
            } else if (cropX > 0
                && cropY > 0
            ) {
                aspectRatio = (cropX / cropY);
            }

            this[type].image.cropper(
                {
                    viewMode: 2,
                    preview: this[type].container.find(".preview"),
                    aspectRatio: aspectRatio,
                    autoCropArea: 1,
                    movable: false,
                    data: this.getCropData(type),
                    crop: $.proxy(function (event) {
                        this[type].x = event.detail.x;
                        this[type].y = event.detail.y;
                        this[type].width = event.detail.width;
                        this[type].height = event.detail.height;
                        this[type].rotate = event.detail.rotate;
                        this[type].scaleX = event.detail.scaleX;
                        this[type].scaleY = event.detail.scaleY;
                    }, this)
                }
            );

            return this;
        },

        /**
         * Sets rotate
         * 
         * @param {String} type
         */
        setRotate: function (type) {
            var container = this[type].container.find(".rotate-container");

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-icon",
                    icon: "fas fa-undo",
                    label: '',
                    appendTo: container,
                    onClick: $.proxy(
                        function () {
                            this[type].image.cropper("rotate", -45);
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
                    appendTo: container,
                    onClick: $.proxy(
                        function () {
                            this[type].image.cropper("rotate", 45);
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets flip
         *
         * @param {String} type
         */
        setFlip: function (type) {
            var container = this[type].container.find(".flip-container");

            var flip = this.getData([type, "flip"]);
            switch (flip) {
                case this.flipTypes.BOTH:
                    container.addClass("flipped-x");
                    container.addClass("flipped-y");
                    break;
                case this.flipTypes.HORIZONTAL:
                    container.addClass("flipped-x");
                    break;
                case this.flipTypes.VERTICAL:
                    container.addClass("flipped-y");
                    break;
                default:
                    break;
            }

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-icon",
                    icon: "fas fa-arrows-alt-h",
                    label: '',
                    appendTo: container,
                    onClick: $.proxy(
                        function () {
                            if (container.hasClass("flipped-x") === true) {
                                this[type].image.cropper("scaleX", 1);
                                container.removeClass("flipped-x");
                            } else {
                                this[type].image.cropper("scaleX", -1);
                                container.addClass("flipped-x");
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
                    appendTo: container,
                    onClick: $.proxy(
                        function () {
                            if (container.hasClass("flipped-y") === true) {
                                this[type].image.cropper("scaleY", 1);
                                container.removeClass("flipped-y");
                            } else {
                                this[type].image.cropper("scaleY",-1);
                                container.addClass("flipped-y");
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
         *
         * @param {String} type
         */
        setZoom: function (type) {
            var container = this[type].container.find(".zoom-container");

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-icon",
                    icon: "fas fa-search-plus",
                    label: '',
                    appendTo: container,
                    onClick: $.proxy(
                        function () {
                            this[type].image.cropper("zoom", 0.1);
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
                    appendTo: container,
                    onClick: $.proxy(
                        function () {
                            this[type].image.cropper("zoom", -0.1);
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets aspect ratio
         *
         * @param {String} type
         */
        setAspectRatio: function (type) {
            var userAspectRatio
                = this[type].container.find(".user-aspect-container");
            var defaultAspectRatio
                = this[type].container.find(".default-aspect-container");

            this[type].container.find(".proportions-label").text(
                this.getLabel("proportions")
            );

            var cropX = this.getData([type, "cropX"]);
            var cropY = this.getData([type, "cropY"]);
            if (cropX > 0
                && cropY > 0
            ) {
                var aspectRatio = (cropX / cropY);
                if (aspectRatio !== (16 / 9)
                    && aspectRatio !== (4 / 3)
                    && aspectRatio !== (2 / 3)
                    && aspectRatio !== 1
                ) {
                    ss.init(
                        "commonComponentsFormButton",
                        {
                            css: "btn btn-blue",
                            label: cropX + ":" + cropY,
                            appendTo: userAspectRatio,
                            onClick: $.proxy(
                                function () {
                                    this[type].image.cropper(
                                        "setAspectRatio",
                                        aspectRatio
                                    );
                                },
                                this
                            )
                        }
                    );
                }
            }

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue",
                    label: "Free",
                    appendTo: userAspectRatio,
                    onClick: $.proxy(
                        function () {
                            this[type].image.cropper("setAspectRatio", NaN);
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
                            this[type].image.cropper(
                                "setAspectRatio",
                                (16 / 9)
                            );
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
                            this[type].image.cropper(
                                "setAspectRatio",
                                (4 / 3)
                            );
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
                            this[type].image.cropper("setAspectRatio", 1);
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
                            this[type].image.cropper(
                                "setAspectRatio",
                                (2 / 3)
                            );
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets reset
         *
         * @param {String} type
         */
        setReset: function (type) {
            var container = this[type].container.find(".reset-container");

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-icon",
                    icon: "fas fa-retweet",
                    label: "",
                    appendTo: container,
                    onClick: $.proxy(
                        function () {
                            this[type].image.cropper("reset");
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
                view: {
                    x: parseInt(this.view.x),
                    y: parseInt(this.view.y),
                    width: parseInt(this.view.width),
                    height: parseInt(this.view.height),
                    angle: parseInt(this.view.rotate),
                    flip: this.getFlip(this.view.scaleX, this.view.scaleY)
                }
            };

            if (this.getData("hasThumb") === false) {
                return data;
            }

            return $.extend(
                {},
                data,
                {
                    thumb: {
                        x: parseInt(this.thumb.x),
                        y: parseInt(this.thumb.y),
                        width: parseInt(this.thumb.width),
                        height: parseInt(this.thumb.height),
                        angle: parseInt(this.thumb.rotate),
                        flip: this.getFlip(this.thumb.scaleX, this.thumb.scaleY)
                    }
                }
            );
        },

        /**
         * Gets flip
         *
         * @param {int} scaleX
         * @param {int} scaleY
         *
         * @returns {int}
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
         * On send success
         */
        onSendSuccess: function () {
            ss.init(
                "commonContentBlockUpdate",
                {
                    list: [
                        this.getOption("blockId", 0)
                    ]
                }
            );

            this.remove(true);
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
