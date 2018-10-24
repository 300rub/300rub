!function ($, ss) {
    "use strict";

    var name = "adminBlockTextContent";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsWindowAbstract",

        /**
         * Forms
         *
         * @avr {Object}
         */
        forms: {},

        /**
         * Init
         */
        init: function () {
            this.forms = {};

            this.create(
                {
                    group: "text",
                    controller: "content",
                    data: {
                        id: this.getOption("blockId")
                    },
                    name: "text-content"
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            if (this.getData("type") === 0) {
                this.forms.text = ss.init(
                    "commonComponentsFormTextarea",
                    $.extend(
                        {},
                        this.getData(["forms", "text"], {}),
                        {
                            appendTo: this.getBody(),
                            rows: 15,
                            label: null
                        }
                    )
                );
            } else {
                this.forms.text = ss.init(
                    "commonComponentsFormText",
                    $.extend(
                        {},
                        this.getData(["forms", "text"], {}),
                        {
                            appendTo: this.getBody(),
                            label: null
                        }
                    )
                );
            }

            if (this.getData("hasEditor") === true) {
                this.setTinyMce();
            }

            this.setSubmit(
                {
                    label: this.getLabel("button"),
                    icon: "fas fa-save",
                    forms: this.forms,
                    ajax: {
                        data: {
                            group: "text",
                            controller: "content",
                            data: {
                                id: this.getData("id")
                            }
                        },
                        type: "PUT",
                        success: $.proxy(this.onSendSuccess, this)
                    }
                }
            );
        },

        /**
         * Sets TinyMCE editor
         */
        setTinyMce: function () {
            var fonts = "Andale Mono 111=andale mono,times;";
            fonts += "Arial=arial,helvetica,sans-serif;";
            fonts += "Arial Black=arial black,avant garde;";
            fonts += "Book Antiqua=book antiqua,palatino;";
            fonts += "Comic Sans MS=comic sans ms,sans-serif;";
            fonts += "Courier New=courier new,courier;";
            fonts += "Georgia=georgia,palatino;Helvetica=helvetica;";
            fonts += "Impact=impact,chicago;Symbol=symbol;";
            fonts += "Tahoma=tahoma,arial,helvetica,sans-serif;";
            fonts += "Terminal=terminal,monaco;";
            fonts += "Times New Roman=times new roman,times;";
            fonts += "Trebuchet MS=trebuchet ms,geneva;";
            fonts += "Verdana=verdana,geneva;";
            fonts += "Webdings=webdings;";
            fonts += "Wingdings=wingdings,zapf dingbats";

            var plugins = "textcolor link hr image imagetools ";
            plugins += "charmap print preview fullscreen table";

            var toolbar1 = "newdocument | cut copy paste | undo redo ";
            toolbar1 += "| print preview fullscreen";

            var toolbar2 = "table | fontselect fontsizeselect formatselect | ";
            toolbar2 += "removeformat | bullist numlist outdent indent | ";
            toolbar2 += "subscript superscript";

            var toolbar3 = "responsivefilemanager | image | bold italic ";
            toolbar3 += "underline strikethrough | forecolor backcolor | ";
            toolbar3 += "alignleft aligncenter alignright alignjustify | ";
            toolbar3 += "link unlink | blockquote charmap hr";

            var sizes = "8px 9px 10px 11px 12px 14px 16px 18px ";
            sizes += "20px 22px 24px 26px 28px 36px 48px 72px";

            // https://www.tiny.cloud/docs/configure/file-image-upload/
            // https://www.tiny.cloud/docs/advanced/php-upload-handler/
            // https://www.tiny.cloud/docs/demo/file-picker/

            this.forms.text.getInstance().tinymce(
                {
                    height: 300,
                    menubar: false,
                    statusbar: false,
                    setup: function (editor) {
                        editor.on(
                            'change',
                            function () {
                                editor.save();
                            }
                        );
                    },
                    plugins: plugins,
                    toolbar1: toolbar1,
                    toolbar2: toolbar2,
                    toolbar3: toolbar3,
                    fontsize_formats: sizes, /* jshint ignore:line */
                    font_formats: fonts, /* jshint ignore:line */
                    automatic_uploads: true,
                    image_title: true,
                    //file_picker_callback: function(cb, value, meta) {
                    //    var input = document.createElement('input');
                    //    input.setAttribute('type', 'file');
                    //
                    //    input.onchange = function() {
                    //        var file = this.files[0];
                    //
                    //        var reader = new FileReader();
                    //        reader.onload = function () {
                    //            // Note: Now we need to register the blob in TinyMCEs image blob
                    //            // registry. In the next release this part hopefully won't be
                    //            // necessary, as we are looking to handle it internally.
                    //            var id = 'blobid' + (new Date()).getTime();
                    //            var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    //            var base64 = reader.result.split(',')[1];
                    //            var blobInfo = blobCache.create(id, file, base64);
                    //            blobCache.add(blobInfo);
                    //
                    //            // call the callback and populate the Title field with the file name
                    //            cb(blobInfo.blobUri(), { title: file.name });
                    //        };
                    //        reader.readAsDataURL(file);
                    //    };
                    //
                    //    input.click();
                    //},
                    images_upload_handler: $.proxy(function (blobInfo, success, failure) {
                        ss.init(
                            "adminComponentsUpload",
                            {
                                data: {
                                    group: "text",
                                    controller: "image",
                                    data: {
                                        blockId: this.getOption("blockId")
                                    }
                                },
                                file: blobInfo.blob(),
                                success: $.proxy(
                                    function (data) {
                                        console.log(data);
                                        success(data.location);
                                    },
                                    this
                                )
                            }
                        );

                        //var xhr, formData;
                        //
                        //xhr = new XMLHttpRequest();
                        //xhr.withCredentials = false;
                        //xhr.open('POST', 'postAcceptor3.php');
                        //
                        //xhr.onload = function() {
                        //    var json;
                        //
                        //    if (xhr.status != 200) {
                        //        failure('HTTP Error: ' + xhr.status);
                        //        return;
                        //    }
                        //
                        //    json = JSON.parse(xhr.responseText);
                        //
                        //    if (!json || typeof json.location != 'string') {
                        //        failure('Invalid JSON: ' + xhr.responseText);
                        //        return;
                        //    }
                        //
                        //    success(json.location);
                        //};
                        //
                        //formData = new FormData();
                        //formData.append('file', blobInfo.blob(), blobInfo.filename());
                        //
                        //xhr.send(formData);
                    }, this)
                }
            );
        },

        /**
         * On send success
         */
        onSendSuccess: function () {
            this.remove();

            if (this.getOption("blockId") !== 0) {
                ss.init(
                    "commonContentBlockUpdate",
                    {
                        list: [this.getOption("blockId")]
                    }
                );
            }
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
