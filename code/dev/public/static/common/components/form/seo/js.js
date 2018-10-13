/**
 * SEO form
 */
ss.add(
    "commonComponentsFormSeo",
    {
        /**
         * Forms
         *
         * @var {Object}
         */
        forms: {},

        /**
         * Container
         *
         * @var {Object}
         */
        container: null,

        /**
         * Init
         */
        init: function() {
            this.forms = {};
            this.container = null;

            this
                .setContainer()
                .setForms();
        },

        /**
         * Sets container
         */
        setContainer: function () {
            this.container = ss.init("template").get("form-container-seo");
            return this;
        },

        /**
         * Gets container
         *
         * @returns {Object}
         */
        getContainer: function () {
            return this.container;
        },

        /**
         * Sets forms
         */
        setForms: function () {
            var defaultContainer = this.container.find(".default");
            var seoContainer = this.container.find(".seo");
            var toggleSeo = this.container.find(".toggle-seo");

            toggleSeo.on("click", $.proxy(function() {
                if (this.container.hasClass("opened") === true) {
                    this.container.removeClass("opened");
                } else {
                    this.container.addClass("opened");
                }
            }, this));

            if (this.getOption("name") !== null) {
                this.forms.name = ss.init(
                    "commonComponentsFormText",
                    $.extend(
                        {},
                        this.getOption("name"),
                        {
                            appendTo: defaultContainer
                        }
                    )
                );
            }

            if (this.getOption("alias") !== null) {
                this.forms.alias = ss.init(
                    "commonComponentsFormText",
                    $.extend(
                        {},
                        this.getOption("alias"),
                        {
                            appendTo: defaultContainer
                        }
                    )
                );
            }

            if (this.getOption("title") !== null) {
                this.forms.title = ss.init(
                    "commonComponentsFormText",
                    $.extend(
                        {},
                        this.getOption("title"),
                        {
                            appendTo: seoContainer
                        }
                    )
                );
            }

            if (this.getOption("keywords") !== null) {
                this.forms.keywords = ss.init(
                    "commonComponentsFormText",
                    $.extend(
                        {},
                        this.getOption("keywords"),
                        {
                            appendTo: seoContainer
                        }
                    )
                );
            }

            if (this.getOption("description") !== null) {
                this.forms.description = ss.init(
                    "commonComponentsFormText",
                    $.extend(
                        {},
                        this.getOption("description"),
                        {
                            appendTo: seoContainer
                        }
                    )
                );
            }

            if (this.getOption(["title", "value"], "") !== ""
                || this.getOption(["keywords", "value"], "")!== ""
                || this.getOption(["description", "value"], "") !== ""
            ) {
                this.container.addClass("opened");
            }

            return this;
        },

        /**
         * Gets forms
         *
         * @returns {Object}
         */
        getForms: function () {
            return this.forms;
        }
    }
);
