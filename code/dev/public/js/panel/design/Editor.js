!function ($, ss) {
    'use strict';

    /**
     * Panel design editor
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    ss.panel.design.Editor = function (options) {
        ss.panel.Abstract.call(
            this,
            {
                group: options.group,
                controller: options.controller,
                id: options.id,
                success: $.proxy(this._onLoadDataSuccess, this)
            }
        );

        this._success = options.success;
        this._designs = [];
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.panel.design.Editor.prototype
        = Object.create(ss.panel.Abstract.prototype);

    /**
     * Constructor
     */
    ss.panel.design.Editor.prototype.constructor
        = ss.panel.design.Editor;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.panel.design.Editor.prototype._onLoadDataSuccess = function (
        data
    ) {
        $.each(
            data.list,
            $.proxy(
                this._displayGroup,
                this
            )
        );

        ss.components.accordion.Container(this.getBody());

        this
            .setTitle(data.title)
            .setDescription(data.description)
            .setBack(
                function () {
                    new ss.panel.blocks.text.List();

                    $.each(
                        this._designs,
                        function (i, design) {
                            design.rollback();
                        }
                    );
                }
            )
            .setCloseEvents(
                function () {
                    $.each(
                        this._designs,
                        function (i, design) {
                            design.rollback();
                        }
                    );
                }
            )
            .setSubmit(
                {
                    label: data.button.label,
                    icon: "fa-check",
                    ajax: {
                        data: {
                            group: data.group,
                            controller: data.controller,
                            data: $.proxy(
                                function () {
                                    var dataObject = {
                                        id: data.id
                                    };

                                    $.each(
                                        this._designs,
                                        function (i, design) {
                                            dataObject = $.extend(
                                                dataObject,
                                                design.getData()
                                            );
                                        }
                                    );

                                    return dataObject;
                                },
                                this
                            )
                        },
                        type: "PUT",
                        success: this._success,
                        error: ss.system.App.showError
                    }
                }
            );
    };

    /**
     * Displays group
     *
     * @param {String} groupKey
     * @param {Object} groupData
     *
     * @private
     */
    ss.panel.design.Editor.prototype._displayGroup = function (
        groupKey,
        groupData
    ) {
        var groupContainer = $("<div/>");
        $.each(
            groupData.data,
            $.proxy(
                function (typeKey, options) {
                    var design;
                    switch (options.type) {
                        case "block":
                            design = new ss.panel.design.block.Editor(
                                options
                            );
                            break;
                        case "text":
                            design = new ss.panel.design.text.Editor(
                                options
                            );
                            break;
                        default:
                            return false;
                    }

                    var typeAccordionElement
                        = new ss.components.accordion.Element(
                            options.title
                        );
                    typeAccordionElement.add(
                        design.getDesignContainer()
                    );

                    typeAccordionElement.appendTo(groupContainer);

                    this._designs.push(design);
                },
                this
            )
        );

        if (this._designs.length > 1) {
            var groupAccordionElement
                = new ss.components.accordion.Element(
                    groupData.title
                );
            groupAccordionElement.add(groupContainer);
            groupAccordionElement.appendTo(this.getBody());
        } else {
            groupContainer.appendTo(this.getBody());
        }
    };
}(window.jQuery, window.ss);
