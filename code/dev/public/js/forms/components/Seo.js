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
            ._setForms();
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
        var toggleSeo = this._container.find(".toggle-seo");

        toggleSeo.on("click", $.proxy(function() {
            if (this._container.hasClass("opened") === true) {
                this._container.removeClass("opened");
            } else {
                this._container.addClass("opened");
            }
        }, this));

        if (this._formData.name !== undefined) {
            this._forms.name = new ss.forms.Text(
                $.extend(
                    {
                        appendTo: defaultContainer
                    },
                    this._formData.name
                )
            );
        }

        if (this._formData.alias !== undefined) {
            this._forms.alias = new ss.forms.Text(
                $.extend(
                    {
                        appendTo: defaultContainer
                    },
                    this._formData.alias
                )
            );
        }

        if (this._formData.title !== undefined) {
            this._forms.title = new ss.forms.Text(
                $.extend(
                    {
                        appendTo: seoContainer
                    },
                    this._formData.title
                )
            );
        }

        if (this._formData.keywords !== undefined) {
            this._forms.keywords = new ss.forms.Text(
                $.extend(
                    {
                        appendTo: seoContainer
                    },
                    this._formData.keywords
                )
            );
        }

        if (this._formData.description !== undefined) {
            this._forms.description = new ss.forms.Text(
                $.extend(
                    {
                        appendTo: seoContainer
                    },
                    this._formData.description
                )
            );
        }

        if (this._formData.title.value !== ""
            || this._formData.keywords.value !== ""
            || this._formData.description.value !== ""
        ) {
            this._container.addClass("opened");
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
