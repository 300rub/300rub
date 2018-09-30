!function ($, ss) {
    'use strict';

    /**
     * Settings panel
     *
     * @type {Object}
     */
    ss.panel.settings.CodeList = function () {
        ss.panel.Abstract.call(
            this,
            {
                group: "settings",
                controller: "codeList",
                success: $.proxy(this._onLoadDataSuccess, this)
            }
        );
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.panel.settings.CodeList.prototype
        = Object.create(ss.panel.Abstract.prototype);

    /**
     * Constructor
     */
    ss.panel.settings.CodeList.prototype.constructor = ss.panel.settings.CodeList;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.panel.settings.CodeList.prototype._onLoadDataSuccess = function (data) {
        this
            .setTitle(data.title)
            .setDescription(data.description)
            .setBack(
                function () {
                    new ss.panel.settings.List();
                }
            )
            .removeFooter();

        $.each(
            data.list,
            $.proxy(
                function (i, listItem) {
                    var item = ss.components.Template.get("panel-list-item");
                    item.addClass("without-buttons");
                    item.find(".settings").remove();
                    item.find(".design").remove();
                    item.find(".text").text(listItem.name);
                    item.find(".icon").addClass("fas fa-code");

                    item.find(".label").on(
                        "click",
                        function () {
                            new ss.window.settings.Code(listItem.type);
                        }
                    );

                    this.getBody().append(item);
                },
                this
            )
        );
    };
}(window.jQuery, window.ss);
