<textarea rows="15" title="text">123123</textarea>


<script>
    tinymce.init({
        selector:'textarea',
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
</script>