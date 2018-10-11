!function ($, ss) {
    "use strict";

    var name = "commonComponentsAutoload";

    var parameters = {
        /**
         * Page number
         *
         * @var {int}
         */
        page: 1,

        /**
         * Can load flag
         *
         * @var {boolean}
         */
        canLoad: true,

        /**
         * Interval
         *
         * @var {Number}
         */
        interval: null,

        /**
         * Init
         */
        init: function () {
            this.page = 1;
            this.canLoad = true;
            this.interval = null;

            this.interval = setInterval(
                $.proxy(
                    function () {
                        if (this.isLoad() === true) {
                            this.load();
                        }
                    },
                    this
                ),
                1000
            );
        },

        /**
         * Loads data
         */
        load: function () {
            ss.init(
                "ajax",
                {
                    data: {
                        group: this.getOption("group"),
                        controller: this.getOption("controller"),
                        data: {
                            page: this.page + 1,
                            blockId: this.getOption("blockId"),
                            sectionId: ss.init("app").getSectionId()
                        }
                    },
                    beforeSend: $.proxy(
                        function () {
                            this.canLoad = false;
                        },
                        this
                    ),
                success: $.proxy(
                    function (data) {
                            var html = $.trim(data.html);
                        if (html === "") {
                            clearInterval(this.interval);
                            this.getOption("element").remove();
                        }

                            this.getOption("container").append(html);
                    },
                    this
                ),
                error: $.proxy(
                    function () {
                            clearInterval(this.interval);
                            this.getOption("element").remove();
                    },
                    this
                ),
                complete: $.proxy(
                    function () {
                            this.canLoad = true;
                            this.page++;
                    },
                    this
                )
                }
            );
        },

        /**
         * Is load data?
         *
         * @returns {boolean}
         */
        isLoad: function () {
            if (this.canLoad === false) {
                return false;
            }

            var top = (this.getOption("element").offset().top - 100);

            return ($(document).scrollTop() + $(window).height()) > top;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
