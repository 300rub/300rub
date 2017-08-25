!function ($, window) {
    'use strict';

    /**
     * Upload files
     *
     * @param {Object} options
     */
    window.UploadFiles = function (options) {
        this._options = options;

        this._files = [];
        this._currentFile = null;
        this._count = 0;
        this._percent = 0;
        this._completed = 0;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    window.UploadFiles.prototype = {

        /**
         * Init
         */
        init: function () {
            this
                ._setFiles()
                ._uploadFiles();
        },

        /**
         * Sets current file
         *
         * @param {File} file
         *
         * @returns {UploadFiles}
         *
         * @private
         */
        _setCurrentFile: function (file) {
            this._currentFile = file;
            return this;
        },

        /**
         * Sets files
         *
         * @returns {UploadFiles}
         *
         * @private
         */
        _setFiles: function () {
            if (this._options["files"] !== undefined) {
                this._files = this._options["files"];
                this._count = this._files.length;
            }

            return this;
        },

        /**
         * Uploads all files
         *
         * @returns {UploadFiles}
         *
         * @private
         */
        _uploadFiles: function () {
            $.each(this._files, $.proxy(function (i, file) {
                this
                    ._setCurrentFile(file)
                    ._uploadFile();
            }, this));

            return this;
        },

        /**
         * Uploads current file
         *
         * @private
         */
        _uploadFile: function () {
            var formData = new FormData();
            formData.append("file", this._currentFile);

            $.ajax({
                type: "POST",
                url: this._options["url"],
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                dataType: 'json',
                xhr: $.proxy(this._xhr, this),
                success: $.proxy(function (data) {
                    this._options["success"](data);
                    this._completed += 1;

                    if (this._completed === this._count) {
                        this._options["completed"]();
                    }
                }, this),
                error: $.proxy(function (data) {
                    this._options["error"](data);
                    this._completed += 1;
                    if (this._completed === this._count) {
                        this._options["completed"]();
                    }
                }, this)
            });
        },

        /**
         * Gets xhr object
         *
         * @returns {Object}
         *
         * @private
         */
        _xhr: function () {
            var myXhr = $.ajaxSettings.xhr();

            if ($.type(this._options["progress"]) !== "function") {
                return myXhr;
            }

            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', $.proxy(function (event) {
                    var position = event.loaded || event.position;
                    var total = event.total;

                    if (event["lengthComputable"]) {
                        this._percent += Math.ceil(position / total * 100 / this._count);
                        if (this._percent > 100) {
                            this._percent = 100;
                        }
                    }

                    this._options["progress"](this._percent);
                }, this), false);
            }

            return myXhr;
        }
    };
}(window.jQuery, window);