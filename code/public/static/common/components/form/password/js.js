!function ($, ss) {
    "use strict";

    var name = "commonComponentsFormPassword";

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
            this.create("form-container-password");
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
