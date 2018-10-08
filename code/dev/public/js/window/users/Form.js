!function ($, ss) {
    'use strict';



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
