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
            this._panel
                .setTitle(data.title)
                .setDescription(data.description)
                .setBack(TestS.Panel.Block.Text);

            var listLength = data["list"].length;

            $.each(data["list"], $.proxy(function(groupKey, groupData) {
                var groupContainer = $("<div/>");
                $.each(groupData["data"], function (typeKey, typeData) {
                    var data = {
                        namespace: typeData["namespace"],
                        values: typeData["values"],
                        labels: typeData["labels"],
                        selector: groupData["selector"]
                    };

                    var design;
                    switch (typeData["type"]) {
                        case "block":
                            design = new TestS.Panel.Design.Block(
                                $.extend(
                                    data,
                                    {
                                        containerId: groupData["containerIdGroup"] + "-block"
                                    }
                                )
                            );
                            break;
                        default:
                            return false;
                    }

                    var typeAccordionElement = new TestS.Accordion.Element(typeData["title"]);
                    typeAccordionElement.add(design.getDesignContainer());

                    typeAccordionElement.appendTo(groupContainer);

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
                .setMaxHeight()
                .removeLoading();
        }
    };
}(window.jQuery, window.TestS);