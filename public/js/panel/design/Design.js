!function ($, TestS) {
    'use strict';

    /**
     * Panel design
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    TestS.Panel.Design = function (options) {
        this._group = options["group"];
        this._controller = options["controller"];
        this._id = options["id"];
        this._success = options["success"];

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
                group: this._group,
                controller: this._controller,
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
            var designs = [];
            var id = data["id"];
            var group = data["group"];
            var controller = data["controller"];
            var buttonLabel = data["button"]["label"];

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

                //if (data["list"].length > 1) {
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
                    label: buttonLabel,
                    icon: "fa-check",
                    ajax: {
                        data: {
                            group: group,
                            controller: controller,
                            data: function() {
                                var data = {
                                    id: id
                                };

                                $.each(designs, function(i, design) {
                                    data = $.extend(data, design.getData());
                                });

                                return data;
                            }
                        },
                        type: "PUT",
                        success: this._success,
                        error: $.proxy(this._panel.onError, this._panel)
                    }
                })
                .removeLoading();
        }
    };
}(window.jQuery, window.TestS);