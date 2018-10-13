!function ($, ss) {
    "use strict";

    var name = "commonContentBlockDelete";

    var parameters = {
        /**
         * Init
         */
        init: function () {
            $.each(
                this.getOption("list", []),
                $.proxy(
                    function (i, blockId) {
                        var block = $(".block-" + blockId);

                        if (block.length > 0) {
                            block.remove();
                        }
                    },
                    this
                )
            );
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
