!function ($, ss) {
    "use strict";

    var name = "adminBlockTextEditor";

    var parameters = {
        /**
         * Default options
         *
         * @var {Object}
         */
        defaultOptions: {
            item: null,
            group: "",
            controller: "",
            blockId: 0
        },

        /**
         * Init
         */
        init: function () {
            this
                .extendDefaultOptions(this.defaultOptions)
                .setTinyMce();
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

            this.getOption("item").getInstance().tinymce(
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
                    relative_urls : false,
                    remove_script_host : false,
                    convert_urls : true,
                    file_picker_callback: function(cb, value, meta) {
                        var input = document.createElement('input');
                        input.setAttribute('type', 'file');

                        input.onchange = function() {
                            var file = this.files[0];

                            var reader = new FileReader();
                            reader.onload = function () {
                                var id = 'blobid' + (new Date()).getTime();
                                var blobCache = tinymce
                                    .activeEditor
                                    .editorUpload
                                    .blobCache;
                                var base64 = reader.result.split(',')[1];
                                var blobInfo
                                    = blobCache.create(id, file, base64);
                                blobCache.add(blobInfo);

                                cb(blobInfo.blobUri(), { title: file.name });
                            };
                            reader.readAsDataURL(file);
                        };

                        input.click();
                    },
                    images_upload_handler: $.proxy(
                        function (blobInfo, success) {
                            ss.init(
                                "adminComponentsUpload",
                                {
                                    data: {
                                        group: this.getOption(
                                            "group"
                                        ),
                                        controller: this.getOption(
                                            "controller"
                                        ),
                                        data: {
                                            blockId: this.getOption(
                                                "blockId"
                                            )
                                        }
                                    },
                                    file: blobInfo.blob(),
                                    success: $.proxy(
                                        function (data) {
                                            success(data.url);
                                        },
                                        this
                                    )
                                }
                            );
                        },
                        this
                    )
                }
            );
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
