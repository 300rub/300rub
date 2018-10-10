/**
 * Abstract form
 */
ss.add(
    "commonContentBlockDelete",
    {
        /**
         * Init
         */
        init: function() {
            $.each(this.getOption("list", []), $.proxy(function(i, blockId) {
                var block = $(".block-" + blockId);

                if (block.length > 0) {
                    block.remove();
                }
            }, this));
        }
    }
);
