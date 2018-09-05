!function ($, ss) {
    'use strict';

    /**
     * Section settings panel
     *
     * @type {Object}
     */
    ss.panel.section.Settings = function () {
        ss.panel.Abstract.call(
            this,
            {
                group: "section",
                controller: "section",
                success: $.proxy(this._onLoadDataSuccess, this)
            }
        );

        this._name = null;
        this._alias = null;
        this._title = null;
        this._keywords = null;
        this._description = null;
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.panel.section.Settings.prototype
        = Object.create(ss.panel.Abstract.prototype);

    /**
     * Constructor
     */
    ss.panel.section.Settings.prototype.constructor = ss.panel.section.Settings;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.panel.section.Settings.prototype._onLoadDataSuccess = function (data) {
        var forms = [];

        this._name = new ss.forms.Text(
            $.extend(
                {
                    appendTo: this._panel.getBody()
                },
                data.forms.name
            )
        );
        forms.push(this._name);

        this._alias = new ss.forms.Text(
            $.extend(
                {
                    appendTo: this._panel.getBody()
                },
                data.forms.alias
            )
        );
        forms.push(this._alias);

        this._title = new ss.forms.Text(
            $.extend(
                {
                    appendTo: this._panel.getBody()
                },
                data.forms.title
            )
        );
        forms.push(this._title);

        this._keywords = new ss.forms.Text(
            $.extend(
                {
                    appendTo: this._panel.getBody()
                },
                data.forms.keywords
            )
        );
        forms.push(this._keywords);

        this._description = new ss.forms.Text(
            $.extend(
                {
                    appendTo: this._panel.getBody()
                },
                data.forms.description
            )
        );
        forms.push(this._description);

        if (data.forms.isMain.value !== true) {
            var isMain = new ss.forms.Checkbox(
                $.extend(
                    {
                        appendTo: this._panel.getBody()
                    },
                    data.forms.isMain
                )
            );
            forms.push(isMain);
        }

        var isPublished = new ss.forms.Checkbox(
            $.extend(
                {
                    appendTo: this._panel.getBody()
                },
                data.forms.isPublished
            )
        );
        forms.push(isPublished);

        var type = "PUT";
        var icon = "fas fa-save";
        if (data.id === 0) {
            type = "POST";
            icon = "fas fa-plus";
        }

        this
            .setTitle(data.title)
            .setDescription(data.description)
            .setBack(
                function () {
                    new ss.panel.section.List();
                }
            )
            .setSubmit(
                {
                    label: data.button.label,
                    icon: icon,
                    forms: forms,
                    ajax: {
                        data: {
                            group: "section",
                            controller: "section"
                        },
                        type: type,
                        success: $.proxy(this._onSendDataSuccess, this)
                    }
                }
            );
    };

    /**
     * On send success
     *
     * @param {Object} data
     *
     * @private
     */
    ss.panel.section.Settings.prototype._onSendDataSuccess = function (data) {
        if ($.type(data.errors) === "object"
            && $.type(data.errors.seoModel) === "object"
        ) {
            var errors = data.errors.seoModel;

            if (errors.name !== undefined) {
                this._name
                    .setError(errors.name)
                    .scrollTo()
                    .focus();
                return this;
            }

            if (errors.alias !== undefined) {
                this._alias
                    .setError(errors.alias)
                    .scrollTo()
                    .focus();
                return this;
            }

            if (errors.title !== undefined) {
                this._title
                    .setError(errors.title)
                    .scrollTo()
                    .focus();
                return this;
            }

            if (errors.keywords !== undefined) {
                this._keywords
                    .setError(errors.keywords)
                    .scrollTo()
                    .focus();
                return this;
            }

            if (errors.description !== undefined) {
                this._description
                    .setError(errors.description)
                    .scrollTo()
                    .focus();
                return this;
            }
        } else {
            new ss.panel.section.Settings.List();

            if (data.sectionId !== undefined) {
                new ss.window.section.Structure(data.sectionId);
            }
        }
    };
}(window.jQuery, window.ss);
