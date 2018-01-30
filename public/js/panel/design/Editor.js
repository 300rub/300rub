!function ($, TestS) {
    'use strict';

    /**
     * Panel design editor
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    TestS.Panel.Design.Editor = function (options) {
        TestS.Panel.Abstract.call(
            this,
            {
                group: options.group,
                controller: options.controller,
                id: options.id,
                success: $.proxy(this._onLoadDataSuccess, this)
            }
        );

        this._success = options.success;
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Design.Editor.prototype
        = Object.create(TestS.Panel.Abstract.prototype);

    /**
     * Constructor
     */
    TestS.Panel.Design.Editor.prototype.constructor
        = TestS.Panel.Design.Editor;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    TestS.Panel.Design.Editor.prototype._onLoadDataSuccess = function (
        data
    ) {
        var designs = [];
        var id = data.id;
        var group = data.group;
        var controller = data.controller;
        var buttonLabel = data.button.label;

        $.each(
            data.list,
            $.proxy(
                function (groupKey, groupData) {
                    var groupContainer = $("<div/>");
                    $.each(
                        groupData.data,
                        function (typeKey, typeData) {
                            var design;
                            switch (typeData.type) {
                                case "block":
                                    design = new TestS.Panel.Design.Block(
                                        typeData
                                    );
                                    break;
                                case "text":
                                    design = new TestS.Panel.Design.Text(
                                        typeData
                                    );
                                    break;
                                default:
                                    return false;
                            }

                            var typeAccordionElement
                                = new TestS.Components.Accordion.Element(
                                    typeData.title
                                );
                            typeAccordionElement.add(
                                design.getDesignContainer()
                            );

                            typeAccordionElement.appendTo(groupContainer);

                            designs.push(design);
                        }
                    );

                    if (data.list.length > 1) {
                        var groupAccordionElement
                            = new TestS.Components.Accordion.Element(
                                groupData.title
                            );
                        groupAccordionElement.add(groupContainer);
                        groupAccordionElement.appendTo(this.getBody());
                    } else {
                        groupContainer.appendTo(this.getBody());
                    }
                },
                this
            )
        );

        TestS.Components.Accordion.Container(this.getBody());

        this
            .setTitle(data.title)
            .setDescription(data.description)
            .setBack(
                function () {
                    new TestS.Panel.Blocks.Text.List();

                    $.each(
                        designs,
                        function (i, design) {
                            design.rollback();
                        }
                    );
                }
            )
            .setCloseEvents(
                function () {
                    $.each(
                        designs,
                        function (i, design) {
                            design.rollback();
                        }
                    );
                }
            )
            .setSubmit(
                {
                    label: buttonLabel,
                    icon: "fa-check",
                    ajax: {
                        data: {
                            group: group,
                            controller: controller,
                            data: function () {
                                var data = {
                                    id: id
                                };

                                $.each(
                                    designs,
                                    function (i, design) {
                                        data = $.extend(data, design.getData());
                                    }
                                );

                                return data;
                            }
                        },
                        type: "PUT",
                        success: this._success,
                        error: TestS.System.App.showError
                    }
                }
            );
    };
}(window.jQuery, window.TestS);
