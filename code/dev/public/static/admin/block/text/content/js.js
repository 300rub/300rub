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
                    font_formats: fonts /* jshint ignore:line */
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
