!function ($, ss) {
    'use strict';

    /**
     * Seo forms
     *
     * {Object} formData
     */
    ss.forms.components.Seo = function (formData) {
        this._formData = $.extend({}, formData);
        this._forms = {};
        this._container = null;

        this.init();
    };

    /**
     * Constructor
     */
    ss.forms.components.Seo.prototype.constructor = ss.forms.components.Seo;

    /**
     * Init
     */
    ss.forms.components.Seo.prototype.init = function () {
        this
            ._setContainer()
            ._setForms()
        ;
    };

    /**
     * Sets container
     *
     * @returns {ss.forms.components.Seo}
     *
     * @private
     */
    ss.forms.components.Seo.prototype._setContainer = function () {
        this._container = ss.components.Template.get("form-container-seo");
        return this;
    };

    /**
     * Gets container
     *
     * @returns {Object}
     */
    ss.forms.components.Seo.prototype.getContainer = function () {
        return this._container;
    };

    /**
     * Sets forms
     *
     * @returns {ss.forms.components.Seo}
     *
     * @private
     */
    ss.forms.components.Seo.prototype._setForms = function () {
        var defaultContainer = this._container.find(".default");
        var seoContainer = this._container.find(".seo");

        if (this._forms.name !== undefined) {
            this._forms.name = new ss.forms.Text(
                $.extend(
                    {
                        appendTo: defaultContainer
                    },
                    this._forms.name
                )
            );
        }

        if (this._forms.alias !== undefined) {
            this._forms.alias = new ss.forms.Text(
                $.extend(
                    {
                        appendTo: defaultContainer
                    },
                    this._forms.alias
                )
            );
        }

        if (this._forms.title !== undefined) {
            this._forms.title = new ss.forms.Text(
                $.extend(
                    {
                        appendTo: seoContainer
                    },
                    this._forms.title
                )
            );
        }

        if (this._forms.keywords !== undefined) {
            this._forms.keywords = new ss.forms.Text(
                $.extend(
                    {
                        appendTo: seoContainer
                    },
                    this._forms.keywords
                )
            );
        }

        if (this._forms.description !== undefined) {
            this._forms.description = new ss.forms.Text(
                $.extend(
                    {
                        appendTo: seoContainer
                    },
                    this._forms.description
                )
            );
        }

        return this;
    };

    /**
     * Gets forms
     *
     * @returns {Object}
     */
    ss.forms.components.Seo.prototype.getForms = function () {
        return this._forms;
    };
}(window.jQuery, window.ss);
