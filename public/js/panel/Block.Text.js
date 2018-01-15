!function ($, TestS) {
    'use strict';

    /**
     * Block text panel
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
                group: "text",
                controller: "blocks",
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
                .setBack(function() {
                    new TestS.Panel.Block();
                });

            $.each(data.list, $.proxy(function(i, itemData) {
                var $item = TestS.Components.Template.get("panel-list-item");

                $item.addClass("without-buttons");

                var $designIcon = $item.find(".design");
                if (itemData["canUpdateDesign"] === true) {
                    $designIcon.on("click", function() {
                        new TestS.Panel.Design({
                            group: "text",
                            controller: "design",
                            id: itemData.id,
                            success: function () {
                                new TestS.Panel.Block.Text();
                            }
                        });
                    });
                } else {
                    $designIcon.remove();
                }

                var $settingsIcon = $item.find(".settings");
                if (itemData["canUpdateDesign"] === true) {
                    $settingsIcon.on("click", function() {
                        new TestS.Panel.Block.Text.Settings(itemData.id);
                    });
                } else {
                    $settingsIcon.remove();
                }

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