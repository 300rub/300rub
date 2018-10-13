!function ($, ss) {
    "use strict";

    var name = "commonComponentsFormTextarea";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsFormAbstract",

        /**
         * Init
         */
        init: function () {
            this.create("form-container-textarea");

            this.getInstance().val(this.getOption("value"));

            var rows = this.getOption("rows");
            if (rows !== null) {
                this.getInstance().attr("rows", rows);
            }
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
