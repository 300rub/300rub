ss.add(
    "adminBlockImageSettings",
    {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsPanel",

        /**
         * Auto crop data
         *
         * @type {Array}
         */
        autoCropData: [
            {value: 1, icon: "fas fa-arrow-right", css: "deg-45"},
            {value: 2, icon: "fas fa-arrow-down"},
            {value: 3, icon: "fas fa-arrow-down", css: "deg-45"},
            {value: 4, icon: "fas fa-arrow-right"},
            {value: 5, icon: "fas fa-arrows-alt"},
            {value: 6, icon: "fas fa-arrow-left"},
            {value: 7, icon: "fas fa-arrow-up", css: "deg-45"},
            {value: 8, icon: "fas fa-arrow-up"},
            {value: 9, icon: "fas fa-arrow-left", css: "deg-45"}
        ],

        /**
         * Container
         *
         * @var {Object}
         */
        container: null,

        /**
         * Forms
         *
         * @var {Object}
         */
        forms: {},

        /**
         * Init
         */
        init: function() {
            this.container = null;
            this.forms = {};

            this.create(
                {
                    group: "image",
                    controller: "block",
                    data: {
                        id: this.getOption("blockId", 0)
                    },
                    back: function() {
                        ss.init("adminBlockImageList");
                    }
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function() {
            var type = "PUT";
            var icon = "fas fa-save";
            if (data.id === 0) {
                type = "POST";
                icon = "fas fa-plus";
            }

            this
                .setContainer()
                .setButtons()
                .setName()
                .setType()
                .setUseAlbums()
                .setConfigureCrop()
                .setCropProportions()
                .setAutoCrop()
            ;
        },

        /**
         * Sets container
         */
        setContainer: function () {
            this.container
                = ss.get("template").get("image-settings-container");
            this.container.appendTo(this.getBody());

            return this;
        },

        /**
         * Sets buttons
         */
        setButtons: function () {
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
                                ss.init(
                                    "adminBlockImageSettings",
                                    {
                                        blockId: data.id
                                    }
                                );
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
                                ss.init("adminBlockImageList");
                                ss.init(
                                    "commonContentBlockDelete",
                                    {
                                        list: [
                                            this.getOption("blockId", 0)
                                        ]
                                    }
                                );
                            }, this)
                        }
                    }
                );
        },

        /**
         * Sets name
         */
        setName: function () {
            this.forms.name = ss.init(
                "commonComponentsFormText",
                $.extend(
                    {},
                    this.getData(["forms", "name"], {}),
                    {
                        appendTo: this.container
                    }
                )
            );

            return this;
        },

        /**
         * Sets type
         */
        setType: function () {
            if (this.getData(["forms", "type", "value"], 0) === 0) {
                this.container.addClass("zoom");
            }

            this.forms.type = ss.init(
                "commonComponentsFormSelect",
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
        },

        /**
         * Sets use albums form
         */
        setUseAlbums: function () {
            this.forms.useAlbums = ss.init(
                "commonComponentsFormCheckboxOnOff",
                $.extend(
                    {},
                    this.getData(["forms", "useAlbums"], {}),
                    {
                        appendTo: this.container
                    }
                )
            );

            return this;
        },

        /**
         * Sets configure crop
         */
        setConfigureCrop: function () {
            var useCrop = false;
            if ((this.getData(["forms", "cropX", "value"], 0) > 0
                && this.getData(["forms", "cropY", "value"], 0) > 0)
                || (this.getData(["forms", "thumbCropX", "value"], 0) > 0
                && this.getData(["forms", "thumbCropY", "value"], 0) > 0)
            ) {
                useCrop = true;
                this.container.addClass("use-crop");
            }

            ss.init(
                "commonComponentsFormCheckboxOnOff",
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
        },

        /**
         * Sets crop proportions
         */
        setCropProportions: function () {
            var cropContainer =
                ss.init("template").get("image-settings-crop-container");
            cropContainer
                .find(".label-text")
                .text(this.getLabel("cropProportions"));

            this.forms.cropX = ss.init(
                "commonComponentsFormSpinner",
                $.extend(
                    {},
                    this.getData(["forms", "cropX"], {}),
                    {
                        appendTo: cropContainer.find(".crop-x"),
                        min: 0
                    }
                )
            );

            this.forms.cropY = ss.init(
                "commonComponentsFormSpinner",
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
        },

        /**
         * Sets auto crop
         */
        setAutoCrop: function () {
            var hasAutoCrop = false;
            if (this.getData(["forms", "autoCropType", "value"], 0) > 0) {
                hasAutoCrop = true;
                this.container.addClass("auto-crop");
            }

            ss.init(
                "commonComponentsFormCheckboxOnOff",
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

            this.forms.autoCropType = ss.init(
                "commonComponentsFormRadioButtons",
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
        }
    }
);
