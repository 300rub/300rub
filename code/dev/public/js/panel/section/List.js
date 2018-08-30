!function ($, ss) {
    'use strict';

    /**
     * Section panel
     *
     * @type {Object}
     */
    ss.panel.section.List = function () {
        ss.panel.Abstract.call(
            this,
            {
                group: "section",
                controller: "list",
                success: $.proxy(this._onLoadDataSuccess, this)
            }
        );
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.panel.section.List.prototype
        = Object.create(ss.panel.Abstract.prototype);

    /**
     * Constructor
     */
    ss.panel.section.List.prototype.constructor = ss.panel.section.List;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.panel.section.List.prototype._onLoadDataSuccess = function (data) {
        this
            .setTitle(data.title)
            .setDescription(data.description);

        $.each(
            data.list,
            $.proxy(
                function (i, section) {
                    var item = ss.components.Template.get("panel-list-item");
                    item.find(".text").text(section.name);

                    if (section.isPublished === false) {
                        item.find(".icon").addClass("far fa-eye-slash");
                    }

                    if (section.isMain === true) {
                        item.find(".icon").addClass("fas fa-home");
                    }

                    item.find(".label").on(
                        "click",
                        function () {
                            new ss.window.section.Structure(section.id);
                        }
                    );

                    this.getBody().append(item);
                },
                this
            )
        );
    };
}(window.jQuery, window.ss);
