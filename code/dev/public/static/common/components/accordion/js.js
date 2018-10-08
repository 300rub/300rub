/**
 * Abstract form
 */
ss.add(
    "commonComponentsAccordion",
    {
        /**
         * Container
         */
        container: null,

        /**
         * Init
         */
        init: function() {
            this.container = this.getOption("container");
            if (this.container === null) {
                return this;
            }

            this
                .buildTree(this.getOption("tree", []), this.container)
                .setAccordion();

            return this;
        },

        /**
         * Builds tree
         *
         * @param {Array}  items
         * @param {Object} appendTo
         */
        buildTree: function(items, appendTo) {
            $.each(items, $.proxy(function(i, item) {
                var element = ss.init("template").get("accordion-element");
                element.appendTo(appendTo);

                element.find(".accordion-title .text").text(item.title);

                var body = element.find(".accordion-body");

                if (item.children !== undefined) {
                    this.buildTree(item.children, body);
                }

                if (item.body !== undefined) {
                    body.append(item.body);
                }
            }, this));

            return this;
        },

        /**
         * Sets accordion
         */
        setAccordion: function() {
            this.container.find(".accordion-title").off().on(
                "click",
                function () {
                    var accordionContainer = $(this).parent();
                    if (accordionContainer.hasClass("opened")) {
                        accordionContainer.removeClass("opened");
                        return true;
                    }

                    accordionContainer
                        .parent()
                        .find(".accordion-container")
                        .removeClass("opened");
                    accordionContainer.addClass("opened");
                    return true;
                }
            );

            return this;
        }
    }
);
