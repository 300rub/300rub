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
            var $container = TestS.Template.get("users-form-container");
            var textFormsContainer = $container.find(".text-forms-container");
            this._window.getBody().append($container);

            this._name = new TestS.Form(
                $.extend(
                    {
                        appendTo: textFormsContainer,
                        type: "text"
                    },
                    data.name
                )
            );

            this._login = new TestS.Form(
                $.extend(
                    {
                        appendTo: textFormsContainer,
                        type: "text"
                    },
                    data.login
                )
            );

            this._email = new TestS.Form(
                $.extend(
                    {
                        appendTo: textFormsContainer,
                        type: "text"
                    },
                    data.email
                )
            );

            if (data.operations.canChange === true) {
                this._type = new TestS.Form(
                    $.extend(
                        {
                            appendTo: textFormsContainer,
                            type: "select",
                            onChange: function () {
                                console.log($(this).val());
                            }
                        },
                        data.type
                    )
                );

                var $operationsContainer = $container.find(".operations-container");

                $operationsContainer.find(".group-title").text(data.operations.title);

                $.each(data.operations.list, function(groupKey, groupObject) {
                    var categoryAccordionElement = new TestS.Accordion.Element(groupObject.title);

                    switch (groupKey) {
                        case "SECTIONS":
                            var sectionsAllAccordionElement = new TestS.Accordion.Element(groupObject.data.ALL.title);

                            $.each(groupObject.data.ALL.data, function(allKey, allObject) {
                                new TestS.Form(
                                    $.extend(
                                        {
                                            appendTo: sectionsAllAccordionElement.getBody(),
                                            type: "checkbox"
                                        },
                                        allObject
                                    )
                                );
                            });

                            categoryAccordionElement.add(sectionsAllAccordionElement.get());

                            $.each(groupObject.data, function(groupObjectDataKey, groupObjectDataObject) {
                                if (groupObjectDataKey === "ALL") {
                                    return true;
                                }

                                var sectionAccordionElement = new TestS.Accordion.Element(groupObjectDataObject.title);

                                $.each(groupObjectDataObject.data, function(groupObjectDataObjectDataKey, groupObjectDataObjectDataObject) {
                                    new TestS.Form(
                                        $.extend(
                                            {
                                                appendTo: sectionAccordionElement.getBody(),
                                                type: "checkbox"
                                            },
                                            groupObjectDataObjectDataObject
                                        )
                                    );
                                });

                                categoryAccordionElement.add(sectionAccordionElement.get());
                            });

                            break;
                        case "BLOCKS":
                            $.each(groupObject.data, function(groupObjectDataKey, groupObjectDataObject) {
                                var blockTypeAccordionElement = new TestS.Accordion.Element(groupObjectDataObject.title);
                                var blockAllAccordionElement = new TestS.Accordion.Element(groupObjectDataObject.data.ALL.title);

                                $.each(groupObjectDataObject.data.ALL.data, function(allKey, allObject) {
                                    new TestS.Form(
                                        $.extend(
                                            {
                                                appendTo: blockAllAccordionElement.getBody(),
                                                type: "checkbox"
                                            },
                                            allObject
                                        )
                                    );
                                });
                                blockTypeAccordionElement.add(blockAllAccordionElement.get());

                                $.each(groupObjectDataObject.data, function(groupObjectDataObjectDataKey, groupObjectDataObjectDataObject) {
                                    if (groupObjectDataObjectDataKey === "ALL") {
                                        return true;
                                    }

                                    var blockAccordionElement = new TestS.Accordion.Element(groupObjectDataObjectDataObject.title);

                                    $.each(groupObjectDataObjectDataObject.data, function(key, object) {
                                        new TestS.Form(
                                            $.extend(
                                                {
                                                    appendTo: blockAccordionElement.getBody(),
                                                    type: "checkbox"
                                                },
                                                object
                                            )
                                        );
                                    });

                                    blockTypeAccordionElement.add(blockAccordionElement.get());
                                });

                                categoryAccordionElement.add(blockTypeAccordionElement.get());
                            });

                            break;
                        case "SETTINGS":
                            $.each(groupObject.data, function(checkboxKey, checkboxObject) {
                                new TestS.Form(
                                    $.extend(
                                        {
                                            appendTo: categoryAccordionElement.getBody(),
                                            type: "checkbox"
                                        },
                                        checkboxObject
                                    )
                                );
                            });
                            break;
                        default:
                            break;
                    }

                    categoryAccordionElement.appendTo($operationsContainer)
                });

                TestS.Accordion($operationsContainer);
            }

            this._window
                .setTitle(data.title)
                .setSubmit({
                    type: "button",
                    label: data.button.label,
                    icon: "fa-check",
                    forms: [this._name, this._login, this._email],
                    ajax: {
                        data: {
                            controller: data.button.controller,
                            action: data.button.action
                        },
                        type: "PUT",
                        // success: $.proxy(this._onSuccess, this),
                        error: $.proxy(this._window.onError, this._window)
                    }
                })
                .removeLoading();
        }
    };
}(window.jQuery, window.TestS);