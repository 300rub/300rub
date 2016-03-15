!function ($, c) {
    "use strict";

    c.Design = function (id, type, values) {
        this.id = id;
        this.type = type;
        this.values = values;
        this.init();
    };

    c.Design.prototype = {
        constructor: c.Design,

        editor: null,

        init: function () {
            this.editor = c.$templates.find(".design-" + this.type + "-editor").clone();
            t.editor.attr("data-id", t.id);
            t.object = $(".design-" + t.type + "-" + t.id);
            t.style = t.object.attr("style");
            t.class = t.object.attr("class");


            if (this.data.angle !== undefined) {
                $.each(this.data.angle, function (i, data) {
                    this._setAngles(data);
                });
            }
        },

        _setAngles: function (data) {

        }
    };

    $.design = function ($container, data) {
        return new c.Design($container, data);
    };
}(window.jQuery, window.Core);