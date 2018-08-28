!function ($, ss) {
    'use strict';

    /**
     * Settings panel
     *
     * @type {Object}
     */
    ss.panel.settings.List = function () {
        ss.panel.Abstract.call(
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
    ss.panel.settings.List.prototype
        = Object.create(ss.panel.Abstract.prototype);

    /**
     * Constructor
     */
    ss.panel.settings.List.prototype.constructor = ss.panel.settings.List;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.panel.settings.List.prototype._onLoadDataSuccess = function (data) {
        this
            .setTitle(data.title)
            .setDescription(data.description)
            .removeFooter();

        $.each(
            data.list,
            $.proxy(
                function (key, name) {
                    var item = ss.components.Template.get("panel-list-item");
                    item.addClass("without-buttons");
                    item.find(".settings").remove();
                    item.find(".design").remove();
                    item.find(".text").text(name);

                    switch (key) {
                        case "users":
                            item.find(".icon").addClass("fas fa-user-friends");
                            item.find(".label").on(
                                "click",
                                function () {
                                    new ss.window.users.List();
                                }
                            );
                            break;
                        case "icon":
                            item.find(".icon").addClass("fas fa-image");
                            break;
                        case "hiddenCode":
                            item.find(".icon").addClass("fas fa-code");
                            item.find(".label").on(
                                "click",
                                function () {
                                    new ss.panel.settings.CodeList();
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
}(window.jQuery, window.ss);
