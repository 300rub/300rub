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
        TestS.Window.Abstract.call(
            this,
            {
                group: "user",
                controller: "user",
                data: {
                    id: options.id
                },
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "users-form",
                level: 2,
                parent: "users"
            }
        );

        this._container = null;
        this._operationsContainer = null;
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
    TestS.Window.Users.Form.prototype
        = Object.create(TestS.Window.Abstract.prototype);

    /**
     * Constructor
     */
    TestS.Window.Users.Form.prototype.constructor = TestS.Window.Users.Form;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    TestS.Window.Users.Form.prototype._onLoadDataSuccess = function (data) {
        this._container = TestS.Components.Template.get("users-form-container");

        this.getBody().append(this._container);

        this._setForms(data);

        var type = "PUT";
        if (data.id === 0) {
            type = "POST";
        }

        this
            .setTitle(data.title)
            .setSubmit(
                {
                    label: data.button.label,
                    icon: "fa-check",
                    forms: this._forms,
                    ajax: {
                        data: {
                            group: "user",
                            controller: "user"
                        },
                        type: type,
                        success: $.proxy(this._onSuccess, this),
                        error: $.proxy(this.onError, this)
                    }
                }
            );
    };

    /**
     * On send success
     *
     * @param {Object} [data]
     *
     * @private
     */
    TestS.Window.Users.Form.prototype._onSendSuccess = function (data) {
        if ($.type(data.errors) === "object") {
            if (data.errors.name !== undefined) {
                this._nameForm
                    .setError(data.errors.name)
                    .scrollTo()
                    .focus();
            } else if (data.errors.login !== undefined) {
                this._loginForm
                    .setError(data.errors.login)
                    .scrollTo()
                    .focus();
            } else if (data.errors.email !== undefined) {
                this._emailForm
                    .setError(data.errors.email)
                    .scrollTo()
                    .focus();
            } else if (data.errors.passwordConfirm !== undefined) {
                this._passwordConfirmForm
                    .setError(data.errors.passwordConfirm)
                    .scrollTo()
                    .focus();
            }
        } else {
            this.remove(true);
        }
    };

    /**
     * Sets forms
     *
     * @param {Object} [data]
     *
     * @returns {TestS.Window.Users.Form}
     *
     * @private
     */
    TestS.Window.Users.Form.prototype._setForms = function (data) {
        var $textFormsContainer = this._container.find(".text-forms-container");
        var t = this;

        var idForm = new TestS.Form.Hidden(
            {
                appendTo: $textFormsContainer,
                name: "id",
                value: data.id
            }
        );
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
            var isChangePassword = new TestS.Form.Checkbox(
                {
                    appendTo: $textFormsContainer,
                    name: "isChangePassword",
                    value: false,
                    label: data.labels.isChangePassword,
                    onCheck: function () {
                        t._passwordForm.getInstance()
                            .removeClass("hidden");
                        t._passwordConfirmForm.getInstance()
                            .removeClass("hidden");
                    },
                    onUnCheck: function () {
                        t._passwordForm.getInstance()
                            .addClass("hidden");
                        t._passwordConfirmForm.getInstance()
                            .addClass("hidden");
                    }
                }
            );
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
                data.passwordConfirm
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

        if (data.operations.canChange === true) {
            var typeForm = new TestS.Form.Select(
                $.extend(
                    {
                        appendTo: $textFormsContainer,
                        onChange: function (value) {
                            if (value === data.operations.limitedId) {
                                t._operationsContainer.removeClass("hidden");
                            } else {
                                t._operationsContainer.addClass("hidden");
                            }
                        }
                    },
                    data.type
                )
            );
            this._forms.push(typeForm);

            this._setOperations(data);

            if (data.operations.limitedId === data.type.value) {
                this._operationsContainer.removeClass("hidden");
            }
        }

        return this;
    };

    /**
     * Sets operations
     *
     * @param {Object} [data]
     *
     * @private
     */
    TestS.Window.Users.Form.prototype._setOperations = function (data) {
        this._operationsContainer
            = this._container.find(".operations-container");

        this._operationsContainer.find(".group-title")
            .text(data.labels.operations);

        $.each(
            data.operations.list,
            $.proxy(
                function (groupKey, groupObject) {
                    var categoryAccordionElement
                        = new TestS.Components.Accordion.Element(
                            groupObject.title
                        );

                    switch (groupKey) {
                        case "SECTIONS":
                            this._setSectionOperations(
                                categoryAccordionElement,
                                groupObject
                            );

                            break;
                        case "BLOCKS":
                            this._setBlocksOperations(
                                categoryAccordionElement,
                                groupObject
                            );

                            break;
                        case "SETTINGS":
                            this._setSettingsOperations(
                                categoryAccordionElement,
                                groupObject
                            );

                            break;
                        default:
                            break;
                    }

                    categoryAccordionElement.appendTo(
                        this._operationsContainer
                    );
                },
                this
            )
        );

        TestS.Components.Accordion.Container(this._operationsContainer);
    };

    /**
     * Sets section operations
     *
     * @param {Object} [categoryAccordionElement]
     * @param {Object} [groupObject]
     *
     * @private
     */
    TestS.Window.Users.Form.prototype._setSectionOperations = function (
        categoryAccordionElement,
        groupObject
    ) {
        var sectionsAllAccordionElement
            = new TestS.Components.Accordion.Element(
                groupObject.data.ALL.title
            );

        $.each(
            groupObject.data.ALL.data,
            $.proxy(
                function (allKey, allObject) {
                    var form = new TestS.Form.Checkbox(
                        $.extend(
                            {
                                appendTo: sectionsAllAccordionElement.getBody()
                            },
                            allObject
                        )
                    );
                    this._forms.push(form);
                },
                this
            )
        );

        categoryAccordionElement.add(sectionsAllAccordionElement.get());

        $.each(
            groupObject.data,
            function (groupObjectDataKey, groupObjectDataObject) {
                if (groupObjectDataKey === "ALL") {
                    return true;
                }

                var sectionAccordionElement
                    = new TestS.Components.Accordion.Element(
                        groupObjectDataObject.title
                    );

                $.each(
                    groupObjectDataObject.data,
                    $.proxy(
                        function (
                            groupObjectDataObjectDataKey,
                            groupObjectDataObjectDataObject
                        ) {
                            var form = new TestS.Form.Checkbox(
                                $.extend(
                                    {
                                        appendTo: sectionAccordionElement
                                            .getBody()
                                    },
                                    groupObjectDataObjectDataObject
                                )
                            );
                            this._forms.push(form);
                        },
                        this
                    )
                );

                categoryAccordionElement.add(sectionAccordionElement.get());
            }
        );
    };

    /**
     * Sets blocks operations
     *
     * @param {Object} [categoryAccordionElement]
     * @param {Object} [groupObject]
     *
     * @private
     */
    TestS.Window.Users.Form.prototype._setBlocksOperations = function (
        categoryAccordionElement,
        groupObject
    ) {
        $.each(
            groupObject.data,
            function (groupObjectDataKey, groupObjectDataObject) {
                var blockTypeAccordionElement
                    = new TestS.Components.Accordion.Element(
                        groupObjectDataObject.title
                    );
                var blockAllAccordionElement
                    = new TestS.Components.Accordion.Element(
                        groupObjectDataObject.data.ALL.title
                    );

                $.each(
                    groupObjectDataObject.data.ALL.data,
                    $.proxy(
                        function (allKey, allObject) {
                            var form = new TestS.Form.Checkbox(
                                $.extend(
                                    {
                                        appendTo: blockAllAccordionElement
                                            .getBody()
                                    },
                                    allObject
                                )
                            );
                            this._forms.push(form);
                        },
                        this
                    )
                );
                blockTypeAccordionElement.add(blockAllAccordionElement.get());

                $.each(
                    groupObjectDataObject.data,
                    $.proxy(
                        function (
                            groupObjectDataObjectDataKey,
                            groupObjectDataObjectDataObject
                        ) {
                            if (groupObjectDataObjectDataKey === "ALL") {
                                return true;
                            }

                            var blockAccordionElement
                                = new TestS.Components.Accordion.Element(
                                    groupObjectDataObjectDataObject.title
                                );

                            $.each(
                                groupObjectDataObjectDataObject.data,
                                $.proxy(
                                    function (key, object) {
                                        var options = {
                                            appendTo: blockAccordionElement
                                                .getBody()
                                        };

                                        var form = new TestS.Form.Checkbox(
                                            $.extend(
                                                options,
                                                object
                                            )
                                        );

                                        this._forms.push(form);
                                    },
                                    this
                                )
                            );

                            blockTypeAccordionElement.add(
                                blockAccordionElement.get()
                            );
                        },
                        this
                    )
                );

                categoryAccordionElement.add(blockTypeAccordionElement.get());
            }
        );
    };

    /**
     * Sets settings operations
     *
     * @param {Object} [categoryAccordionElement]
     * @param {Object} [groupObject]
     *
     * @private
     */
    TestS.Window.Users.Form.prototype._setSettingsOperations = function (
        categoryAccordionElement,
        groupObject
    ) {
        $.each(
            groupObject.data,
            $.proxy(
                function (checkboxKey, checkboxObject) {
                    var form = new TestS.Form.Checkbox(
                        $.extend(
                            {
                                appendTo: categoryAccordionElement.getBody()
                            },
                            checkboxObject
                        )
                    );
                    this._forms.push(form);
                },
                this
            )
        );
    };
}(window.jQuery, window.TestS);
