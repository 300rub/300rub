!function ($, TestS) {
    'use strict';

    /**
     * Panel
     *
     * @param {Object} options
     *
     * @type {TestS.Panel}
     */
    TestS.Panel = function (options) {
        this._options = $.extend({}, options);
        this.$_instance = null;
        this.$_body = null;
        this.$_userButtons = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.prototype = {
        /**
         * Init
         */
        init: function () {
            this.$_instance = TestS.Template.get("panel");
            this.$_body = this.$_instance.find(".body");
            this.$_userButtons = $("#user-buttons");

            this
                .setCloseEvents()
                ._addDomElement()
                ._loadData();
        },

        /**
         * Sets container's max-height
         *
         * @return {TestS.Panel}
         */
        setMaxHeight: function() {
            var setMaxHeight = $.proxy(function () {
                this.$_body.css("max-height", $.proxy(function () {
                    return $(window).outerHeight() - 148;
                }, this));
            }, this);

            setMaxHeight();
            $(window).resize($.proxy(function () {
                setMaxHeight();
            }, this));

            return this;
        },

        /**
         * Gets instance
         *
         * @returns {Object}
         */
        getInstance: function() {
            return this.$_instance;
        },

        /**
         * Gets body
         *
         * @returns {Object}
         */
        getBody: function() {
            return this.$_body;
        },

        /**
         * Sets title
         *
         * @param {String} title
         *
         * @returns {TestS.Panel}
         */
        setTitle: function(title) {
            this.getInstance().find(".header .title").text(title);
            return this;
        },

        /**
         * Sets back button
         *
         * @param {function} onClick
         *
         * @returns {TestS.Panel}
         */
        setBack: function (onClick) {
            this.getInstance().find(".header .back")
                .removeClass("hidden")
                .on("click", onClick);

            return this;
        },

        /**
         * Sets description
         *
         * @param {String} description
         *
         * @returns {TestS.Panel}
         */
        setDescription: function(description) {
            this.getInstance().find(".header .description").text(description);
            return this;
        },

        /**
         * Close event
         *
         * @param {function} callback
         *
         * @returns {TestS.Panel}
         */
        setCloseEvents: function(callback) {
            this.getInstance().find(".header .close").off().on("click", $.proxy(function() {
                if ($.type(callback) === "function") {
                    callback();
                }

                this._removePanel();
            }, this));

            return this;
        },

        /**
         * Removes panel
         *
         * @private
         */
        _removePanel: function() {
            this.getInstance().addClass("transparent");
            this.$_userButtons.removeClass("hidden");

            setTimeout($.proxy(function() {
                this.getInstance().remove();
            }, this), 300);

            setTimeout($.proxy(function() {
                this.$_userButtons.removeClass("transparent");
            }, this), 50);
        },

        /**
         * Adds element to DOM
         *
         * @returns {TestS.Panel}
         *
         * @private
         */
        _addDomElement: function() {
            TestS.remove("panel");
            TestS.append(this.getInstance());

            setTimeout($.proxy(function() {
                this.getInstance().removeClass("transparent");
                this.$_userButtons.addClass("transparent");
            }, this), 50);

            setTimeout($.proxy(function() {
                this.$_userButtons.addClass("hidden");
            }, this), 300);

            return this;
        },

        /**
         * Loads data
         *
         * @private
         */
        _loadData: function() {
            var data = {
                group: this._options.group,
                controller: this._options.controller
            };

            if (this._options.id !== undefined) {
                data.data = {
                    id: this._options.id
                };
            }

            new TestS.Ajax({
                data: data,
                success: this._options.success,
                error: $.proxy(this.onError, this)
            });
        },

        /**
         * On error
         *
         * @param {Object} jqXHR
         */
        onError: function (jqXHR) {
            var $errorTemplate = TestS.Ajax.getErrorTemplate(jqXHR);
            this.getInstance()
                .removeClass("loading")
                .addClass("error");
            this.getBody().html($errorTemplate);
        },

        /**
         * Removes loading
         *
         * @returns {TestS.Panel}
         */
        removeLoading: function() {
            this.getInstance().removeClass("loading");
            return this;
        },

        /**
         * Sets submit
         *
         * @param {Object} [options]
         *
         * @returns {TestS.Panel}
         */
        setSubmit: function(options) {
            var submit = new TestS.Form.Button(
                $.extend(
                    {
                        css: "btn btn-blue submit",
                        appendTo: this.getInstance().find(".footer")
                    },
                    options
                )
            );

            this.getBody().keypress(function(e) {
                if (e.which === 13) {
                    submit.getInstance().click();
                }
            });

            return this;
        }
    };
}(window.jQuery, window.TestS);