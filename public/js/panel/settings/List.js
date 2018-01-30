!function ($, TestS) {
    'use strict';

    /**
     * Settings panel
     *
     * @type {Object}
     */
    TestS.Panel.Settings.List = function () {
        TestS.Panel.Abstract.call(
            this,
            {
                group: "settings",
                controller: "settings",
                success: $.proxy(this._onLoadDataSuccess, this)
            }
        );
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Settings.List.prototype
        = Object.create(TestS.Panel.Abstract.prototype);

    /**
     * Constructor
     */
    TestS.Panel.Settings.List.prototype.constructor = TestS.Panel.Settings.List;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    TestS.Panel.Settings.List.prototype._onLoadDataSuccess = function (data) {
        this
            .setTitle(data.title)
            .setDescription(data.description);

        $.each(
            data.list,
            $.proxy(
                function (key, name) {
                    var item = TestS.Components.Template.get("panel-list-item");
                    item.addClass("without-buttons");
                    item.find(".settings").remove();
                    item.find(".design").remove();
                    item.find(".text").text(name);

                    switch (key) {
                        case "users":
                            item.find(".icon").addClass("fa-user");
                            item.find(".label").on(
                                "click",
                                function () {
                                    new TestS.Window.Users.List();
                                }
                            );
                            break;
                        case "icon":
                            item.find(".icon").addClass("fa-picture-o");
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
