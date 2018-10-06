ss.add(
    "adminReleaseWindow",
    {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsWindowAbstract",

        /**
         * Init
         */
        init: function() {
            this.create(
                {
                    group: "release",
                    controller: "fullInfo",
                    success: $.proxy(this.onLoadSuccess, this),
                    name: "release-full-info",
                    hasFooter: false
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function() {
            var table = ss.init("template").get("window-release-info-table");

            table.find(".name-label").text(this.getLabel("name"));
            table.find(".date-label").text(this.getLabel("date"));
            table.find(".category-label").text(this.getLabel("category"));
            table.find(".type-label").text(this.getLabel("type"));
            table.find(".event-label").text(this.getLabel("event"));

            var trTemplate = table.find(".tr-template");
            $.each(
                this.getData("events", []),
                $.proxy(
                    function (i, event) {
                        var tr = trTemplate.clone();
                        tr.removeClass('hidden');
                        tr.find(".name-value").text(event.name);
                        tr.find(".date-value").text(event.date);
                        tr.find(".category-value").text(event.category);
                        tr.find(".type-value").text(event.type);
                        tr.find(".event-value").text(event.event);

                        table.append(tr);
                    },
                    this
                )
            );

            this.getBody().append(table);
        }
    }
);
