!function ($, TestS) {
    'use strict';

    /**
     * Block panel
     *
     * @type {Object}
     */
    TestS.Panel.Block = function () {
        this._panel = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Block.prototype = {
        /**
         * Init
         */
        init: function () {
            this._panel = new TestS.Panel({
                controller: "block",
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
                .setDescription(data.description);

            $.each(data.list, $.proxy(function(i, itemData) {
                var $item = TestS.Template.get("panel-list-item");

                $item.addClass("without-buttons");
                $item.find(".settings").remove();
                $item.find(".design").remove();
                $item.find(".text").text(itemData.name);

                switch (itemData.type) {
                    case "text":
                        $item.find(".icon").addClass("fa-font");
                        $item.find(".label").on("click", function() {
                            //new TestS.Panel.Block.Text();
                        });
                        break;
                    default:
                        break;
                }

                this._panel.getBody().append($item);
            }, this));

            this._panel
                .setMaxHeight()
                .removeLoading();
        }
    };
}(window.jQuery, window.TestS);