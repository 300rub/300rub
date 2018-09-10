!function ($, ss) {
    'use strict';

    /**
     * Block text panel
     *
     * @type {Object}
     */
    ss.panel.blocks.text.List = function () {
        ss.panel.Abstract.call(
            this,
            {
                group: "text",
                controller: "blocks",
                success: $.proxy(this._onLoadDataSuccess, this)
            }
        );
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.panel.blocks.text.List.prototype
        = Object.create(ss.panel.Abstract.prototype);

    /**
     * Constructor
     */
    ss.panel.blocks.text.List.prototype.constructor
        = ss.panel.blocks.text.List;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.panel.blocks.text.List.prototype._onLoadDataSuccess = function (
        data
    ) {
        this
            .setTitle(data.title)
            .setDescription(data.description)
            .setBack(
                function () {
                    new ss.panel.blocks.List();
                }
            );

        $.each(
            data.list,
            $.proxy(
                function (i, itemData) {
                    var item
                        = ss.components.Template.get("panel-list-item");

                    item.addClass("without-buttons");

                    var $designIcon = item.find(".design");
                    if (itemData.canUpdateDesign === true) {
                        $designIcon.on(
                            "click",
                            function () {
                                new ss.panel.design.Editor(
                                    {
                                        group: "text",
                                        controller: "design",
                                        id: itemData.id,
                                        success: function () {
                                            new ss.panel.blocks.text.List();
                                        }
                                    }
                                );
                            }
                        );
                    } else {
                        $designIcon.remove();
                    }

                    var $settingsIcon = item.find(".settings");
                    if (itemData.canUpdateDesign === true) {
                        $settingsIcon.on(
                            "click",
                            function () {
                                new ss.panel.blocks.text.Settings(
                                    itemData.id
                                );
                            }
                        );
                    } else {
                        $settingsIcon.remove();
                    }

                    var label = item.find(".label");

                    label.find(".text").text(itemData.name);
                    label.find(".icon").addClass("fas fa-font");

                    item.find(".label").on(
                        "click",
                        function () {
                            new ss.window.blocks.text.Content(itemData.id);
                        }
                    );

                    this.getBody().append(item);
                },
                this
            )
        );
    };
}(window.jQuery, window.ss);
