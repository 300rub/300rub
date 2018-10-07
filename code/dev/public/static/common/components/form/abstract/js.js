/**
 * Abstract form
 */
ss.add(
    "commonComponentsFormAbstract",
    {
        /**
         * Form
         *
         * @var {Object}
         */
        form: null,

        /**
         * Instance
         *
         * @var {Object}
         */
        instance: null,

        /**
         * Errors
         *
         * @var {Array}
         */
        errors: [],

        /**
         * Init
         */
        init: function() {
        },

        /**
         * Sets form
         */
        create: function(template) {
            this
                .setForm(template)
                .setInstance()
                .setName()
                .setLabel()
                .setPlaceholder()
                .setCssClass()
                .setOnBlur()
                .setOnlyNumbers()
                .appendTo()
                .setOnChange()
                .setValue();
        },

        /**
         * Sets form
         */
        setForm: function(template) {
            this.form = ss.init("template").get(template);
            return this;
        },

        /**
         * Gets form
         *
         * @returns {Object}
         */
        getForm: function () {
            return this.form;
        },

        /**
         * Sets Instance
         */
        setInstance: function() {
            this.instance = this.form.find(".form-instance");
            return this;
        },

        /**
         * Gets form instance
         *
         * @returns {Object}
         */
        getInstance: function () {
            return this.instance;
        },

        /**
         * Sets name
         */
        setName: function () {
            var name = this.getOption("name");
            if (name === null) {
                return this;
            }

            this.instance.attr("name", name);
            return this;
        },

        /**
         * Gets the name
         *
         * @returns {String}
         */
        getName: function () {
            return this.instance.attr("name");
        },

        /**
         * Sets label
         */
        setLabel: function () {
            var label = this.getOption("label");
            if (label === null) {
                return this;
            }

            this.form.find(".label-text").text(label);
            return this;
        },

        /**
         * Sets placeholder
         */
        setPlaceholder: function () {
            var placeholder = this.getOption("placeholder");
            if (placeholder === null) {
                return this;
            }

            this.instance.attr("placeholder", placeholder);
            return this;
        },

        /**
         * Sets CSS class
         */
        setCssClass: function () {
            var css = this.getOption("css");
            if (css === null) {
                return this;
            }

            this.form.addClass(css);
            return this;
        },

        /**
         * Sets on blur event (validation)
         */
        setOnBlur: function () {
            this.instance.on("blur", $.proxy(this.validate, this));
            return this;
        },

        /**
         * Allows only numbers
         */
        setOnlyNumbers: function () {
            if (this.getOption("onlyNumbers") === null) {
                return this;
            }

            this.getInstance().on(
                "keydown",
                function (e) {
                    if (this.isSystemKeyCode(e) === true
                        || this.isCopyPastKeyCode(e) === true
                        || this.isMoveKeyCode(e) === true
                    ) {
                        return null;
                    }

                    if (this.isNotNumberKeyCode(e) === true) {
                        return false;
                    }
                }
            );

            return this;
        },

        /**
         * Appends to
         */
        appendTo: function () {
            var appendTo = this.getOption("appendTo");
            if (appendTo === null) {
                return this;
            }

            this.form.appendTo(appendTo);
            return this;
        },

        /**
         * Sets on change
         */
        setOnChange: function () {
            this.instance.on("change", $.proxy(function() {
                this.instance.addClass("form-changed");
            }, this));

            return this;
        },

        /**
         * Validates the form
         */
        validate: function () {
            this.form.removeClass("error");

            var validation = this.getOption("validation");
            if ($.type(validation) !== "object"
                || validation.length === 0
            ) {
                return this;
            }

            this.validateByRules(validation);

            if (this.errors.length > 0) {
                this.setError(this.errors[0]);
            } else {
                this.form.removeClass("error");
                this.form.find("span.error").text("");
            }

            return this;
        },

        /**
         * Validates by rules
         *
         * @param rules
         */
        validateByRules: function(rules) {
            this.errors = [];

            $.each(
                rules,
                $.proxy(
                    function (key, value) {
                        switch (key) {
                            case "required":
                                this.checkRequired();
                                break;
                            case "maxLength":
                                this.checkMaxLength(value);
                                break;
                            case "minLength":
                                this.checkMinLength(value);
                                break;
                            case "latinDigitUnderscoreHyphen":
                                this.checkLatinDigitUnderscoreHyphen();
                                break;
                            case "email":
                                this.checkEmail();
                                break;
                        }
                    },
                    this
                )
            );

            return this;
        },

        /**
         * Adds error
         *
         * @param {String} [error]
         */
        addError: function (error) {
            this.errors.push(error);
        },

        /**
         * Verifies required
         */
        checkRequired: function () {
            if ($.trim(this.getValue()) === "") {
                this.addError(
                    ss.init("commonComponentsError").get("required")
                );
            }
        },

        /**
         * Verifies string length for max value
         *
         * @param {int} [max]
         */
        checkMaxLength: function (max) {
            if ($.trim(this.getValue()).length > parseInt(max, 10)) {
                this.addError(
                    ss.init("commonComponentsError").get("maxLength")
                );
            }
        },

        /**
         * Verifies string length for min value
         *
         * @param {int} [min]
         */
        checkMinLength: function (min) {
            if ($.trim(this.getValue()).length < parseInt(min, 10)) {
                this.addError(
                    ss.init("commonComponentsError").get("minLength")
                );
            }
        },

        /**
         * Verifies regex: latin, digit, underscore, hyphen
         */
        checkLatinDigitUnderscoreHyphen: function () {
            var pattern = new RegExp("^[0-9a-z-_]+$");
            if (!pattern.test($.trim(this.getValue()))) {
                this.addError(
                    ss.init("commonComponentsError").get("latinDigitUnderscoreHyphen")
                );
            }
        },

        /**
         * Checks email
         */
        checkEmail: function () {
            var pattern = new RegExp(
                "^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$"
            );
            if (!pattern.test($.trim(this.getValue()))) {
                this.addError(
                    ss.init("commonComponentsError").get("email")
                );
            }
        },

        /**
         * Sets value
         */
        setValue: function () {
            var value = this.getOption("value");

            switch (this.getOption("type")) {
                case "int":
                    value = this.getIntValue(value);
                    break;
                default:
                    break;
            }

            this.instance.val(value);
            return this;
        },

        /**
         * Gets int value
         *
         * @param {Number} value
         *
         * @returns {Number}
         */
        getIntValue: function(value) {
            return parseInt(value, 10) || 0;
        },

        /**
         * Gets value
         *
         * @returns {*}
         */
        getValue: function () {
            switch (this.getOption("type")) {
                case "int":
                    return this.getIntValue(this.instance.val());
                default:
                    return this.instance.val();
            }
        },

        /**
         * Sets error
         *
         * @param {String} error
         */
        setError: function (error) {
            this.form.addClass("error");
            this.form.find("span.error").text(error);

            return this;
        },

        /**
         * Does focus on instance
         */
        focus: function () {
            this.instance.focus();
            return this;
        },

        /**
         * Scrolls container to the form
         */
        scrollTo: function () {
            var scrollContainer = this.instance.closest(".scroll-container");
            var scrollTop = this.instance.position().top;
            var scrollTopContainer
                = scrollContainer.find("div:first-child").position().top;
            scrollContainer.scrollTop(scrollTop - scrollTopContainer);
            return this;
        },

        /**
         * Allows: backspace, delete, tab, escape, enter and .
         *
         * @param {Object} e
         *
         * @returns {Boolean}
         *
         * @private
         */
        isSystemKeyCode: function (e) {
            return $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1;
        },

        /**
         * Allows: Ctrl/cmd+A
         * Allows: Ctrl/cmd+C
         * Allows: Ctrl/cmd+X
         *
         * @param {Object} e
         *
         * @returns {Boolean}
         */
        isCopyPastKeyCode: function (e) {
            return (e.keyCode === 65
                    && (e.ctrlKey === true || e.metaKey === true)
                )
                || (e.keyCode === 67
                    && (e.ctrlKey === true || e.metaKey === true)
                )
                || (e.keyCode === 88
                    && (e.ctrlKey === true || e.metaKey === true)
                );
        },

        /**
         * Allows: home, end, left, right
         *
         * @param {Object} e
         *
         * @returns {Boolean}
         */
        isMoveKeyCode: function (e) {
            return e.keyCode >= 35 && e.keyCode <= 39;
        },

        /**
         * Ensures that it is a number and stop the keypress
         *
         * @param {Object} e
         *
         * @returns {Boolean}
         */
        isNotNumberKeyCode: function (e) {
            return (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57))
                && (e.keyCode < 96 || e.keyCode > 105);
        }
    }
);
