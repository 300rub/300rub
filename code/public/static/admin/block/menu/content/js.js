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
                    "check_callback" : true,
                    "data": [
                        {
                            "id": "0",
                            "text": "Root",
                            "type": "root",
                            'state' : { 'opened' : true },
                            children: [
                                {
                                    "id": "1",
                                    "text": " 11111111111111111" + ss.init("template").get("test-aaa").html(),
                                    type: "default"
                                },
                                {
                                    "id": "2",
                                    "text": "22222222222222222" + ss.init("template").get("test-aaa").html(),
                                    type: "default"
                                },
                                {
                                    "id": "3",
                                    "text": "333333333333333333" + ss.init("template").get("test-aaa").html(),
                                    type: "empty"
                                },
                                {
                                    "id": "4",
                                    "text": "444444444444444444" + ss.init("template").get("test-aaa").html(),
                                    type: "default"
                                }
                            ]
                        }
                    ]
                },
                "types" : {
                    "#" : {
                        "valid_children" : ["root"]
                    },
                    "root" : {
                        "valid_children" : ["default", "empty"],
                        icon: "fas fa-folder-open"
                    },
                    "default" : {
                        "valid_children" : ["default", "empty"],
                        icon: "fas fa-folder"
                    },
                    "empty" : {
                        "valid_children" : ["default", "empty"],
                        icon: "far fa-folder"
                    }
                },
                "plugins" : [
                    "dnd", "types"
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
