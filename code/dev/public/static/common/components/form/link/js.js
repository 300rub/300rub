/**
 * Link
 */
ss.add(
    "commonComponentsFormLink",
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
            this.setForm("form-link");

            var onClick = this.getOption("onClick");
            var data = this.getOption("data");

            if ($.type(onClick) === "function") {
                if ($.type(data) === "object") {
                    this.getForm().on("click", data, onClick);
                } else {
                    this.getForm().on("click", onClick);
                }
            }
        }
    }
);
