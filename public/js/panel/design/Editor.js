!function ($, Ss) {
    'use strict';

    /**
     * Panel design editor
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    Ss.Panel.Design.Editor = function (options) {
        Ss.Panel.Abstract.call(
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
    Ss.Panel.Design.Editor.prototype
        = Object.create(Ss.Panel.Abstract.prototype);

    /**
     * Constructor
     */
    Ss.Panel.Design.Editor.prototype.constructor
        = Ss.Panel.Design.Editor;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    Ss.Panel.Design.Editor.prototype._onLoadDataSuccess = function (
        data
    ) {
        $.each(
            data.list,
            $.proxy(
                this._displayGroup,
                this
            )
        );

        Ss.Components.Accordion.Container(this.getBody());

        this
            .setTitle(data.title)
            .setDescription(data.description)
            .setBack(
                function () {
                    new Ss.Panel.Blocks.Text.List();

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
                            data: function () {
                                var data = {
                                    id: data.id
                                };

                                $.each(
                                    this._designs,
                                    function (i, design) {
                                        data = $.extend(data, design.getData());
                                    }
                                );

                                return data;
                            }
                        },
                        type: "PUT",
                        success: this._success,
                        error: Ss.System.App.showError
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
    Ss.Panel.Design.Editor.prototype._displayGroup = function (
        groupKey,
        groupData
    ) {
        var groupContainer = $("<div/>");
        $.each(
            groupData.data,
            $.proxy(
                function (typeKey, typeData) {
                    var design;
                    switch (typeData.type) {
                        case "block":
                            design = new Ss.Panel.Design.Block.Editor(
                                typeData
                            );
                            break;
                        case "text":
                            design = new Ss.Panel.Design.Text.Editor(
                                typeData
                            );
                            break;
                        default:
                            return false;
                    }

                    var typeAccordionElement
                        = new Ss.Components.Accordion.Element(
                            typeData.title
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
                = new Ss.Components.Accordion.Element(
                    groupData.title
                );
            groupAccordionElement.add(groupContainer);
            groupAccordionElement.appendTo(this.getBody());
        } else {
            groupContainer.appendTo(this.getBody());
        }
    };
}(window.jQuery, window.Ss);
