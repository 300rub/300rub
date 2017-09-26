!function ($, TestS) {
    'use strict';

    /**
     * Block text settings panel
     *
     * @type {Object}
     */
    TestS.Panel.Block.Text.Settings = function (id) {
        this._panel = null;
        this._id = id;

        this._name = null;
        this._type = null;
        this._hasEditor = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Block.Text.Settings.prototype = {
        /**
         * Init
         */
        init: function () {
            this._panel = new TestS.Panel({
                controller: "text",
                action: "settings",
                id: this._id,
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
            this._name = new TestS.Form(
                $.extend(
                    {
                        appendTo: this._panel.getBody(),
                        type: "text"
                    },
                    data["forms"]["name"]
                )
            );

            this._type = new TestS.Form(
                $.extend(
                    {
                        appendTo: this._panel.getBody(),
                        type: "select"
                    },
                    data["forms"]["type"]
                )
            );

            this._hasEditor = new TestS.Form(
                $.extend(
                    {
                        appendTo: this._panel.getBody(),
                        type: "checkboxOnOff"
                    },
                    data["forms"]["hasEditor"]
                )
            );

            this._panel
                .setTitle(data.title)
                .setDescription(data.description)
                .setBack(function() {
                    new TestS.Panel.Block.Text();
                })
                .setSubmit({
                    label: data["button"]["label"],
                    icon: data["id"] === 0 ? "fa-plus" : "fa-check",


                    forms: [this._name, this._type, this._hasEditor],
                    ajax: {
                        data: {
                            controller: "text",
                            action: "block"
                        },
                        type: data["id"] === 0 ? "POST" : "PUT",
                        success: $.proxy(this._onSuccess, this),
                        error: $.proxy(this._window.onError, this._window)
                    }
                })
                .setMaxHeight()
                .removeLoading();
        },

        /**
         * On success
         *
         * @param {Object} data
         *
         * @private
         */
        _onSuccess: function(data) {
            if ($.type(data.errors) === "object"
                && data["errors"]["name"] !== undefined
            ) {
                this._name
                    .setError(data["errors"]["name"])
                    .scrollTo()
                    .focus();
            } else {
                new TestS.Panel.Block.Text();
            }
        }
    };
}(window.jQuery, window.TestS);