!function ($, ss) {
    "use strict";

    var name = "adminBlockMenuContent";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsWindowAbstract",

        /**
         * Init
         */
        init: function () {
            this.create(
                {
                    group: "menu",
                    controller: "content",
                    data: {
                        blockId: this.getOption("blockId")
                    },
                    name: "menu-content"
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            this.setTree();

            this.setSubmit(
                {
                    label: this.getLabel("button"),
                    icon: "fas fa-save",
                    forms: this.forms,
                    ajax: {
                        data: {
                            group: "menu",
                            controller: "content",
                            data: {
                                blockId: this.getData("blockId")
                            }
                        },
                        type: "PUT",
                        success: $.proxy(this.onSendSuccess, this)
                    }
                }
            );
        },

        setTree: function() {
            var tree = ss.init("template").get("menu-tree");
            tree.appendTo(this.getBody());

            tree.jstree({
                "core" : {
                    "animation" : 0,
                    "check_callback" : true,
                    "data" : [
                        { "id" : "ajson1", "parent" : "#", "text" : "Simple root node" },
                        { "id" : "ajson11", "parent" : "#", "text" : "Simple root 1 node" },
                        { "id" : "ajson12", "parent" : "#", "text" : "Simple root 2 node" },
                        { "id" : "ajson2", "parent" : "#", "text" : "Root node 2" }
                    ]
                },
                "types" : {
                    "#" : {
                        "max_children" : 1,
                        "max_depth" : 4,
                        "valid_children" : ["root"]
                    },
                    "root" : {
                        "icon" : "/static/3.1.1/assets/images/tree_icon.png",
                        "valid_children" : ["default"]
                    },
                    "default" : {
                        "valid_children" : ["default","file"]
                    },
                    "file" : {
                        "icon" : "glyphicon glyphicon-file",
                        "valid_children" : []
                    }
                },
                "plugins" : [
                    "contextmenu", "dnd", "types"
                ]
            });
        },

        /**
         * On send success
         */
        onSendSuccess: function () {
            console.log(1);
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
