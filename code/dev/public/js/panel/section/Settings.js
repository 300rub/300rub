!function ($, ss) {
    'use strict';

    /**
     * Section settings panel
     *
     * @param {int} sectionId
     *
     * @type {Object}
     */
    ss.panel.section.Settings = function (sectionId) {
        this._sectionId = sectionId;
        if (sectionId === undefined) {
            this._sectionId = 0;
        }

        ss.panel.Abstract.call(
            this,
            {
                group: "section",
                controller: "section",
                data: {
                    id: sectionId
                },
                success: $.proxy(this._onLoadDataSuccess, this)
            }
        );

        this._labels = {};
        this._forms = {};
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
        var type = "PUT";
        var icon = "fas fa-save";
        if (data.id === 0) {
            type = "POST";
            icon = "fas fa-plus";
        }

        this
            .setTitle(data.title)
            .setDescription(data.description)
            ._setLabels(data.labels)
            .setBack(
                function () {
                    new ss.panel.section.List();
                }
            )
            ._setButtons()
            ._setForms(data.forms)
            .setSubmit(
                {
                    label: data.forms.button.label,
                    icon: icon,
                    forms: this._forms,
                    ajax: {
                        data: {
                            group: "section",
                            controller: "section",
                            data: {
                                id: this._sectionId
                            }
                        },
                        type: type,
                        success: $.proxy(this._onSendDataSuccess, this)
                    }
                }
            );
    };

    /**
     * Sets labels
     *
     * @returns {ss.panel.section.Settings}
     *
     * @private
     */
    ss.panel.section.Settings.prototype._setLabels = function (labels) {
        this._labels = labels;
        return this;
    };

    /**
     * Sets buttons
     *
     * @returns {ss.panel.section.Settings}
     *
     * @private
     */
    ss.panel.section.Settings.prototype._setButtons = function () {
        if (this._sectionId === 0) {
            return this;
        }

        return this
            .addHeaderButton(
                {
                    label: this._labels.duplicate,
                    icon: "fas fa-clone",
                    css: "btn btn-gray btn-small",
                    ajax: {
                        data: {
                            group: "section",
                            controller: "sectionDuplication",
                            data: {
                                id: this._sectionId
                            }
                        },
                        type: "POST",
                        success: function(data) {
                            new ss.panel.section.Settings(data.id);
                        }
                    }
                }
            )
            .addHeaderButton(
                {
                    label: this._labels.delete,
                    icon: "fas fa-trash",
                    css: "btn btn-red btn-small",
                    confirm: {
                        text: this._labels.deleteConfirmText,
                        yes: {
                            label: this._labels.delete,
                            icon: "fas fa-trash"
                        },
                        no: this._labels.no
                    },
                    ajax: {
                        data: {
                            group: "section",
                            controller: "section",
                            data: {
                                id: this._sectionId
                            }
                        },
                        type: "DELETE",
                        success: function() {
                            new ss.panel.section.List();
                        }
                    }
                }
            );
    };

    /**
     * Sets forms
     *
     * @param {Object} forms
     *
     * @returns {ss.panel.section.Settings}
     *
     * @private
     */
    ss.panel.section.Settings.prototype._setForms = function (forms) {
        this._forms = {};

        this._forms.name = new ss.forms.Text(
            $.extend(
                {
                    appendTo: this.getBody()
                },
                forms.name
            )
        );

        this._forms.alias = new ss.forms.Text(
            $.extend(
                {
                    appendTo: this.getBody()
                },
                forms.alias
            )
        );

        this._forms.title = new ss.forms.Text(
            $.extend(
                {
                    appendTo: this.getBody()
                },
                forms.title
            )
        );

        this._forms.keywords = new ss.forms.Text(
            $.extend(
                {
                    appendTo: this.getBody()
                },
                forms.keywords
            )
        );

        this._forms.description = new ss.forms.Text(
            $.extend(
                {
                    appendTo: this.getBody()
                },
                forms.description
            )
        );

        if (forms.isMain.value !== true) {
            this._forms.isMain = new ss.forms.Checkbox(
                $.extend(
                    {
                        appendTo: this.getBody()
                    },
                    forms.isMain
                )
            );
        }

        this._forms.isPublished = new ss.forms.Checkbox(
            $.extend(
                {
                    appendTo: this.getBody()
                },
                forms.isPublished
            )
        );

        return this;
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
                this._forms.name
                    .setError(errors.name)
                    .scrollTo()
                    .focus();
                return this;
            }

            if (errors.alias !== undefined) {
                this._forms.alias
                    .setError(errors.alias)
                    .scrollTo()
                    .focus();
                return this;
            }

            if (errors.title !== undefined) {
                this._forms.title
                    .setError(errors.title)
                    .scrollTo()
                    .focus();
                return this;
            }

            if (errors.keywords !== undefined) {
                this._forms.keywords
                    .setError(errors.keywords)
                    .scrollTo()
                    .focus();
                return this;
            }

            if (errors.description !== undefined) {
                this._forms.description
                    .setError(errors.description)
                    .scrollTo()
                    .focus();
                return this;
            }
        } else {
            new ss.panel.section.List();

            if (data.sectionId !== undefined) {
                new ss.window.section.Structure(data.sectionId);
            }
        }
    };
}(window.jQuery, window.ss);
