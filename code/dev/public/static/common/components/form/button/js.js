/**
 * Button
 */
ss.add(
    "commonComponentsFormButton",
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
            this.setForm("form-button");

            var icon = this.getOption("icon");
            if (icon !== null) {
                this.getForm().find(".icons .icon").addClass(icon);
            } else {
                this.getForm().find(".icons").remove();
            }

            var ajax = this.getOption("ajax");
            if ($.type(this.getOption("forms")) === "array"
                || $.type(this.getOption("forms")) === "object"
            ) {
                this.getForm().on("click", $.proxy(this.processForm, this));
            } else if ($.type(ajax) === "object"
                && this.getForm().prop("disabled") === false
            ) {
                if ($.type(this.getOption("confirm")) === "object") {
                    this.getForm().on(
                        "click",
                        $.proxy(this.setConfirmWindow, this)
                    );
                } else {
                    this.getForm().on(
                        "click",
                        $.proxy(this.processAjax, this)
                    );
                }
            }

            var onClick = this.getOption("onClick");
            var data = this.getOption("data");
            if ($.type(onClick) === "function") {
                if ($.type(data) === "object") {
                    this.getForm().on("click", data, onClick);
                } else {
                    this.getForm().on("click", onClick);
                }
            }
        },

        /**
         * Processes AJAX
         */
        processAjax: function() {
            var icon = this.getForm().find(".icons .icon");
            var spinner = this.getForm().find(".icons .fa-spin");
            this.getForm().attr("disabled", true);

            icon.addClass("hidden");
            spinner.removeClass("hidden");

            var ajax = this.getOption("ajax");

            if (ajax.data !== undefined
                && $.type(ajax.data.data) === "function"
            ) {
                ajax.data.data = this.parseFormData(
                    $.extend({}, ajax.data.data())
                );
            }

            if ($.type(ajax.complete) !== "function") {
                ajax.complete = $.proxy(
                    function () {
                        icon.removeClass("hidden");
                        spinner.addClass("hidden");
                        this.getForm().attr("disabled", false);
                    },
                    this
                );
            }

            new ss.components.Ajax(ajax);
        },

        /**
         * Sets confirm window
         */
        setConfirmWindow: function () {
            new ss.components.Confirmation(
                $.extend(
                    {},
                    this.getOption("confirm"),
                    {
                        element: this.getForm(),
                        ajax: this.getOption("ajax")
                    }
                )
            );
        },

        /**
         * Processes form
         *
         * @return {Boolean}
         */
        processForm: function () {
            var flattenData = {};
            var hasError = false;
            var isScrolled = false;

            $.each(
                this.getOption("forms"),
                $.proxy(
                    function (i, item) {
                        item.validate();
                        if (item.getForm().hasClass("error") === true) {
                            hasError = true;
                            if (isScrolled === false) {
                                isScrolled = true;
                                item.scrollTo().focus();
                            }
                        }

                        flattenData[item.getName()] = item.getValue();
                    },
                    this
                )
            );

            var data = this.parseFormData($.extend({}, flattenData));

            var ajax = this.getOption("ajax");
            if (hasError === true
                || $.type(ajax) !== "object"
                || this.getForm().prop("disabled") === true
            ) {
                return false;
            }

            var icon = this.getForm().find(".icons .icon");
            var spinner = this.getForm().find(".icons .fa-spin");
            this.getForm().attr("disabled", true);

            icon.addClass("hidden");
            spinner.removeClass("hidden");

            if ($.type(ajax.data.data) === "object") {
                ajax.data.data = $.extend({}, ajax.data.data, data);
            } else {
                ajax.data.data = data;
            }

            ajax.complete = $.proxy(
                function () {
                    icon.removeClass("hidden");
                    spinner.addClass("hidden");
                    this.getForm().attr("disabled", false);
                },
                this
            );

            new ss.components.Ajax(ajax);
            return true;
        },

        /**
         * Parses form data
         *
         * @param {Object} data
         *
         * @return {Object}
         */
        parseFormData: function (data) {
            var helpObject = {};
            var object = {};

            $.each(
                data,
                function (fullFieldName, value) {
                    if (fullFieldName.indexOf(".") === -1) {
                        object[fullFieldName] = value;
                    } else {
                        var arr = fullFieldName.split(".");
                        var alias = arr.shift();
                        var field = arr.join(".");
                        if (helpObject[alias] === undefined) {
                            helpObject[alias] = {};
                        }

                        helpObject[alias][field] = value;
                    }
                }
            );

            $.each(
                helpObject,
                $.proxy(
                    function (key, value) {
                        object[key] = this.parseFormData(value);
                    },
                    this
                )
            );

            return object;
        }
    }
);
