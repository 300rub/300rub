!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignEditor";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsPanel",

        /**
         * Editors
         *
         * @var {Array}
         */
        editors: [],

        /**
         * Tree
         *
         * @var {Array}
         */
        tree: [],

        /**
         * Init
         */
        init: function () {
            this.editors = [];
            this.tree = [];

            var back = $.proxy(
                function () {
                    this.rollback();

                    var onBack = this.getOption("onBack");
                    if ($.type(onBack) === "function") {
                        onBack();
                    }
                },
                this
            );

            var closeEvents = function () {
                this.rollback();
            };

            this.create(
                {
                    data: {
                        blockId: this.getOption("blockId")
                    },
                    back: $.proxy(back, this),
                    closeEvents: $.proxy(closeEvents, this)
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            $.each(
                this.getData("list", []),
                $.proxy(
                    this.setTree,
                    this
                )
            );

            if (this.tree.length === 1
                && $.type(this.tree[0]) === "object"
                && this.tree[0].children !== undefined
            ) {
                this.tree = this.tree[0].children;
            }

            ss.init(
                "commonComponentsAccordion",
                {
                    tree: this.tree,
                    container: this.getBody()
                }
            );

            this.setSubmit(
                {
                    label: this.getLabel("button"),
                    icon: "fas fa-save",
                    ajax: {
                        data: {
                            group: this.getData("group"),
                            controller: this.getData("controller"),
                            data: $.proxy(
                                function () {
                                    var editorsData = {
                                        blockId: this.getData("blockId")
                                    };

                                    $.each(
                                        this.editors,
                                        function (i, design) {
                                            editorsData = $.extend(
                                                {},
                                                editorsData,
                                                design.getData()
                                            );
                                        }
                                    );

                                    return editorsData;
                                },
                                this
                            )
                        },
                        type: "PUT",
                        success: this.getOption("success")
                    }
                }
            );
        },

        /**
         * Rolls back
         */
        rollback: function () {
            $.each(
                this.editors,
                function (i, editor) {
                    editor.rollback();
                }
            );
        },

        /**
         * Sets tree
         *
         * @param {int}    groupKey
         * @param {Object} groupData
         */
        setTree: function (groupKey, groupData) {
            var children = [];
            var blockId = this.getData("blockId");

            $.each(
                groupData.data,
                $.proxy(
                    function (typeKey, options) {
                        var editor = null;

                        options = $.extend(
                            {},
                            options,
                            {
                                blockId: blockId
                            }
                        );

                        switch (options.type) {
                            case "block":
                                editor = ss.init(
                                    "adminComponentsDesignBlockEditor",
                                    options
                                );
                                break;
                            case "text":
                                editor = ss.init(
                                    "adminComponentsDesignTextEditor",
                                    options
                                );
                                break;
                            default:
                                return false;
                        }

                        if (editor !== null) {
                            this.editors.push(editor);

                            children.push(
                                {
                                    title: options.title,
                                    body: editor.getEditorContainer()
                                }
                            );
                        }
                    },
                    this
                )
            );

            this.tree.push(
                {
                    title: groupData.title,
                    children: children
                }
            );
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
