!function ($, ss) {
    'use strict';

    /**
     * Create window
     *
     * @type {Object}
     */
    ss.window.release.FullInfo = function () {
        ss.window.Abstract.call(
            this,
            {
                group: "release",
                controller: "fullInfo",
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "release-full-info"
            }
        );
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.release.FullInfo.prototype
        = Object.create(ss.window.Abstract.prototype);

    /**
     * Constructor
     */
    ss.window.release.FullInfo.prototype.constructor = ss.window.release.FullInfo;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.release.FullInfo.prototype._onLoadDataSuccess = function (data) {
        this
            .setTitle(data.title)
            .removeFooter();

        var table = ss.components.Template.get("window-release-info-table");
        table.find(".name-label").text(data.labels.name);
        table.find(".date-label").text(data.labels.date);
        table.find(".category-label").text(data.labels.category);
        table.find(".type-label").text(data.labels.type);
        table.find(".event-label").text(data.labels.event);

        var trTemplate = table.find(".tr-template");

        $.each(
            data.events,
            $.proxy(
                function (i, event) {
                    var tr = trTemplate.clone();
                    tr.removeClass('hidden');
                    tr.find(".name-value").text(event.name);
                    tr.find(".date-value").text(event.date);
                    tr.find(".category-value").text(event.category);
                    tr.find(".type-value").text(event.type);
                    tr.find(".event-value").text(event.event);

                    table.append(tr);
                },
                this
            )
        );

        this.getBody().append(table);
    };
}(window.jQuery, window.ss);
