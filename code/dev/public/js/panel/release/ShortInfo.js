!function ($, ss) {
    'use strict';

    /**
     * Release panel
     *
     * @type {Object}
     */
    ss.panel.settings.ShortInfo = function () {
        ss.panel.Abstract.call(
            this,
            {
                group: "release",
                controller: "shortInfo",
                success: $.proxy(this._onLoadDataSuccess, this)
            }
        );
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.panel.settings.ShortInfo.prototype
        = Object.create(ss.panel.Abstract.prototype);

    /**
     * Constructor
     */
    ss.panel.settings.ShortInfo.prototype.constructor = ss.panel.settings.ShortInfo;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.panel.settings.ShortInfo.prototype._onLoadDataSuccess = function (data) {
        this
            .setTitle(data.title)
            .setDescription(data.description)
            .setSubmit(
                {
                    label: data.button.label,
                    icon: "fas fa-truck",
                    ajax: {
                        data: {
                            group: "release",
                            controller: "release"
                        },
                        type: "POST",
                        success: $.proxy(this._onSendDataSuccess, this)
                    }
                }
            );

        var item = ss.components.Template.get("panel-list-item");

        item.addClass("without-buttons");
        item.find(".settings").remove();
        item.find(".design").remove();
        item.find(".text").text(data.moreInfoLabel);
        item.find(".icon").addClass("fas fa-info");
        item.find(".label").on(
            "click",
            function () {
                new ss.window.release.FullInfo();
            }
        );

        this.getBody().append(item);
    };

    /**
     * On send success
     *
     * @private
     */
    ss.panel.settings.ShortInfo.prototype._onSendDataSuccess = function () {
        window.location.reload();
    };
}(window.jQuery, window.ss);
