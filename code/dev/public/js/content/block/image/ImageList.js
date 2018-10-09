!function ($, ss) {
    'use strict';

    /**
     * Image list
     *
     * @param {Object} options
     */
    ss.content.block.image.ImageList = function (options) {
        this.init();
    };

    /**
     * Constructor
     */
    ss.content.block.image.ImageList.prototype.constructor = ss.content.block.image.ImageList;

    

    /**
     * Init
     */
    ss.content.block.image.ImageList.prototype.init = function () {
        this
            ._createContainer()
            ._setUploadContainer()
            ._setList()
            ._setSortable();
    };

    /**
     * Creates container
     *
     * @returns {ss.content.block.image.ImageList}
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._createContainer = function () {
        this.container = ss.components.Template.get("image-sort-container");

        if (this._options.appendTo !== null) {
            this.container.appendTo(this._options.appendTo);
        }

        return this;
    };

    /**
     * Sets List
     *
     * @returns {ss.content.block.image.ImageList}
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._setList = function () {
        if ($.type(this._options.list) !== "array") {
            return this;
        }

        $.each(this._options.list, $.proxy(function(i, data) {
            this._addItem(data);
        }, this));

        return this;
    };

    /**
     * Adds item
     *
     * @param {Object} data
     *
     * @returns {ss.content.block.image.ImageList}
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._addItem = function (data) {
        if (data.id === 0) {
            return this;
        }

        var itemElement = ss.components.Template.get("image-sort-item");
        itemElement.find("img").attr("src", data.url);

        var buttons = itemElement.find(".buttons");

        if (this._options.update.hasOperation !== true
            && this._options.delete.hasOperation !== true
        ) {
            buttons.remove();
            return this;
        }

        if (this._options.update.hasOperation === true) {
            new ss.forms.Button(
                {
                    css: "btn btn-blue btn-small edit",
                    icon: "fas fa-edit",
                    label: '',
                    appendTo: buttons,
                    onClick: $.proxy(function() {
                        new ss.window.blocks.image.Crop(
                            {
                                blockId: this._options.update.blockId,
                                id: data.id,
                                level: this._options.update.level,
                                parent: this._options.update.parent
                            }
                        );
                    }, this)
                }
            );
        }

        if (this._options.delete.hasOperation === true) {
            new ss.forms.Button(
                {
                    css: "btn btn-red btn-small remove",
                    icon: "fas fa-trash",
                    label: '',
                    appendTo: buttons,
                    confirm: {
                        text: this._options.delete.confirm.text,
                        yes: {
                            label: this._options.delete.confirm.yes,
                            icon: "fas fa-trash"
                        },
                        no: this._options.delete.confirm.no
                    },
                    ajax: {
                        data: {
                            group: this._options.delete.group,
                            controller: this._options.delete.controller,
                            data: $.extend(
                                {},
                                this._options.delete.data,
                                {
                                    id: data.id
                                }
                            )
                        },
                        type: "DELETE",
                        success: function () {
                            itemElement.remove();
                        }
                    }
                }
            );
        }

        this.container.append(itemElement);

        return this;
    };

    /**
     * Sets sortable
     *
     * @returns {ss.content.block.image.ImageList}
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._setSortable = function () {
        if (this._options.isSortable !== true) {
            return this;
        }

        this.container.sortable(
            {
                items: ".image-sort-item"
            }
        );

        return this;
    };

    /**
     * Refreshes sortable
     *
     * @returns {ss.content.block.image.ImageList}
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._refreshSortable = function () {
        if (this._options.isSortable === true) {
            return this;
        }

        this.container.sortable("refresh");
        return this;
    };

    /**
     * Sets add button
     *
     * @returns {ss.content.block.image.ImageList}
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._setUploadContainer = function () {
        if (this._options.create.hasOperation !== true) {
            return this;
        }

        var t = this;
        this.uploadContainer = ss.components.Template.get("image-upload-container");
        this.uploadForm = this.uploadContainer.find(".image-add-form");
        this.uploadProgress = this.uploadContainer.find(".progress");
        this.uploadCountCurrent = this.uploadContainer.find(".count-container .current");
        this.uploadCountAll = this.uploadContainer.find(".count-container .all");

        if (this._options.create.isSingleton !== true) {
            this.uploadForm.attr("multiple", true);
        }

        this.uploadForm.on("change", function() {
            t._uploadFiles(this.files);
        });

        this.uploadContainer.appendTo(this.container);

        return this;
    };

    /**
     * Uploads files
     *
     * @param {Array} files
     *
     * @returns {ss.content.block.image.ImageList}
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._uploadFiles = function (files) {
        this.files = files;
        this.uploadProgress.css("width", 0);
        this.uploadCountCurrent.text(0);
        this.uploadCountAll.text(this.files.length);
        this.uploadForm.attr("disabled", true);

        this.container.addClass("loading");

        this._uploadFile(0);

        return this;
    };

    /**
     * Uploads file
     *
     * @param {int} number
     *
     * @returns {ss.content.block.image.ImageList}
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._uploadFile = function (number) {
        var file = this.files[number];

        if (this.files[number] === undefined) {
            this.container.removeClass("loading");
            this.uploadForm.attr("disabled", false);
            return this;
        }

        new ss.components.Upload(
            {
                data: this._getUploadData(),
                file: file,
                success: $.proxy(this._onUploadSuccess, this),
                xhr: $.proxy(this._uploadXhr, this),
                complete: $.proxy(function() {
                    this._uploadFile(number + 1);
                    this.uploadCountCurrent.text(number + 1);
                }, this)
            }
        );

        return this;
    };

    /**
     * Gets data for AJAX
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._getUploadData = function () {
        var data = {
            group: this._options.create.group,
            controller: this._options.create.controller
        };

        if ($.type(this._options.create.data) === "object") {
            data.data = this._options.create.data;
        }

        return data;
    };

    /**
     * On file upload success
     *
     * @param {Object} data
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._onUploadSuccess = function (data) {
        this
            ._addItem(data)
            ._refreshSortable();
    };

    /**
     * Upload XHR
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._uploadXhr = function () {
        var myXhr = $.ajaxSettings.xhr();

        myXhr.upload.addEventListener('progress', $.proxy(function (event) {
            if (event.lengthComputable === false) {
                return false;
            }

            var filesPercent = Math.ceil(event.loaded / event.total * 100);
            if (filesPercent > 98) {
                filesPercent = 98;
            }

            this.uploadProgress.css("width", filesPercent + "%");
        }, this), false);

        return myXhr;
    };
}(window.jQuery, window.ss);
