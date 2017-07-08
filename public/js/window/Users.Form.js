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
            console.log(data);

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


                $operationsContainer.append(TestS.Accordion.getElement("title", $("<div/>").text("aaaaaaa")));

                $.each(data.operations.list, function(groupKey, groupObject) {
                    $("<h3/>").text(groupObject.title).appendTo($operationsContainer);

                    switch (groupKey) {
                        case "SECTIONS":
                            $("<h4/>").text(groupObject.data.ALL.title).appendTo($operationsContainer);
                            $.each(groupObject.data.ALL.data, function(allKey, allObject) {
                                new TestS.Form(
                                    $.extend(
                                        {
                                            appendTo: $operationsContainer,
                                            type: "checkbox"
                                        },
                                        allObject
                                    )
                                );
                            });

                            $.each(groupObject.data, function(groupObjectDataKey, groupObjectDataObject) {
                                if (groupObjectDataKey === "ALL") {
                                    return true;
                                }

                                $("<h4/>").text(groupObjectDataObject.title).appendTo($operationsContainer);
                                $.each(groupObjectDataObject.data, function(groupObjectDataObjectDataKey, groupObjectDataObjectDataObject) {
                                    new TestS.Form(
                                        $.extend(
                                            {
                                                appendTo: $operationsContainer,
                                                type: "checkbox"
                                            },
                                            groupObjectDataObjectDataObject
                                        )
                                    );
                                });
                            });

                            break;
                        case "SETTINGS":
                            $.each(groupObject.data, function(checkboxKey, checkboxObject) {
                                new TestS.Form(
                                    $.extend(
                                        {
                                            appendTo: $operationsContainer,
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
                });
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