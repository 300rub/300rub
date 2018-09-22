!function ($, ss) {
    'use strict';

    /**
     * Block text panel
     *
     * @type {Object}
     */
    ss.panel.blocks.image.List = function () {
        ss.panel.Abstract.call(
            this,
            {
                group: "image",
                controller: "blocks",
                data: {
                    blockSection: this.getBlockSection()
                },
                success: $.proxy(this._onLoadDataSuccess, this)
            }
        );
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.panel.blocks.image.List.prototype
        = Object.create(ss.panel.Abstract.prototype);

    /**
     * Constructor
     */
    ss.panel.blocks.image.List.prototype.constructor
        = ss.panel.blocks.image.List;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.panel.blocks.image.List.prototype._onLoadDataSuccess = function (
        data
    ) {
        this
            .setTitle(data.title)
            .setDescription(data.description)
            .setBack(
                function () {
                    new ss.panel.blocks.List();
                }
            )
            .showBlockSectionSwitcher(data.labels.blockSection);

        if (data.canAdd === true) {
            this
                .setFooterButton({
                    label: data.labels.add,
                    icon: "fas fa-plus",
                    onClick: function () {
                        new ss.panel.blocks.image.Settings();
                    }
                });
        } else {
            this.removeFooter();
        }

        $.each(
            data.list,
            $.proxy(
                function (i, itemData) {
                    var item
                        = ss.components.Template.get("panel-list-item");

                    var designIcon = item.find(".design");
                    if (itemData.canUpdateDesign === true) {
                        designIcon.on(
                            "click",
                            function () {
                                new ss.panel.design.Editor(
                                    {
                                        group: "image",
                                        controller: "design",
                                        id: itemData.id,
                                        success: function () {
                                            new ss.panel.blocks.image.List();
                                        }
                                    }
                                );
                            }
                        );
                    } else {
                        designIcon.remove();
                    }

                    var settingsIcon = item.find(".settings");
                    if (itemData.canUpdateDesign === true) {
                        settingsIcon.on(
                            "click",
                            function () {
                                new ss.panel.blocks.image.Settings(
                                    itemData.id
                                );
                            }
                        );
                    } else {
                        settingsIcon.remove();
                    }

                    var label = item.find(".label");

                    label.find(".text").text(itemData.name);
                    label.find(".icon").addClass("fas fa-image");

                    item.find(".label").on(
                        "click",
                        function () {
                            new ss.window.blocks.image.Content(itemData.id);
                        }
                    );

                    this.getBody().append(item);
                },
                this
            )
        );
    };
}(window.jQuery, window.ss);
