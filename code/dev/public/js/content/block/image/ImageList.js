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
        this._uploadProgress = null;
        this._uploadCountCurrent = null;
        this._uploadCountAll = null;

        this._files = [];

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
        var itemElement = ss.components.Template.get("image-sort-item");
        itemElement.find("img").attr("src", data.thumbUrl);

        this._uploadContainer.before(itemElement);

        var buttons = itemElement.find(".buttons");

        if (this._options.canUpdate !== true
            && this._options.canDelete !== true
        ) {
            buttons.remove();
            return this;
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

        this._container.sortable(
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

        this._container.sortable("refresh");
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
        this._uploadProgress = this._uploadContainer.find(".progress");
        this._uploadCountCurrent = this._uploadContainer.find(".count-container .current");
        this._uploadCountAll = this._uploadContainer.find(".count-container .all");

        var form = this._uploadContainer.find(".image-add-form");

        if (this._options.isSingleton !== true) {
            form.attr("multiple", true);
        }

        form.on("change", function() {
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
        this._files = files;
        this._uploadProgress.css("width", 0);
        this._uploadCountCurrent.text(0);
        this._uploadCountAll.text(this._files.length);
        this._container.addClass("loading");

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
        var file = this._files[number];

        if (this._files[number] === undefined) {
            this._container.removeClass("loading");
            return this;
        }

        new ss.components.Upload(
            {
                data: this._getData(),
                file: file,
                success: $.proxy(this._onUploadSuccess, this),
                xhr: $.proxy(this._uploadXhr, this),
                complete: $.proxy(function() {
                    this._uploadFile(number + 1);
                    this._uploadCountCurrent.text(number + 1);
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

            this._uploadProgress.css("width", filesPercent + "%");
        }, this), false);

        return myXhr;
    };
}(window.jQuery, window.ss);
