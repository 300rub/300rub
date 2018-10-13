!function ($, ss) {
    "use strict";

    var name = "adminSectionStructure";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsWindowAbstract",

        /**
         * Container
         *
         * @var
         */
        container: null,

        /**
         * Init
         */
        init: function () {
            this.container = null;

            this.create(
                {
                    group: "section",
                    controller: "structure",
                    data: {
                        id: this.getOption("sectionId")
                    },
                    name: "section-structure"
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            this
                .setContainer()
                .setStructure()
                .setAddLineButton()
                .setSubmitButton();
        },

        /**
         * Sets section structure
         */
        setContainer: function () {
            this.container = ss.init("template").get("section-structure");
            this.getBody().append(this.container);
            return this;
        },

        /**
         * Sets structure
         */
        setStructure: function () {
            $.each(
                this.getData("structure", {}),
                $.proxy(
                    function (i, lineData) {
                        this.addLine(lineData);
                    },
                    this
                )
            );

            return this;
        },

        /**
         * Sets add line button
         */
        setAddLineButton: function () {
            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-gray btn-big button",
                    icon: "fas fa-plus",
                    label: this.getLabel("addLine"),
                    appendTo: this.getWindow().find(".footer"),
                    onClick: $.proxy(
                        function () {
                            this.addLine();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets submit button
         */
        setSubmitButton: function () {
            return this.setSubmit(
                {
                    label: this.getLabel("save"),
                    icon: "fas fa-save",
                    ajax: {
                        data: {
                            group: "section",
                            controller: "structure",
                            data: $.proxy(
                                function () {
                                    return {
                                        id: this.getOption("sectionId"),
                                        structure: this.getStructure()
                                    };
                                },
                                this
                            )
                        },
                        type: "PUT",
                        success: $.proxy(this.onSendSuccess, this)
                    }
                }
            );
        },

        /**
         * On send success
         */
        onSendSuccess: function () {
            if (this.getOption("sectionId") === ss.init("app").getSectionId()) {
                window.location.reload();
            } else {
                this.remove();
            }
        },

        /**
         * Adds block
         *
         * @param {Object} data
         * @param {Object} gridStack
         */
        addBlock: function (data, gridStack) {
            var icon;
            switch (data.type) {
                case 1:
                    icon = "fas fa-font";
                    break;
                case 2:
                    icon = "fas fa-image";
                    break;
                case 3:
                    icon = "far fa-newspaper";
                    break;
                case 5:
                    icon = "fas fa-bars";
                    break;
                default:
                    icon = null;
                    break;
            }

            var blockElement = ss.init("template").get(
                "grid-stack-item"
            );

            blockElement.find(".name").text(data.name);
            blockElement.attr("title", data.name);

            var iconElement = blockElement.find(".icon");
            if (icon === null) {
                iconElement.remove();
            } else {
                iconElement.addClass(icon);
            }

            blockElement.find(".remove").on(
                "click",
                function () {
                    gridStack.removeWidget(blockElement);
                }
            );

            blockElement.attr("data-id", data.id);

            if (data.x === undefined) {
                data.x = 0;
            }

            if (data.y === undefined) {
                data.y = 100;
            }

            if (data.width === undefined) {
                data.width = 3;
            }

            gridStack.addWidget(
                blockElement,
                data.x,
                data.y,
                data.width,
                1
            );
        },

        /**
         * Adds line
         */
        addLine: function (lineData) {
            lineData = $.extend({}, lineData);

            if (lineData.id === undefined) {
                lineData.id = 0;
            }

            if (lineData.name === undefined) {
                lineData.name = this.getLabel("newLine");
            }

            var lineElement = ss.init("template").get(
                "section-structure-line"
            );

            var removeButton = lineElement.find(".remove-line");
            removeButton.on(
                "click",
                $.proxy(
                    function () {
                        if (lineData.id === 0) {
                            lineElement.remove();
                            return false;
                        }

                        ss.init(
                            "commonComponentsConfirmation",
                            {
                                element: removeButton,
                                text: this.getLabel("deleteLineConfirmText"),
                                yes: {
                                    label: this.getLabel("delete"),
                                    icon: "fas fa-trash"
                                },
                                no: this.getLabel("no"),
                                onClick: function () {
                                    lineElement.remove();
                                }
                            }
                        );
                    },
                    this
                )
            );

            lineElement.attr("data-id", lineData.id);

            lineElement.find(".line-name").text(lineData.name);

            this.container.append(lineElement);

            var gridStack = lineElement.find(".grid-stack");

            gridStack.gridstack(
                {
                    animate: true,
                    cellHeight: "60px",
                    width: 12,
                    verticalMargin: 10,
                    resizable: {
                        handles: 'w, e',
                        classes: {
                            "ui-resizable-w": "fas fa-arrows-alt-h",
                            "ui-resizable-e": "fas fa-arrows-alt-h"
                        }
                    }
                }
            );

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-gray btn-small",
                    icon: "fas fa-plus",
                    label: this.getLabel("addBlock"),
                    appendTo: lineElement.find(".line-footer"),
                    onClick: $.proxy(
                        function () {
                            ss.init(
                                "adminSectionBlock",
                                {
                                    name: "section-blocks",
                                    blocks: this.getData("blocks"),
                                    callback: $.proxy(
                                        function (blockData) {
                                            this.addBlock(
                                                blockData,
                                                gridStack.data('gridstack')
                                            );
                                        },
                                        this
                                    )
                                }
                            );
                        },
                        this
                    )
                }
            );

            var btnGroup = lineElement.find(".line-header .btn-group");

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-gray btn-small up",
                    icon: "fas fa-chevron-up",
                    label: "Up",
                    appendTo: btnGroup,
                    onClick: $.proxy(
                        function () {
                            lineElement.prev().before(lineElement);
                        },
                        this
                    )
                }
            );

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-gray btn-small down",
                    icon: "fas fa-chevron-down",
                    label: "Down",
                    appendTo: btnGroup,
                    onClick: $.proxy(
                        function () {
                            lineElement.next().after(lineElement);
                        },
                        this
                    )
                }
            );

            if (lineData.blocks !== undefined) {
                setTimeout(
                    $.proxy(
                        function () {
                            $.each(
                                lineData.blocks,
                                $.proxy(
                                    function (i, blockData) {
                                        this.addBlock(
                                            blockData,
                                            gridStack.data('gridstack')
                                        );
                                    },
                                    this
                                )
                            );
                        },
                        this
                    ),
                    300
                );
            }

            this.getBody().scrollTop(100000);
        },

        /**
         * Gets structure
         *
         * @returns {Array}
         */
        getStructure: function () {
            var structure = [];

            this.container.find(".section-structure-line").each(
                function () {
                    var grids = [];

                    $(this).find(".grid-stack-item").each(
                        function () {
                            grids.push(
                                {
                                    blockId: $(this).data("id"),
                                    x: $(this).data("gs-x"),
                                    y: $(this).data("gs-y"),
                                    width: $(this).data("gs-width")
                                }
                            );
                        }
                    );

                    structure.push(
                        {
                            id: $(this).data("id"),
                            grids: grids
                        }
                    );
                }
            );

            return structure;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
