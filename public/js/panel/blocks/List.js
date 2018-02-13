!function ($, Ss) {
    'use strict';

    /**
     * Blocks list panel
     *
     * @type {Object}
     */
    Ss.Panel.Blocks.List = function () {
        Ss.Panel.Abstract.call(
            this,
            {
                group: "block",
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
    Ss.Panel.Blocks.List.prototype
        = Object.create(Ss.Panel.Abstract.prototype);

    /**
     * Constructor
     */
    Ss.Panel.Blocks.List.prototype.constructor = Ss.Panel.Blocks.List;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    Ss.Panel.Blocks.List.prototype._onLoadDataSuccess = function (data) {
        this
            .setTitle(data.title)
            .setDescription(data.description);

        $.each(
            data.list,
            $.proxy(
                function (i, itemData) {
                    var item = Ss.Components.Template.get("panel-list-item");

                    item.addClass("without-buttons");
                    item.find(".settings").remove();
                    item.find(".design").remove();
                    item.find(".text").text(itemData.name);

                    switch (itemData.type) {
                        case "text":
                            item.find(".icon").addClass("fa-font");
                            item.find(".label").on(
                                "click",
                                function () {
                                    new Ss.Panel.Blocks.Text.List();
                                }
                            );
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
}(window.jQuery, window.Ss);
