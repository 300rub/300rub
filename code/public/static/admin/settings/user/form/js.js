!function ($, ss) {
    "use strict";

    var name = "adminSettingsUserForm";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsWindowAbstract",

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
         * Form container
         *
         * @var {Object}
         */
        formContainer: null,

        /**
         * Operations container
         *
         * @var {object}
         */
        operationsContainer: null,

        /**
         * Operations tree
         *
         * @var {Array}
         */
        operationsTree: [],

        /**
         * Auto increment
         */
        autoIncrement: 1,

        /**
         * Init
         */
        init: function () {
            this.forms = {};
            this.formContainer = {};
            this.autoIncrement = 0;

            this.create(
                {
                    group: "user",
                    controller: "user",
                    data: {
                        id: this.getOption("id")
                    },
                    name: "users-form",
                    level: 2,
                    parent: "users"
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            var type = "PUT";
            if (this.getData("id", 0) === 0) {
                type = "POST";
            }

            this
                .setContainers()
                .setNameForm()
                .setLoginForm()
                .setPasswordForms()
                .setEmailForm()
                .setCanChangeOperations()
                .setSubmit(
                    {
                        label: this.getLabel("button"),
                        icon: "fas fa-user-check",
                        forms: this.forms,
                        ajax: {
                            data: {
                                group: "user",
                                controller: "user",
                                data: {
                                    id: this.getData("id")
                                }
                            },
                            type: type,
                            success: $.proxy(this.onSendSuccess, this)
                        }
                    }
                );
        },

        /**
         * Sets container
         */
        setContainers: function () {
            this.container = ss.init("template").get("users-form-container");
            this.formContainer = this.container.find(".text-forms-container");

            this.getBody().append(this.container);
            return this;
        },

        /**
         * Sets name form
         */
        setNameForm: function () {
            this.forms.name = ss.init(
                "commonComponentsFormText",
                $.extend(
                    {},
                    this.getData(["forms", "name"], {}),
                    {
                        appendTo: this.formContainer
                    }
                )
            );

            return this;
        },

        /**
         * Sets login form
         */
        setLoginForm: function () {
            this.forms.login = ss.init(
                "commonComponentsFormText",
                $.extend(
                    {},
                    this.getData(["forms", "login"], {}),
                    {
                        appendTo: this.formContainer
                    }
                )
            );

            return this;
        },

        /**
         * Sets password form
         */
        setPasswordForms: function () {
            var t = this;

            if (this.getData("id", 0) > 0) {
                this.forms.isChangePassword = ss.init(
                    "commonComponentsFormCheckbox",
                    {
                        appendTo: this.formContainer,
                        name: "isChangePassword",
                        value: false,
                        label: this.getLabel("isChangePassword"),
                        onCheck: function () {
                            t.forms.password.getForm()
                                .removeClass("hidden");
                            t.forms.passwordConfirm.getForm()
                                .removeClass("hidden");
                        },
                        onUnCheck: function () {
                            t.forms.password.getForm()
                                .addClass("hidden");
                            t.forms.passwordConfirm.getForm()
                                .addClass("hidden");
                        }
                    }
                );
            }

            this.forms.password = ss.init(
                "commonComponentsFormPassword",
                $.extend(
                    {},
                    this.getData(["forms", "password"], {}),
                    {
                        appendTo: this.formContainer
                    }
                )
            );

            this.forms.passwordConfirm = ss.init(
                "commonComponentsFormPassword",
                $.extend(
                    {},
                    this.getData(["forms", "passwordConfirm"], {}),
                    {
                        appendTo: this.formContainer
                    }
                )
            );

            if (this.getData("id", 0) > 0) {
                this.forms.password.getForm().addClass("hidden");
                this.forms.passwordConfirm.getForm().addClass("hidden");
            }

            return this;
        },

        /**
         * Sets email form
         */
        setEmailForm: function () {
            this.forms.email = ss.init(
                "commonComponentsFormText",
                $.extend(
                    {},
                    this.getData(["forms", "email"], {}),
                    {
                        appendTo: this.formContainer
                    }
                )
            );

            return this;
        },

        /**
         * Sets can change operations
         */
        setCanChangeOperations: function () {
            var t = this;

            if (this.getData(["operations", "canChange"]) === true) {
                var limitedValue = this.getData(["operations", "limitedId"]);
                var typeValue = this.getData(["forms", "type", "value"]);

                this.forms.type = ss.init(
                    "commonComponentsFormSelect",
                    $.extend(
                        {},
                        this.getData(["forms", "type"], {}),
                        {
                            appendTo: this.formContainer,
                            onChange: function (value) {
                                if (value === limitedValue) {
                                    t.operationsContainer.removeClass("hidden");
                                } else {
                                    t.operationsContainer.addClass("hidden");
                                }
                            }
                        }
                    )
                );

                this.setOperations();

                if (limitedValue === typeValue) {
                    this.operationsContainer.removeClass("hidden");
                }
            }

            return this;
        },

        /**
         * Sets operations
         */
        setOperations: function () {
            this.operationsContainer
                = this.container.find(".operations-container");

            this.operationsContainer.find(".group-title")
                .text(this.getLabel("operations"));

            this.operationsTree = [];

            this
                .setSectionOperations()
                .setBlockOperations()
                .setSettingsOperations();

            ss.init(
                "commonComponentsAccordion",
                {
                    tree: this.operationsTree,
                    container: this.operationsContainer
                }
            );
        },

        /**
         * Sets section operations
         */
        setSectionOperations: function () {
            var children = [];

            var all = this.getData(
                ["operations", "list", "SECTIONS", "data", "ALL"],
                {}
            );

            var allBody = $("<div/>");
            $.each(
                all.data,
                $.proxy(
                    function (key, formData) {
                        this.forms[this.autoIncrement] = ss.init(
                            "commonComponentsFormCheckboxOnOff",
                            $.extend(
                                {},
                                formData,
                                {
                                    appendTo: allBody
                                }
                            )
                        );
                        this.autoIncrement++;
                    },
                    this
                )
            );

            children.push(
                {
                    title: all.title,
                    body: allBody
                }
            );

            var t = this;

            $.each(
                this.getData(
                    ["operations", "list", "SECTIONS", "data"],
                    {}
                ),
                function (sectionId, sectionData) {
                    if (sectionId === "ALL") {
                        return true;
                    }

                    var body = $("<div/>");
                    $.each(
                        sectionData.data,
                        function (key, formData) {
                            t.forms[this.autoIncrement] = ss.init(
                                "commonComponentsFormCheckboxOnOff",
                                $.extend(
                                    {},
                                    formData,
                                    {
                                        appendTo: body
                                    }
                                )
                            );
                            t.autoIncrement++;
                        }
                    );

                    children.push(
                        {
                            title: sectionData.title,
                            body: body
                        }
                    );
                }
            );

            var title = this.getData(
                ["operations", "list", "SECTIONS", "title"]
            );

            this.operationsTree.push(
                {
                    title: title,
                    children: children
                }
            );

            return this;
        },

        /**
         * Sets block operations
         */
        setBlockOperations: function () {
            var children = [];

            var t = this;
            $.each(
                this.getData(
                    ["operations", "list", "BLOCKS", "data"]
                ),
                function (groupKey, typeData) {
                    var typeChildren = [];

                    var allBody = $("<div/>");
                    $.each(
                        typeData.data.ALL.data,
                        function (allKey, form) {
                            t.forms[this.autoIncrement] = ss.init(
                                "commonComponentsFormCheckboxOnOff",
                                $.extend(
                                    {},
                                    form,
                                    {
                                        appendTo: allBody
                                    }
                                )
                            );
                            t.autoIncrement++;
                        }
                    );

                    typeChildren.push(
                        {
                            title: typeData.data.ALL.title,
                            body: allBody
                        }
                    );

                    $.each(
                        typeData.data,
                        function (typeKey, data) {
                            if (typeKey === "ALL") {
                                return true;
                            }

                            var body = $("<div/>");

                            $.each(
                                data.data,
                                function (key, form) {
                                    t.forms[this.autoIncrement] = ss.init(
                                        "commonComponentsFormCheckboxOnOff",
                                        $.extend(
                                            {},
                                            form,
                                            {
                                                appendTo: body
                                            }
                                        )
                                    );
                                    t.autoIncrement++;
                                }
                            );

                            typeChildren.push(
                                {
                                    title: data.title,
                                    body: body
                                }
                            );
                        }
                    );

                    children.push(
                        {
                            title: typeData.title,
                            children: typeChildren
                        }
                    );
                }
            );

            this.operationsTree.push(
                {
                    title: this.getData(
                        ["operations", "list", "BLOCKS", "title"]
                    ),
                children: children
                }
            );

            return this;
        },

        /**
         * Sets settings operations
         */
        setSettingsOperations: function () {
            var body = $("<div/>");
            $.each(
                this.getData(
                    ["operations", "list", "SETTINGS", "data"],
                    {}
                ),
                $.proxy(
                    function (key, formData) {
                        this.forms[this.autoIncrement] = ss.init(
                            "commonComponentsFormCheckboxOnOff",
                            $.extend(
                                {},
                                formData,
                                {
                                    appendTo: body
                                }
                            )
                        );
                        this.autoIncrement++;
                    },
                    this
                )
            );

            this.operationsTree.push(
                {
                    title: this.getData(
                        ["operations", "list", "SETTINGS", "title"]
                    ),
                body: body
                }
            );

            return this;
        },

        /**
         * On send success
         *
         * @param {Object} data
         */
        onSendSuccess: function (data) {
            if ($.type(data.errors) === "object") {
                if (data.errors.name !== undefined) {
                    this.forms.name
                        .setError(data.errors.name)
                        .scrollTo()
                        .focus();
                } else if (data.errors.login !== undefined) {
                    this.forms.login
                        .setError(data.errors.login)
                        .scrollTo()
                        .focus();
                } else if (data.errors.email !== undefined) {
                    this.forms.email
                        .setError(data.errors.email)
                        .scrollTo()
                        .focus();
                } else if (data.errors.passwordConfirm !== undefined) {
                    this.forms.passwordConfirm
                        .setError(data.errors.passwordConfirm)
                        .scrollTo()
                        .focus();
                }
            } else {
                this.remove(true);
            }
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
