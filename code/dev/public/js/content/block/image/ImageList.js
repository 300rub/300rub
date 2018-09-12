!function ($, ss) {
    'use strict';

    /**
     * Image list
     *
     * @param {Object} options
     */
    ss.content.block.image.ImageList = function (options) {
        this._options = $.extend({}, options);

        this._container = null;
        this._uploadContainer = null;

        this._filesProgress = {};
        this._filesReadyToLoad = {};

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
            ._setList()
            ._setSortable()
            ._setUploadContainer()
        ;
    };

    /**
     * Creates container
     *
     * @returns {ss.content.block.image.ImageList}
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._createContainer = function () {
        this._container = ss.components.Template.get("image-sort-container");

        if (this._options.appendTo !== undefined) {
            this._container.appendTo(this._options.appendTo);
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
        if (this._options.list === undefined) {
            return this;
        }

        $.each(this._options.list, $.proxy(function(i, itemData) {
            var itemElement = ss.components.Template.get("image-sort-item");
            itemElement.find("img").attr("src", itemData.url);
            itemElement.appendTo(this._container);

            var buttons = itemElement.find(".buttons");

            if (this._options.canUpdate !== true
                && this._options.canDelete !== true
            ) {
                buttons.remove();
                return false;
            }

            if (this._options.canUpdate === true) {
                new ss.forms.Button(
                    {
                        css: "btn btn-blue btn-small edit",
                        icon: "fas fa-edit",
                        label: '',
                        appendTo: buttons,
                        onClick: function () {
                            //
                        }
                    }
                );
            }

            if (this._options.canDelete === true) {
                new ss.forms.Button(
                    {
                        css: "btn btn-red btn-small remove",
                        icon: "fas fa-trash",
                        label: '',
                        appendTo: buttons,
                        onClick: function () {
                            //
                        }
                    }
                );
            }
        }, this));

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
        if (this._options.isSingleton === true) {
            return this;
        }

        this._container.sortable(
            {
                items: ".image-sort-item"
            }
        );

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
        if (this._options.canCreate !== true) {
            return this;
        }

        var t = this;
        this._uploadContainer = ss.components.Template.get("image-upload-container");

        this._uploadContainer.find(".image-add-form")
            .on("change", function() {
                t._uploadFiles(this.files);
            });

        this._uploadContainer.appendTo(this._container);

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
        this._beforeUpload(files);

        $.each(files, $.proxy(function (i, file) {
            new ss.components.Upload(
                {
                    data: this._getData(),
                    file: file,
                    success: $.proxy(this._onUploadSuccess, this),
                    xhr: $.proxy(this._uploadXhr(i), this),
                    complete: $.proxy(this._onUploadComplete(i), this)
                }
            );
        }, this));

        return this;
    };

    /**
     * Before upload
     *
     * @param {Array} files
     *
     * @returns {ss.content.block.image.ImageList}
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._beforeUpload = function (files) {
        this._uploadContainer.find(".progress").css("width", 0);
        this._uploadContainer.addClass("loading");
        
        this._filesProgress = {};
        this._filesReadyToLoad = {};
        for (var i = 0; i < files.length; $i++) {
            this._filesProgress[i] = 0;
            this._filesReadyToLoad[i] = true;
        }

        return this;
    };

    /**
     * Gets data for AJAX
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._getData = function () {
        var data = {
            group: this._options.group,
            controller: this._options.controller
        };

        if ($.type(this._options.data) === "object") {
            data.data = this._options.data;
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
        console.log(data);
    };

    /**
     * On file upload complete
     *
     * @param {int} fileNumber
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._onUploadComplete = function (fileNumber) {
        delete this._filesReadyToLoad[fileNumber];

        if (this._filesReadyToLoad.length === 0) {
            this._onFilesUploadCompete();
        }
    };

    /**
     * On files upload complete
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._onFilesUploadCompete = function () {
        this._uploadContainer.removeClass("loading");
    };

    /**
     * Upload XHR
     *
     * @param {int} fileNumber
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._uploadXhr = function (fileNumber) {
        var myXhr = $.ajaxSettings.xhr();
        var filesTotal = this._filesProgress.length;
        var progress = this._uploadContainer.find(".progress");

        myXhr.upload.addEventListener('progress', $.proxy(function (event) {
            if (event.lengthComputable === false) {
                return false;
            }

            this._filesProgress[fileNumber] = event.loaded / event.total;

            var filesProgress = 0;
            $.each(this._filesProgress, $.proxy(function(i, value) {
                filesProgress += value;
            }, this));

            var filesPercent = Math.ceil(filesProgress / filesTotal * 100);
            if (filesPercent > 98) {
                filesPercent = 98;
            }

            progress.css("width", filesPercent + "%");
        }, this), false);

        return myXhr;
    };
}(window.jQuery, window.ss);
