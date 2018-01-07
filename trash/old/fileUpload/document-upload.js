!function ($, window) {
    'use strict';

    /**
     * Document upload
     */
    window.DocumentUpload = function () {
        this.$_progress = null;
        this.$_progressBar = null;
        this.$_fileUploadContainer = null;
        this.$_listGroupContainer = null;
        this.$_listGroupItemTemplate = null;
        this.$_buttonContainer = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    window.DocumentUpload.prototype = {
        /**
         * URLs
         *
         * @var {Object}
         */
        _urls: {
            uploadFile: "/tocsui/v1/file-upload"
        },

        /**
         * Init
         */
        init: function () {
            this
                ._setListGroup()
                ._setButtonContainer()
                ._setProgressBar()
                ._setFileUploadContainer()
                ._setFileUploadInput();
        },

        /**
         * Sets file upload input
         *
         * @returns {DocumentUpload}
         *
         * @private
         */
        _setListGroup: function() {
            this.$_listGroupContainer = $(".list-group-container");
            this.$_listGroupItemTemplate = $(".list-group-item-template");

            return this;
        },

        /**
         * Sets button container
         *
         * @returns {DocumentUpload}
         *
         * @private
         */
        _setButtonContainer: function() {
            this.$_buttonContainer = $(".button-container");
            this.$_buttonContainer.attr("hidden", true);

            return this;
        },

        /**
         * Sets file upload input
         *
         * @returns {DocumentUpload}
         *
         * @private
         */
        _setFileUploadInput: function() {
            var t = this;

            $(".file-upload-input")
                .on("change", function() {
                    t._uploadFiles(this.files);
                });

            return this;
        },

        /**
         * Sets upload container
         *
         * @returns {DocumentUpload}
         *
         * @private
         */
        _setFileUploadContainer: function() {
            this.$_fileUploadContainer = $(".file-upload-container")
                .on("dragover", function() {
                    $(this).addClass("drag-over");
                    return false;
                })
                .on("dragleave", function() {
                    $(this).removeClass("drag-over");
                    return false;
                })
                .on("drop", $.proxy(function(event) {
                    $(this).removeClass("drag-over");

                    var files = event["originalEvent"]["target"]["files"]
                        || event["originalEvent"]["dataTransfer"]["files"];

                    this._uploadFiles(files);

                    return false;
                }, this));

            return this;
        },

        /**
         * Sets progress bar
         *
         * @returns {DocumentUpload}
         *
         * @private
         */
        _setProgressBar: function() {
            this.$_progress = $(".progress");
            this.$_progress.addClass("opacity-0");
            this.$_progressBar = this.$_progress.find(".progress-bar");
            this.$_progressBar.css("width", 0);

            return this;
        },

        /**
         * Uploads all files
         *
         * @param {Array} files
         *
         * @private
         */
        _uploadFiles: function(files) {
            this.$_progress.removeClass("opacity-0");

            new window.UploadFiles({
                url: this._urls.uploadFile,
                files: files,
                progress: $.proxy(function(percent) {
                    this.$_progressBar.css("width", percent + "%");
                }, this),
                success: $.proxy(function(data) {
                    var $listGroupItemTemplate = this.$_listGroupItemTemplate.clone();
                    $listGroupItemTemplate.removeClass("list-group-item-template");
                    $listGroupItemTemplate.find(".file-link")
                        .attr("href", data["link"])
                        .text(data["name"]);

                    this.$_listGroupContainer.append($listGroupItemTemplate);
                    this.$_buttonContainer.attr("hidden", false);
                }, this),
                error: function(data) {

                },
                completed: $.proxy(function() {
                    this.$_fileUploadContainer.removeClass("drag-over");
                    this.$_progress.addClass("opacity-0");
                    this.$_progressBar.css("width", 0);
                }, this)
            });
        }
    };

    /**
     * Auto init
     */
    $(document).ready(function() {
        new window.DocumentUpload();
    });
}(window.jQuery, window);