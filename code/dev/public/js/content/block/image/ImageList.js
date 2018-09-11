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
        this._container = ss.components.Template.get("image-sort-container");

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
    };

    ss.content.block.image.ImageList.prototype.getContainer = function () {
        return this._container;
    };
}(window.jQuery, window.ss);
