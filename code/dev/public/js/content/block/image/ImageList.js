!function ($, ss) {
    'use strict';

    /**
     * Image list
     *
     * @param {Object} options
     */
    ss.content.block.image.ImageList = function (options) {
        this._options = $.extend({}, options);

        this._container = null;

        this.init();
    };

    /**
     * Constructor
     */
    ss.content.block.image.ImageList.prototype.constructor = ss.content.block.image.ImageList;

    /**
     * Init
     */
    ss.content.block.image.ImageList.prototype.init = function () {
        this
            ._createContainer()
            ._setList()
            ._setSortable()
            ._setAddButton()
        ;
    };

    /**
     * Creates container
     *
     * @returns {ss.content.block.image.ImageList}
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._createContainer = function () {
        this._container = ss.components.Template.get("image-sort-container");

        if (this._options.appendTo !== undefined) {
            this._container.appendTo(this._options.appendTo);
        }

        return this;
    };

    /**
     * Sets List
     *
     * @returns {ss.content.block.image.ImageList}
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._setList = function () {
        if (this._options.list === undefined) {
            return this;
        }

        $.each(this._options.list, $.proxy(function(i, itemData) {
            var itemElement = ss.components.Template.get("image-sort-item");
            var image = itemElement.find("img");
            var buttons = itemElement.find(".buttons");

            image.attr("src", itemData.url);

            itemElement.appendTo(this._container);

            new ss.forms.Button(
                {
                    css: "btn btn-blue btn-small edit",
                    icon: "fas fa-edit",
                    label: '',
                    appendTo: buttons,
                    onClick: function () {
                        //
                    }
                }
            );

            new ss.forms.Button(
                {
                    css: "btn btn-red btn-small remove",
                    icon: "fas fa-trash",
                    label: '',
                    appendTo: buttons,
                    onClick: function () {
                        //
                    }
                }
            );
        }, this));

        return this;
    };

    /**
     * Sets sortable
     *
     * @returns {ss.content.block.image.ImageList}
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._setSortable = function () {
        if (this._options.isSingleton === true) {
            return this;
        }

        this._container.sortable(
            {
                items: ".image-sort-item"
            }
        );

        return this;
    };

    /**
     * Sets add button
     *
     * @returns {ss.content.block.image.ImageList}
     *
     * @private
     */
    ss.content.block.image.ImageList.prototype._setAddButton = function () {


        return this;
    };
}(window.jQuery, window.ss);
