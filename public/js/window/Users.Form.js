!function ($, TestS) {
    'use strict';

    /**
     * Users form window
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    TestS.Window.Users.Form = function (options) {
        this._options = options;
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Window.Users.Form.prototype = {

        /**
         * @type {Window.TestS.Window}
         */
        _window: null,

        /**
         * @type {Object}
         */
        _options: {},

        /**
         * Name
         *
         * @var {Object}
         */
        _name: null,

        /**
         * Login
         *
         * @var {Object}
         */
        _login: null,

        /**
         * Email
         *
         * @var {Object}
         */
        _email: null,

        /**
         * Type
         *
         * @var {Object}
         */
        _type: null,

        /**
         * Container
         *
         * @var {Object}
         */
        $_container: null,

        /**
         * Operations container
         *
         * @var {Object}
         */
        $_operationsContainer: null,

        /**
         * Forms
         *
         * @var Array
         */
        _forms: [],

        /**
         * Init
         */
        init: function () {
            this._window = new TestS.Window({
                controller: "user",
                action: "user",
                data: {
                    id: this._options.id
                },
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "users-form",
                level: 2,
                parent: {
                    name:"users",
                    isHide: true
                }
            });
        },

        /**
         * On load window success
         *
         * @param {Object} [data]
         *
         * @private
         */
        _onLoadDataSuccess: function(data) {
            this.$_container = TestS.Template.get("users-form-container");
            var $textFormsContainer = this.$_container.find(".text-forms-container");
            this._window.getBody().append(this.$_container);
            var t = this;

            var idForm = new TestS.Form({
                appendTo: $textFormsContainer,
                type: "hidden",
                name: "id",
                value: data.id
            });
            this._forms.push(idForm);

            this._name = new TestS.Form(
                $.extend(
                    {
                        appendTo: $textFormsContainer,
                        type: "text"
                    },
                    data.name
                )
            );
            this._forms.push(this._name);

            this._login = new TestS.Form(
                $.extend(
                    {
                        appendTo: $textFormsContainer,
                        type: "text"
                    },
                    data.login
                )
            );
            this._forms.push(this._login);

            if (data.id !== 0) {
                var isChangePassword = new TestS.Form({
                    appendTo: $textFormsContainer,
                    type: "checkbox",
                    name: "isChangePassword",
                    value: false,
                    label: data.labels.isChangePassword
                });
                this._forms.push(isChangePassword);
            }

            this._email = new TestS.Form(
                $.extend(
                    {
                        appendTo: $textFormsContainer,
                        type: "text"
                    },
                    data.email
                )
            );
            this._forms.push(this._email);

            if (data.operations.canChange === true) {
                this._type = new TestS.Form(
                    $.extend(
                        {
                            appendTo: $textFormsContainer,
                            type: "select",
                            onChange: function () {
                                if (parseInt($(this).val()) === data.operations.limitedId) {
                                    t.$_operationsContainer.removeClass("hidden");
                                } else {
                                    t.$_operationsContainer.addClass("hidden");
                                }
                            }
                        },
                        data.type
                    )
                );
                this._forms.push(this._type);

                this._setOperations(data);

                if (data.operations.limitedId === data.type.value) {
                    this.$_operationsContainer.removeClass("hidden");
                }
            }

            this._window
                .setTitle(data.title)
                .setSubmit({
                    type: "button",
                    label: data.button.label,
                    icon: "fa-check",
                    forms: this._forms,
                    ajax: {
                        data: {
                            controller: "user",
                            action: "user"
                        },
                        type: data.id === 0 ? "PUT" : "POST",
                        success: $.proxy(this._onSuccess, this),
                        error: $.proxy(this._window.onError, this._window)
                    }
                })
                .removeLoading();
        },

        _onSuccess: function (data) {
            console.log(data);
        },

        /**
         * Sets operations
         *
         * @param {Object} data
         *
         * @private
         */
        _setOperations: function(data) {
            var t = this;
            this.$_operationsContainer = this.$_container.find(".operations-container");

            this.$_operationsContainer.find(".group-title").text(data.labels.operations);

            $.each(data.operations.list, function(groupKey, groupObject) {
                var categoryAccordionElement = new TestS.Accordion.Element(groupObject.title);

                switch (groupKey) {
                    case "SECTIONS":
                        var sectionsAllAccordionElement = new TestS.Accordion.Element(groupObject.data.ALL.title);

                        $.each(groupObject.data.ALL.data, function(allKey, allObject) {
                            var form = new TestS.Form(
                                $.extend(
                                    {
                                        appendTo: sectionsAllAccordionElement.getBody(),
                                        type: "checkbox"
                                    },
                                    allObject
                                )
                            );
                            t._forms.push(form);
                        });

                        categoryAccordionElement.add(sectionsAllAccordionElement.get());

                        $.each(groupObject.data, function(groupObjectDataKey, groupObjectDataObject) {
                            if (groupObjectDataKey === "ALL") {
                                return true;
                            }

                            var sectionAccordionElement = new TestS.Accordion.Element(groupObjectDataObject.title);

                            $.each(groupObjectDataObject.data, function(groupObjectDataObjectDataKey, groupObjectDataObjectDataObject) {
                                var form = new TestS.Form(
                                    $.extend(
                                        {
                                            appendTo: sectionAccordionElement.getBody(),
                                            type: "checkbox"
                                        },
                                        groupObjectDataObjectDataObject
                                    )
                                );
                                t._forms.push(form);
                            });

                            categoryAccordionElement.add(sectionAccordionElement.get());
                        });

                        break;
                    case "BLOCKS":
                        $.each(groupObject.data, function(groupObjectDataKey, groupObjectDataObject) {
                            var blockTypeAccordionElement = new TestS.Accordion.Element(groupObjectDataObject.title);
                            var blockAllAccordionElement = new TestS.Accordion.Element(groupObjectDataObject.data.ALL.title);

                            $.each(groupObjectDataObject.data.ALL.data, function(allKey, allObject) {
                                var form = new TestS.Form(
                                    $.extend(
                                        {
                                            appendTo: blockAllAccordionElement.getBody(),
                                            type: "checkbox"
                                        },
                                        allObject
                                    )
                                );
                                t._forms.push(form);
                            });
                            blockTypeAccordionElement.add(blockAllAccordionElement.get());

                            $.each(groupObjectDataObject.data, function(groupObjectDataObjectDataKey, groupObjectDataObjectDataObject) {
                                if (groupObjectDataObjectDataKey === "ALL") {
                                    return true;
                                }

                                var blockAccordionElement = new TestS.Accordion.Element(groupObjectDataObjectDataObject.title);

                                $.each(groupObjectDataObjectDataObject.data, function(key, object) {
                                    var form = new TestS.Form(
                                        $.extend(
                                            {
                                                appendTo: blockAccordionElement.getBody(),
                                                type: "checkbox"
                                            },
                                            object
                                        )
                                    );
                                    t._forms.push(form);
                                });

                                blockTypeAccordionElement.add(blockAccordionElement.get());
                            });

                            categoryAccordionElement.add(blockTypeAccordionElement.get());
                        });

                        break;
                    case "SETTINGS":
                        $.each(groupObject.data, function(checkboxKey, checkboxObject) {
                            var form = new TestS.Form(
                                $.extend(
                                    {
                                        appendTo: categoryAccordionElement.getBody(),
                                        type: "checkbox"
                                    },
                                    checkboxObject
                                )
                            );
                            t._forms.push(form);
                        });
                        break;
                    default:
                        break;
                }

                categoryAccordionElement.appendTo(t.$_operationsContainer)
            });

            TestS.Accordion(this.$_operationsContainer);
        }
    };
}(window.jQuery, window.TestS);