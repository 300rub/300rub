!function ($, TestS) {
    'use strict';

    /**
     * Blocks list panel
     *
     * @type {Object}
     */
    TestS.Panel.Blocks.List = function () {
        TestS.Panel.Abstract.call(
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
    TestS.Panel.Blocks.List.prototype
        = Object.create(TestS.Panel.Abstract.prototype);

    /**
     * Constructor
     */
    TestS.Panel.Blocks.List.prototype.constructor = TestS.Panel.Blocks.List;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    TestS.Panel.Blocks.List.prototype._onLoadDataSuccess = function (data) {
        this
            .setTitle(data.title)
            .setDescription(data.description);

        $.each(
            data.list,
            $.proxy(
                function (i, itemData) {
                    var item = TestS.Components.Template.get("panel-list-item");

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
                                    new TestS.Panel.Blocks.Text.List();
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
}(window.jQuery, window.TestS);
