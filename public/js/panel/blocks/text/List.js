!function ($, TestS) {
    'use strict';

    /**
     * Block text panel
     *
     * @type {Object}
     */
    TestS.Panel.Blocks.Text.List = function () {
        TestS.Panel.Abstract.call(
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
    TestS.Panel.Blocks.Text.List.prototype
        = Object.create(TestS.Panel.Abstract.prototype);

    /**
     * Constructor
     */
    TestS.Panel.Blocks.Text.List.prototype.constructor
        = TestS.Panel.Blocks.Text.List;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    TestS.Panel.Blocks.Text.List.prototype._onLoadDataSuccess = function (
        data
    ) {
        this
            .setTitle(data.title)
            .setDescription(data.description)
            .setBack(
                function () {
                    new TestS.Panel.Blocks.List();
                }
            );

        $.each(
            data.list,
            $.proxy(
                function (i, itemData) {
                    var $item
                        = TestS.Components.Template.get("panel-list-item");

                    $item.addClass("without-buttons");

                    var $designIcon = $item.find(".design");
                    if (itemData.canUpdateDesign === true) {
                        $designIcon.on(
                            "click",
                            function () {
                                new TestS.Panel.Design(
                                    {
                                        group: "text",
                                        controller: "design",
                                        id: itemData.id,
                                        success: function () {
                                            new TestS.Panel.Blocks.Text.List();
                                        }
                                    }
                                );
                            }
                        );
                    } else {
                        $designIcon.remove();
                    }

                    var $settingsIcon = $item.find(".settings");
                    if (itemData.canUpdateDesign === true) {
                        $settingsIcon.on(
                            "click",
                            function () {
                                new TestS.Panel.Blocks.Text.Settings(
                                    itemData.id
                                );
                            }
                        );
                    } else {
                        $settingsIcon.remove();
                    }

                    $item.find(".text").text(itemData.name);
                    $item.find(".icon").addClass("fa-font");

                    this.getBody().append($item);
                },
                this
            )
        );
    };
}(window.jQuery, window.TestS);
