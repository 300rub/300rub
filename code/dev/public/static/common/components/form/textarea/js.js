/**
 * Textarea form
 */
ss.add(
    "commonComponentsFormTextarea",
    {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsFormAbstract",

        /**
         * Init
         */
        init: function() {
            this.create("form-container-textarea");

            this.getInstance().val(this.getOption("value"));

            var rows = this.getOption("rows");
            if (rows !== null) {
                this.getInstance().attr("rows", rows);
            }
        }
    }
);
