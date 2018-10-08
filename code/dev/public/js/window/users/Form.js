!function ($, ss) {
    'use strict';

    /**
     * Sets operations
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.users.Form.prototype._setOperations = function (data) {
        this._operationsContainer
            = this._container.find(".operations-container");

        this._operationsContainer.find(".group-title")
            .text(data.labels.operations);

        $.each(
            data.operations.list,
            $.proxy(
                function (groupKey, groupObject) {
                    var categoryAccordionElement
                        = new ss.components.accordion.Element(
                            {
                                title: groupObject.title
                            }
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

        ss.components.accordion.Container(this._operationsContainer);
    };

    /**
     * Sets section operations
     *
     * @param {Object} [categoryAccordionElement]
     * @param {Object} [groupObject]
     *
     * @private
     */
    ss.window.users.Form.prototype._setSectionOperations = function (
        categoryAccordionElement,
        groupObject
    ) {
        var sectionsAllAccordionElement
            = new ss.components.accordion.Element(
                {
                    title: groupObject.data.ALL.title
                }
            );
        var t = this;

        $.each(
            groupObject.data.ALL.data,
            function (allKey, allObject) {
                var form = new ss.forms.Checkbox(
                    $.extend(
                        {},
                        allObject,
                        {
                            appendTo: sectionsAllAccordionElement.getBody()
                        }
                    )
                );
                t._forms.push(form);
            }
        );

        categoryAccordionElement.add(sectionsAllAccordionElement.get());

        $.each(
            groupObject.data,
            function (groupObjectDataKey, groupObjectDataObject) {
                if (groupObjectDataKey === "ALL") {
                    return true;
                }

                var sectionAccordionElement
                    = new ss.components.accordion.Element(
                        {
                            title: groupObjectDataObject.title
                        }
                    );

                $.each(
                    groupObjectDataObject.data,
                    function (
                        groupObjectDataObjectDataKey,
                        groupObjectDataObjectDataObject
                    ) {
                        var form = new ss.forms.Checkbox(
                            $.extend(
                                {},
                                groupObjectDataObjectDataObject,
                                {
                                    appendTo: sectionAccordionElement
                                        .getBody()
                                }
                            )
                        );
                        t._forms.push(form);
                    }
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
    ss.window.users.Form.prototype._setBlocksOperations = function (
        categoryAccordionElement,
        groupObject
    ) {
        var t = this;
        $.each(
            groupObject.data,
            function (groupObjectDataKey, groupObjectDataObject) {
                var blockTypeAccordionElement
                    = new ss.components.accordion.Element(
                        {
                            title: groupObjectDataObject.title
                        }
                    );
                var blockAllAccordionElement
                    = new ss.components.accordion.Element(
                        {
                            title: groupObjectDataObject.data.ALL.title
                        }
                    );

                $.each(
                    groupObjectDataObject.data.ALL.data,
                    function (allKey, allObject) {
                        var form = new ss.forms.Checkbox(
                            $.extend(
                                {},
                                allObject,
                                {
                                    appendTo: blockAllAccordionElement
                                        .getBody()
                                }
                            )
                        );
                        t._forms.push(form);
                    }
                );
                blockTypeAccordionElement.add(blockAllAccordionElement.get());

                $.each(
                    groupObjectDataObject.data,
                    function (
                        groupObjectDataObjectDataKey,
                        groupObjectDataObjectDataObject
                    ) {
                        if (groupObjectDataObjectDataKey === "ALL") {
                            return true;
                        }

                        var blockAccordionElement
                            = new ss.components.accordion.Element(
                                {
                                    title: groupObjectDataObjectDataObject.title
                                }
                            );

                        $.each(
                            groupObjectDataObjectDataObject.data,
                            function (key, object) {
                                var options = {
                                    appendTo: blockAccordionElement
                                        .getBody()
                                };

                                var form = new ss.forms.Checkbox(
                                    $.extend(
                                        {},
                                        object,
                                        options
                                    )
                                );

                                t._forms.push(form);
                            }
                        );

                        blockTypeAccordionElement.add(
                            blockAccordionElement.get()
                        );
                    }
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
    ss.window.users.Form.prototype._setSettingsOperations = function (
        categoryAccordionElement,
        groupObject
    ) {
        $.each(
            groupObject.data,
            $.proxy(
                function (checkboxKey, checkboxObject) {
                    var form = new ss.forms.Checkbox(
                        $.extend(
                            {},
                            checkboxObject,
                            {
                                appendTo: categoryAccordionElement.getBody()
                            }
                        )
                    );
                    this._forms.push(form);
                },
                this
            )
        );
    };
}(window.jQuery, window.ss);
