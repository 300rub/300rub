!function ($, Ss) {
    'use strict';

    /**
     * Panel
     *
     * @param {Object} options
     *
     * @type {Ss.Panel.Abstract}
     */
    Ss.Panel.Abstract = function (options) {
        this._set(options);
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    Ss.Panel.Abstract.prototype = {

        /**
         * Constructor
         */
        constructor: Ss.Panel.Abstract,

        /**
         * Panel instance
         *
         * @var {Object}
         */
        _panel: null,

        /**
         * Body
         *
         * @var {Object}
         */
        _body: null,

        /**
         * Options
         *
         * @var {Object}
         */
        _options: {},

        /**
         * User buttons
         *
         * @var {Object}
         */
        _userButtons: null,

        /**
         * Init
         *
         * @param {Object} options
         */
        _set: function (options) {
            this._panel = Ss.Components.Template.get("panel");
            this._body = this._panel.find(".body");
            this._userButtons = $("#user-buttons");

            this._options = $.extend({}, options);

            this
                .setCloseEvents(null)
                ._addDomElement()
                ._setMaxHeight()
                ._loadData();
        },

        /**
         * Sets container's max-height
         *
         * @return {Ss.Panel.Abstract}
         */
        _setMaxHeight: function () {
            this._setPanelMaxHeight();
            $(window).resize(
                $.proxy(
                    function () {
                        this._setPanelMaxHeight();
                    },
                    this
                )
            );

            return this;
        },

        /**
         * Sets container's max-height
         */
        _setPanelMaxHeight: function () {
            this._body.css(
                "max-height",
                function () {
                    return ($(window).outerHeight() - 148);
                }
            );
        },

        /**
         * Gets instance
         *
         * @returns {Object}
         */
        getPanel: function () {
            return this._panel;
        },

        /**
         * Gets body
         *
         * @returns {Object}
         */
        getBody: function () {
            return this._body;
        },

        /**
         * Sets title
         *
         * @param {String} title
         *
         * @returns {Ss.Panel.Abstract}
         */
        setTitle: function (title) {
            this._panel.find(".header .title").text(title);
            return this;
        },

        /**
         * Sets back button
         *
         * @param {function} onClick
         *
         * @returns {Ss.Panel.Abstract}
         */
        setBack: function (onClick) {
            this._panel.find(".header .back")
                .removeClass("hidden")
                .on("click", onClick);

            return this;
        },

        /**
         * Sets description
         *
         * @param {String} description
         *
         * @returns {Ss.Panel.Abstract}
         */
        setDescription: function (description) {
            this._panel.find(".header .description").text(description);
            return this;
        },

        /**
         * Close event
         *
         * @param {function} callback
         *
         * @returns {Ss.Panel.Abstract}
         */
        setCloseEvents: function (callback) {
            this._panel.find(".header .close").off().on(
                "click",
                $.proxy(
                    function () {
                        if ($.type(callback) === "function") {
                            callback();
                        }

                        this._removePanel();
                    },
                    this
                )
            );

            return this;
        },

        /**
         * Removes panel
         *
         * @private
         */
        _removePanel: function () {
            this._panel.addClass("transparent");
            this._userButtons.removeClass("hidden");

            setTimeout(
                $.proxy(
                    function () {
                        this._panel.remove();
                    },
                    this
                ),
                300
            );

            setTimeout(
                $.proxy(
                    function () {
                        this._userButtons.removeClass("transparent");
                    },
                    this
                ),
                50
            );
        },

        /**
         * Adds element to DOM
         *
         * @returns {Ss.Panel.Abstract}
         *
         * @private
         */
        _addDomElement: function () {
            Ss.System.App.remove("panel");
            Ss.System.App.append(this._panel);

            setTimeout(
                $.proxy(
                    function () {
                        this._panel.removeClass("transparent");
                        this._userButtons.addClass("transparent");
                    },
                    this
                ),
                50
            );

            setTimeout(
                $.proxy(
                    function () {
                        this._userButtons.addClass("hidden");
                    },
                    this
                ),
                300
            );

            return this;
        },

        /**
         * Loads data
         *
         * @private
         */
        _loadData: function () {
            var data = {
                group: this._options.group,
                controller: this._options.controller
            };

            if (this._options.id !== undefined) {
                data.data = {
                    id: this._options.id
                };
            }

            new Ss.Components.Ajax(
                {
                    data: data,
                    success: $.proxy(
                        function(data) {
                            this._options.success(data);
                            this._removeLoading();
                        },
                        this
                    ),
                    error: $.proxy(this._onError, this)
                }
            );
        },

        /**
         * On error
         *
         * @param {Object} jqXHR
         */
        _onError: function (jqXHR) {
            var errorTemplate
                = Ss.Components.Error.getAjaxErrorTemplate(jqXHR);

            this._removeLoading();
            this._panel
                .addClass("error");
            this._body.html(errorTemplate);
        },

        /**
         * Removes loading
         *
         * @returns {Ss.Panel.Abstract}
         *
         * @private
         */
        _removeLoading: function () {
            this._panel.removeClass("loading");
            return this;
        },

        /**
         * Sets submit
         *
         * @param {Object} [options]
         *
         * @returns {Ss.Panel.Abstract}
         */
        setSubmit: function (options) {
            var submit = new Ss.Form.Button(
                $.extend(
                    {
                        css: "btn btn-blue submit",
                        appendTo: this._panel.find(".footer")
                    },
                    options
                )
            );

            this._body.keypress(
                function (e) {
                    if (e.which === 13) {
                        submit._panel.click();
                    }
                }
            );

            return this;
        }
    };
}(window.jQuery, window.Ss);
