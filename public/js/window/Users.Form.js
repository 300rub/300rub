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
        this._options = $.extend({}, options);
        this.$_container = null;
        this.$_operationsContainer = null;
        this._window = null;
        this._nameForm = null;
        this._loginForm = null;
        this._emailForm = null;
        this._passwordForm = null;
        this._passwordConfirmForm = null;
        this._forms = [];

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Window.Users.Form.prototype = {
        /**
         * Init
         */
        init: function () {
            this._window = new TestS.Window({
                group: "user",
                controller: "user",
                data: {
                    id: this._options.id
                },
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "users-form",
                level: 2,
                parent: "users"
            });
        },

        /**
         * On load window success
         *
         * @param {Object} [data]
         *
         * @private
         */
        _onLoadDataSuccess: function (data) {
            this.$_container = TestS.Components.Template.get("users-form-container");

            this._window.getBody().append(this.$_container);

            this._setForms(data);

            this._window
                .setTitle(data.title)
                .setSubmit({
                    label: data.button.label,
                    icon: "fa-check",
                    forms: this._forms,
                    ajax: {
                        data: {
                            group: "user",
                            controller: "user"
                        },
                        type: data.id === 0 ? "POST" : "PUT",
                        success: $.proxy(this._onSuccess, this),
                        error: $.proxy(this._window.onError, this._window)
                    }
                })
                .removeLoading();
        },

        /**
         * On submit success event
         *
         * @param {Object} data
         *
         * @private
         */
        _onSuccess: function (data) {
            if ($.type(data.errors) === "object") {
                if (data.errors["name"] !== undefined) {
                    this._nameForm
                        .setError(data.errors["name"])
                        .scrollTo()
                        .focus();
                } else if (data.errors["login"] !== undefined) {
                    this._loginForm
                        .setError(data.errors["login"])
                        .scrollTo()
                        .focus();
                } else if (data.errors["email"] !== undefined) {
                    this._emailForm
                        .setError(data.errors["email"])
                        .scrollTo()
                        .focus();
                } else if (data.errors["passwordConfirm"] !== undefined) {
                    this._passwordConfirmForm
                        .setError(data.errors["passwordConfirm"])
                        .scrollTo()
                        .focus();
                }
            } else {
                this._window.remove(true);
            }
        },

        /**
         * Sets forms
         *
         * @param {Object} data
         *
         * @returns {TestS.Window.Users.Form}
         *
         * @private
         */
        _setForms: function (data) {
            var $textFormsContainer = this.$_container.find(".text-forms-container");
            var t = this;

            var idForm = new TestS.Form.Hidden({
                appendTo: $textFormsContainer,
                name: "id",
                value: data.id
            });
            this._forms.push(idForm);

            this._nameForm = new TestS.Form.Text(
                $.extend(
                    {
                        appendTo: $textFormsContainer
                    },
                    data.name
                )
            );
            this._forms.push(this._nameForm);

            this._loginForm = new TestS.Form.Text(
                $.extend(
                    {
                        appendTo: $textFormsContainer
                    },
                    data.login
                )
            );
            this._forms.push(this._loginForm);

            if (data.id !== 0) {
                var isChangePassword = new TestS.Form.Checkbox({
                    appendTo: $textFormsContainer,
                    name: "isChangePassword",
                    value: false,
                    label: data.labels["isChangePassword"],
                    onCheck: function() {
                        t._passwordForm.getInstance().removeClass("hidden");
                        t._passwordConfirmForm.getInstance().removeClass("hidden");
                    },
                    onUnCheck: function() {
                        t._passwordForm.getInstance().addClass("hidden");
                        t._passwordConfirmForm.getInstance().addClass("hidden");
                    }
                });
                this._forms.push(isChangePassword);
            }

            this._passwordForm = new TestS.Form.Password(
                $.extend(
                    {
                        appendTo: $textFormsContainer
                    },
                    data.password
                )
            );
            this._forms.push(this._passwordForm);

            this._passwordConfirmForm = new TestS.Form.Password(
                $.extend(
                    {
                        appendTo: $textFormsContainer
                    },
                    data["passwordConfirm"]
                )
            );
            this._forms.push(this._passwordConfirmForm);

            if (data.id !== 0) {
                t._passwordForm.getInstance().addClass("hidden");
                t._passwordConfirmForm.getInstance().addClass("hidden");
            }

            this._emailForm = new TestS.Form.Text(
                $.extend(
                    {
                        appendTo: $textFormsContainer
                    },
                    data.email
                )
            );
            this._forms.push(this._emailForm);

            if (data.operations["canChange"] === true) {
                var typeForm = new TestS.Form.Select(
                    $.extend(
                        {
                            appendTo: $textFormsContainer,
                            onChange: function (value) {
                                if (value === data.operations["limitedId"]) {
                                    t.$_operationsContainer.removeClass("hidden");
                                } else {
                                    t.$_operationsContainer.addClass("hidden");
                                }
                            }
                        },
                        data.type
                    )
                );
                this._forms.push(typeForm);

                this._setOperations(data);

                if (data.operations["limitedId"] === data.type.value) {
                    this.$_operationsContainer.removeClass("hidden");
                }
            }

            return this;
        },

        /**
         * Sets operations
         *
         * @param {Object} data
         *
         * @private
         */
        _setOperations: function (data) {
            var t = this;
            this.$_operationsContainer = this.$_container.find(".operations-container");

            this.$_operationsContainer.find(".group-title").text(data.labels.operations);

            $.each(data.operations.list, function (groupKey, groupObject) {
                var categoryAccordionElement = new TestS.Components.Accordion.Element(groupObject.title);

                switch (groupKey) {
                    case "SECTIONS":
                        var sectionsAllAccordionElement = new TestS.Components.Accordion.Element(groupObject.data.ALL.title);

                        $.each(groupObject.data.ALL.data, function (allKey, allObject) {
                            var form = new TestS.Form.Checkbox(
                                $.extend(
                                    {
                                        appendTo: sectionsAllAccordionElement.getBody()
                                    },
                                    allObject
                                )
                            );
                            t._forms.push(form);
                        });

                        categoryAccordionElement.add(sectionsAllAccordionElement.get());

                        $.each(groupObject.data, function (groupObjectDataKey, groupObjectDataObject) {
                            if (groupObjectDataKey === "ALL") {
                                return true;
                            }

                            var sectionAccordionElement = new TestS.Components.Accordion.Element(groupObjectDataObject.title);

                            $.each(
                                groupObjectDataObject.data,
                                function (groupObjectDataObjectDataKey, groupObjectDataObjectDataObject) {
                                    var form = new TestS.Form.Checkbox(
                                        $.extend(
                                            {
                                                appendTo: sectionAccordionElement.getBody()
                                            },
                                            groupObjectDataObjectDataObject
                                        )
                                    );
                                    t._forms.push(form);
                                }
                            );

                            categoryAccordionElement.add(sectionAccordionElement.get());
                        });

                        break;
                    case "BLOCKS":
                        $.each(groupObject.data, function (groupObjectDataKey, groupObjectDataObject) {
                            var blockTypeAccordionElement
                                = new TestS.Components.Accordion.Element(groupObjectDataObject.title);
                            var blockAllAccordionElement
                                = new TestS.Components.Accordion.Element(groupObjectDataObject.data.ALL.title);

                            $.each(groupObjectDataObject.data.ALL.data, function (allKey, allObject) {
                                var form = new TestS.Form.Checkbox(
                                    $.extend(
                                        {
                                            appendTo: blockAllAccordionElement.getBody()
                                        },
                                        allObject
                                    )
                                );
                                t._forms.push(form);
                            });
                            blockTypeAccordionElement.add(blockAllAccordionElement.get());

                            $.each(
                                groupObjectDataObject.data,
                                function (groupObjectDataObjectDataKey, groupObjectDataObjectDataObject) {
                                    if (groupObjectDataObjectDataKey === "ALL") {
                                        return true;
                                    }

                                    var blockAccordionElement
                                        = new TestS.Components.Accordion.Element(groupObjectDataObjectDataObject.title);

                                    $.each(groupObjectDataObjectDataObject.data, function (key, object) {
                                        var form = new TestS.Form.Checkbox(
                                            $.extend(
                                                {
                                                    appendTo: blockAccordionElement.getBody()
                                                },
                                                object
                                            )
                                        );
                                        t._forms.push(form);
                                    });

                                    blockTypeAccordionElement.add(blockAccordionElement.get());
                                }
                            );

                            categoryAccordionElement.add(blockTypeAccordionElement.get());
                        });

                        break;
                    case "SETTINGS":
                        $.each(groupObject.data, function (checkboxKey, checkboxObject) {
                            var form = new TestS.Form.Checkbox(
                                $.extend(
                                    {
                                        appendTo: categoryAccordionElement.getBody()
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

            TestS.Components.Accordion.Container(this.$_operationsContainer);
        }
    };
}(window.jQuery, window.TestS);