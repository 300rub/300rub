!function ($, TestS) {
    'use strict';

    /**
     * Panel design
     *
     * @param {String} controller
     * @param {String} action
     * @param {int}    id
     *
     * @type {Object}
     */
    TestS.Panel.Design = function (controller, action, id) {
        this._controller = controller;
        this._action = action;
        this._id = id;
        this._panel = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Design.prototype = {
        /**
         * Init
         */
        init: function () {
            this._panel = new TestS.Panel({
                controller: this._controller,
                action: this._action,
                id: this._id,
                success: $.proxy(this._onLoadDataSuccess, this)
            });
        },

        /**
         * On load panel success
         *
         * @param {Object} [data]
         *
         * @private
         */
        _onLoadDataSuccess: function(data) {
            var listLength = data["list"].length;
            var designs = [];

            $.each(data["list"], $.proxy(function(groupKey, groupData) {
                var groupContainer = $("<div/>");
                $.each(groupData["data"], function (typeKey, typeData) {
                    var design;
                    switch (typeData["type"]) {
                        case "block":
                            design = new TestS.Panel.Design.Block(typeData);
                            break;
                        case "text":
                            design = new TestS.Panel.Design.Text(typeData);
                            break;
                        default:
                            return false;
                    }

                    var typeAccordionElement = new TestS.Accordion.Element(typeData["title"]);
                    typeAccordionElement.add(design.getDesignContainer());

                    typeAccordionElement.appendTo(groupContainer);

                    designs.push(design);
                });

                //if (listLength > 1) {
                    var groupAccordionElement = new TestS.Accordion.Element(groupData["title"]);
                    groupAccordionElement.add(groupContainer);
                    groupAccordionElement.appendTo(this._panel.getBody());
                //} else {
                //    groupContainer.appendTo(this._panel.getBody());
                //}
            }, this));

            TestS.Accordion(this._panel.getBody());

            this._panel
                .setTitle(data.title)
                .setDescription(data.description)
                .setBack(function(){
                    new TestS.Panel.Block.Text();

                    $.each(designs, function(i, design) {
                        design.rollback();
                    });
                })
                .setCloseEvents(function(){
                    $.each(designs, function(i, design) {
                        design.rollback();
                    });
                })
                .setMaxHeight()
                .setSubmit({
                    label: "aaa",
                    icon: "fa-lock",
                    ajax: {
                        data: {
                            controller: "user",
                            action: "session",
                            data: function() {
                                var data = {};

                                $.each(designs, function(i, design) {
                                    data = $.extend(data, design.getData());
                                });

                                return data;
                            }
                        },
                        type: "POST",
                        success: function() {
                            new TestS.Panel.Block.Text();
                        },
                        error: $.proxy(this._panel.onError, this._panel)
                    }
                })
                .removeLoading();
        }
    };
}(window.jQuery, window.TestS);