!function ($, ss) {
    'use strict';

    /**
     * Section structure window
     *
     * @param {int} blockId
     *
     * @type {Object}
     */
    ss.window.blocks.text.Content = function (blockId) {
        ss.window.Abstract.call(
            this,
            {
                group: "text",
                controller: "content",
                data: {
                    id: blockId
                },
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "text-content"
            }
        );

        this._blockId = blockId;
        this._textForm = null;
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.blocks.text.Content.prototype
        = Object.create(ss.window.Abstract.prototype);

    /**
     * Constructor
     */
    ss.window.blocks.text.Content.prototype.constructor = ss.window.blocks.text.Content;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.blocks.text.Content.prototype._onLoadDataSuccess = function (data) {
        if (data.type === 0) {
            this._textForm = new ss.forms.Textarea(
                $.extend(
                    {
                        appendTo: this.getBody(),
                        rows: 15
                    },
                    data.text
                )
            );
        } else {
            this._textForm = new ss.forms.Text(
                $.extend(
                    {
                        appendTo: this.getBody()
                    },
                    data.text
                )
            );
        }

        if (data.hasEditor === true) {
            this._setTinyMce();
        }

        this
            .setTitle(data.name)
            .setSubmit(
                {
                    label: data.button.label,
                    icon: "fas fa-save",
                    forms: [this._textForm],
                    ajax: {
                        data: {
                            group: "text",
                            controller: "content",
                            data: {
                                id: data.id
                            }
                        },
                        type: "PUT",
                        success: $.proxy(this._onSendSuccess, this)
                    }
                }
            );
    };

    /**
     * Sets TinyMCE editor
     *
     * @returns {ss.window.blocks.text.Content}
     *
     * @private
     */
    ss.window.blocks.text.Content.prototype._setTinyMce = function () {
        this._textForm.getInstance().tinymce({
            height: 300,
            menubar: false,
            statusbar: false,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            },
            plugins: "textcolor link hr image imagetools charmap print preview fullscreen table",
            toolbar1: "newdocument | cut copy paste | undo redo | print preview fullscreen",
            toolbar2: "table | fontselect fontsizeselect formatselect | removeformat | bullist numlist outdent indent | subscript superscript",
            toolbar3: "responsivefilemanager | image | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | link unlink | blockquote charmap hr",
            fontsize_formats: "8px 9px 10px 11px 12px 14px 16px 18px 20px 22px 24px 26px 28px 36px 48px 72px",
            font_formats: "Andale Mono 111=andale mono,times;"+
            "Arial=arial,helvetica,sans-serif;"+
            "Arial Black=arial black,avant garde;"+
            "Book Antiqua=book antiqua,palatino;"+
            "Comic Sans MS=comic sans ms,sans-serif;"+
            "Courier New=courier new,courier;"+
            "Georgia=georgia,palatino;"+
            "Helvetica=helvetica;"+
            "Impact=impact,chicago;"+
            "Symbol=symbol;"+
            "Tahoma=tahoma,arial,helvetica,sans-serif;"+
            "Terminal=terminal,monaco;"+
            "Times New Roman=times new roman,times;"+
            "Trebuchet MS=trebuchet ms,geneva;"+
            "Verdana=verdana,geneva;"+
            "Webdings=webdings;"+
            "Wingdings=wingdings,zapf dingbats"
        });

        return this;
    };

    /**
     * On send success
     *
     * @private
     */
    ss.window.blocks.text.Content.prototype._onSendSuccess = function () {
        this.remove();

        if (this._blockId !== 0) {
            new ss.content.block.Update([this._blockId]);
        }
    };
}(window.jQuery, window.ss);
