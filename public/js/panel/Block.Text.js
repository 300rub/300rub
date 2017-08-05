!function ($, TestS) {
    'use strict';

    /**
     * Block panel
     *
     * @type {Object}
     */
    TestS.Panel.Block.Text = function () {
        this._panel = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Block.Text.prototype = {
        /**
         * Init
         */
        init: function () {
            this._panel = new TestS.Panel({
                controller: "text",
                action: "blocks",
                success: $.proxy(this._onLoadDataSuccess, this)
            });
        },

        /**
         * On load panel success
         *
         * @param {Object} [data]
         *
         * @private
         */
        _onLoadDataSuccess: function(data) {
            this._panel
                .setTitle(data.title)
                .setDescription(data.description)
                .setBack(TestS.Panel.Block);

            $.each(data.list, $.proxy(function(i, itemData) {
                var $item = TestS.Template.get("panel-list-item");

                $item.addClass("without-buttons");

                if (itemData["canUpdateDesign"] === true) {
                    $item.find(".design").on("click", function() {
                        new TestS.Panel.Design("text", "design", itemData.id);
                    });
                } else {
                    $item.find(".design").remove();
                }

                $item.find(".settings").remove();

                $item.find(".text").text(itemData.name);
                $item.find(".icon").addClass("fa-font");


                this._panel.getBody().append($item);
            }, this));

            this._panel
                .setMaxHeight()
                .removeLoading();
        }
    };
}(window.jQuery, window.TestS);