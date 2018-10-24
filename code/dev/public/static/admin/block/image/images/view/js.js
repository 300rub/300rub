!function ($, ss) {
    "use strict";

    var name = "adminBlockImageImagesView";

    var parameters = {
        /**
         * Default options
         *
         * @type {Object}
         */
        defaultOptions: {
            blockId: 0,
            appendTo: null,
            isSortable: false,
            list: [
                {id: 0, url: "", name: ""}
            ],
            create: {
                hasOperation: false,
                group: "",
                controller: "",
                isSingleton: false,
                imageGroupId: 0
            },
            crop: {
                hasOperation: false,
                group: "",
                controller: "",
                level: 2,
                parent: ""
            },
            edit: {
                hasOperation: false,
                group: "",
                controller: "",
                level: 2,
                parent: ""
            },
            remove: {
                hasOperation: false,
                group: "",
                controller: "",
                data: {},
                confirm: {
                    text: "",
                    yes: "",
                    no: ""
                }
            }
        },

        /**
         * Container
         *
         * @var {Object}
         */
        container: null,

        /**
         * Upload container
         *
         * @var {Object}
         */
        uploadContainer: null,

        /**
         * Upload form
         *
         * @var {Object}
         */
        uploadForm: null,

        /**
         * Upload progress
         *
         * @var {Object}
         */
        uploadProgress: null,

        /**
         * Upload count current
         *
         * @var {Object}
         */
        uploadCountCurrent: null,

        /**
         * Upload count all
         *
         * @var {Object}
         */
        uploadCountAll: null,

        /**
         * Files
         *
         * @var {Array}
         */
        files: [],

        /**
         * Init
         */
        init: function () {
            this.container = null;
            this.uploadContainer = null;
            this.uploadForm = null;
            this.uploadProgress = null;
            this.uploadCountCurrent = null;
            this.uploadCountAll = null;
            this.files = [];

            this
                .extendDefaultOptions(this.defaultOptions)
                .createContainer()
                .setUploadContainer()
                .setList()
                .setSortable();
        },

        /**
         * Creates container
         */
        createContainer: function () {
            this.container
                = ss.init("template").get("image-sort-container");

            if (this.getOption("appendTo") !== null) {
                this.container.appendTo(this.getOption("appendTo"));
            }

            return this;
        },

        /**
         * Sets upload container
         */
        setUploadContainer: function () {
            if (this.getOption(["create", "hasOperation"]) !== true) {
                return this;
            }

            this.uploadContainer
                = ss.init("template").get("image-upload-container");
            this.uploadForm = this.uploadContainer.find(".image-add-form");
            this.uploadProgress = this.uploadContainer.find(".progress");
            this.uploadCountCurrent
                = this.uploadContainer.find(".count-container .current");
            this.uploadCountAll
                = this.uploadContainer.find(".count-container .all");

            if (this.getOption(["create", "isSingleton"]) !== true) {
                this.uploadForm.attr("multiple", true);
            }

            var t = this;
            this.uploadForm.on(
                "change",
                function () {
                    t.uploadFiles(this.files);
                }
            );

            this.uploadContainer.appendTo(this.container);

            return this;
        },

        /**
         * Sets List
         */
        setList: function () {
            $.each(
                this.getOption("list", []),
                $.proxy(
                    function (i, data) {
                        this.addItem(data);
                    },
                    this
                )
            );

            return this;
        },

        /**
         * Sets sortable
         */
        setSortable: function () {
            if (this.getOption("isSortable") !== true) {
                return this;
            }

            this.container.sortable(
                {
                    items: ".image-sort-item"
                }
            );

            return this;
        },

        /**
         * Adds item
         *
         * @param {Object} data
         */
        addItem: function (data) {
            if (data.id === 0) {
                return this;
            }

            var itemElement
                = ss.init("template").get("image-sort-item");
            itemElement.find("img").attr("src", data.url);

            this.container.append(itemElement);

            if (this.getOption(["create", "isSingleton"]) === true) {
                this.uploadContainer.addClass("hidden");
            }

            var buttons = itemElement.find(".buttons");
            if (this.getOption(["edit", "hasOperation"]) !== true
                && this.getOption(["crop", "hasOperation"]) !== true
                && this.getOption(["remove", "hasOperation"]) !== true
            ) {
                buttons.remove();
                return this;
            }

            this
                .setEditButton(buttons, data.id)
                .setCropButton(buttons, data.id)
                .setRemoveButton(buttons, data.id, itemElement);

            return this;
        },

        /**
         * Sets Edit button
         *
         * @param {Object}  buttons
         * @param {integer} instanceId
         */
        setEditButton: function(buttons, instanceId) {
            if (this.getOption(["edit", "hasOperation"]) !== true) {
                return this;
            }

            var editOptions = {
                group: this.getOption(["edit", "group"]),
                controller: this.getOption(["edit", "controller"]),
                blockId: this.getOption("blockId"),
                id: instanceId,
                level: this.getOption(["edit", "level"]),
                parent: this.getOption(["edit", "parent"])
            };

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-small edit",
                    icon: "fas fa-edit",
                    label: '',
                    appendTo: buttons,
                    onClick: $.proxy(
                        function () {
                            ss.init("adminBlockImageEditImage", editOptions);
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets Crop button
         *
         * @param {Object}  buttons
         * @param {integer} instanceId
         */
        setCropButton: function(buttons, instanceId) {
            if (this.getOption(["crop", "hasOperation"]) !== true) {
                return this;
            }

            var cropOptions = {
                group: this.getOption(["crop", "group"]),
                controller: this.getOption(["crop", "controller"]),
                blockId: this.getOption("blockId"),
                id: instanceId,
                level: this.getOption(["crop", "level"]),
                parent: this.getOption(["crop", "parent"])
            };

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-blue btn-small crop",
                    icon: "fas fa-crop",
                    label: '',
                    appendTo: buttons,
                    onClick: $.proxy(
                        function () {
                            ss.init("adminBlockImageImagesCrop", cropOptions);
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets Remove button
         *
         * @param {Object}  buttons
         * @param {integer} instanceId
         * @param {Object}  itemElement
         */
        setRemoveButton: function(buttons, instanceId, itemElement) {
            if (this.getOption(["remove", "hasOperation"]) !== true) {
                return this;
            }

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-red btn-small remove",
                    icon: "fas fa-trash",
                    label: '',
                    appendTo: buttons,
                    confirm: {
                        text: this.getOption(["remove", "confirm", "text"]),
                        yes: {
                            label: this.getOption(
                                ["remove", "confirm", "yes"]
                            ),
                            icon: "fas fa-trash"
                        },
                        no: this.getOption(["remove", "confirm", "no"])
                    },
                    ajax: {
                        data: {
                            group: this.getOption(["remove", "group"]),
                            controller: this.getOption(
                                ["remove", "controller"]
                            ),
                            data: $.extend(
                                {},
                                this.getOption(["remove", "data"], {}),
                                {
                                    id: instanceId
                                }
                            )
                        },
                        type: "DELETE",
                        success: $.proxy(function () {
                            itemElement.remove();

                            var isSingleton = this.getOption(
                                ["create", "isSingleton"]
                            );
                            if (isSingleton === true) {
                                this.uploadContainer.removeClass("hidden");
                            }
                        }, this)
                    }
                }
            );

            return this;
        },

        /**
         * Refreshes sortable
         */
        refreshSortable: function () {
            if (this.getOption("isSortable") !== true) {
                return this;
            }

            this.container.sortable("refresh");
            return this;
        },

        /**
         * Uploads files
         *
         * @param {Array} files
         */
        uploadFiles: function (files) {
            this.files = files;
            this.uploadProgress.css("width", 0);
            this.uploadCountCurrent.text(0);
            this.uploadCountAll.text(this.files.length);
            this.uploadForm.attr("disabled", true);

            this.container.addClass("loading");

            this.uploadFile(0);

            return this;
        },

        /**
         * Uploads file
         *
         * @param {int} number
         */
        uploadFile: function (number) {
            var file = this.files[number];

            if (this.files[number] === undefined) {
                this.container.removeClass("loading");
                this.uploadForm.attr("disabled", false);
                return this;
            }

            ss.init(
                "adminComponentsUpload",
                {
                    data: {
                        group: this.getOption(["create", "group"]),
                        controller: this.getOption(["create", "controller"]),
                        data: {
                            blockId: this.getOption("blockId"),
                            imageGroupId: this.getOption(
                                ["create", "imageGroupId"]
                            )
                        }
                    },
                    file: file,
                    success: $.proxy(
                        function (data) {
                            this
                            .addItem(data)
                            .refreshSortable();
                        },
                        this
                    ),
                xhr: $.proxy(this.uploadXhr, this),
                complete: $.proxy(
                    function () {
                            this.uploadFile(number + 1);
                            this.uploadCountCurrent.text(number + 1);
                    },
                    this
                )
                }
            );

            return this;
        },

        /**
         * Upload XHR
         */
        uploadXhr: function () {
            var myXhr = $.ajaxSettings.xhr();

            myXhr.upload.addEventListener(
                'progress',
                $.proxy(
                    function (event) {
                        if (event.lengthComputable === false) {
                            return false;
                        }

                        var filesPercent
                            = Math.ceil(event.loaded / event.total * 100);
                        if (filesPercent > 98) {
                            filesPercent = 98;
                        }

                        this.uploadProgress.css("width", filesPercent + "%");
                    },
                    this
                ),
                false
            );

            return myXhr;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
