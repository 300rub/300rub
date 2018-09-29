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
         * Parent options
         *
         * @var {Object}
         */
        parentOptions: {
            template: "form-container-textarea"
        },

        /**
         * Init
         */
        init: function() {
            this.getInstance().val(this.getOption("value"));

            var rows = this.getOption("rows");
            if (rows !== null) {
                this.getInstance().attr("rows", rows);
            }
        }
    }
);
