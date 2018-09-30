!function ($, ss) {
    'use strict';

    /**
     * Blocks list panel
     *
     * @type {Object}
     */
    ss.panel.blocks.List = function () {
        ss.panel.Abstract.call(
            this,
            {
                group: "block",
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
    ss.panel.blocks.List.prototype
        = Object.create(ss.panel.Abstract.prototype);

    /**
     * Constructor
     */
    ss.panel.blocks.List.prototype.constructor = ss.panel.blocks.List;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.panel.blocks.List.prototype._onLoadDataSuccess = function (data) {
        this
            .setTitle(data.title)
            .setDescription(data.description)
            .showBlockSectionSwitcher(data.labels.blockSection)
            .removeFooter();

        $.each(
            data.list,
            $.proxy(
                function (i, itemData) {
                    var item = ss.components.Template.get("panel-list-item");

                    item.addClass("without-buttons");
                    item.find(".settings").remove();
                    item.find(".design").remove();
                    item.find(".text").text(itemData.name);

                    switch (itemData.type) {
                        case 1:
                            item.find(".icon").addClass("fas fa-font");
                            item.find(".label").on(
                                "click",
                                function () {
                                    new ss.panel.blocks.text.List();
                                }
                            );
                            break;
                        case 2:
                            item.find(".icon").addClass("fas fa-images");
                            item.find(".label").on(
                                "click",
                                function () {
                                    new ss.panel.blocks.image.List();
                                }
                            );
                            break;
                        case 3:
                            item.find(".icon").addClass("far fa-newspaper");
                            break;
                        case 5:
                            item.find(".icon").addClass("fas fa-bars");
                            break;
                        default:
                            break;
                    }

                    this.getBody().append(item);
                },
                this
            )
        );
    };
}(window.jQuery, window.ss);
