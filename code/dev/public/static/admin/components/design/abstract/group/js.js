!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignAbstractGroup";

    var parameters = {
        /**
         * Editor container
         *
         * @var {Object}
         */
        editorContainer: null,

        /**
         * Group container
         *
         * @var {Object}
         */
        groupContainer: null,

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [],

        /**
         * Flag of values
         *
         * @var {boolean}
         */
        hasValues: false,

        /**
         * Namespace
         *
         * @var {String}
         */
        namespace: "",

        /**
         * Update sample event
         *
         * @var {String}
         */
        updateSampleEventName: "",

        /**
         * Init
         */
        init: function () {
        },

        /**
         * Creates editor
         *
         * @param {Object} options
         */
        create: function (options) {
            this
                .extendOptions(options)
                .setLabels(this.getOption("labels"))
                .setEditorContainer()
                .setGroupContainer()
                .setValues()
                .checkValues()
                .setTitle()
                .setNamespace()
                .setUpdateSampleEventName()
                .updateSample();
        },

        /**
         * Sets design container
         */
        setEditorContainer: function () {
            this.editorContainer = this.getOption("editorContainer");
            return this;
        },

        /**
         * Gets editor container
         *
         * @returns {Object}
         */
        getEditorContainer: function () {
            return this.editorContainer;
        },

        /**
         * Sets editor container
         */
        setGroupContainer: function () {
            if (this.getOption("groupContainerSelector") !== null) {
                this.groupContainer = this.editorContainer.find(
                    this.getOption("groupContainerSelector")
                );
            }

            return this;
        },

        /**
         * Gets group container
         *
         * @returns {Object}
         */
        getGroupContainer: function () {
            return this.groupContainer;
        },

        /**
         * Sets values
         */
        setValues: function () {
            this.hasValues = false;

            $.each(
                this.fields,
                $.proxy(
                    function (index, key) {
                        if (this.getOption(["values", key]) !== null) {
                            this[key] = this.getOption(["values", key]);
                            this.hasValues = true;
                        }
                    },
                    this
                )
            );

            return this;
        },

        /**
         * Checks values
         */
        checkValues: function () {
            if (this.hasValues === false
                && this.groupContainer !== null
            ) {
                this.groupContainer.remove();
            }

            return this;
        },

        /**
         * Sets title
         */
        setTitle: function () {
            if (this.getOption("title") !== null
                && this.groupContainer !== null
            ) {
                this.groupContainer
                    .find(".category-title")
                    .text(this.getOption("title"));
            }

            return this;
        },

        /**
         * Sets namespace
         */
        setNamespace: function () {
            this.namespace = this.getOption("namespace", "");
            return this;
        },

        /**
         * Sets update sample event
         */
        setUpdateSampleEventName: function () {
            this.updateSampleEventName
                = this.getOption("updateSampleEventName");
            return this;
        },

        /**
         * Updates the sample CSS
         */
        updateSample: function () {
            this.editorContainer.trigger(this.updateSampleEventName);
        },

        /**
         * Updates block CSS
         */
        update: function () {
            this.editorContainer.trigger("update");
            this.updateSample();
        },

        /**
         * Generates CSS
         *
         * @returns {String}
         */
        generateCss: function () {
            return "";
        },

        /**
         * Flag of animation
         *
         * @returns {boolean}
         */
        hasAnimation: function () {
            return false;
        },

        /**
         * Gets data
         *
         * @returns {Object}
         */
        getData: function () {
            var data = {};

            $.each(
                this.fields,
                $.proxy(
                    function (key, field) {
                        if (this[field] === undefined
                            || this[field] === null
                        ) {
                            return false;
                        }

                        var name = field;
                        if (this.namespace !== "") {
                            name = this.namespace + "." + field;
                        }

                        data[name] = this[field];
                    },
                    this
                )
            );

            return data;
        },

        /**
         * Gets int value
         *
         * @param {Number} value
         *
         * @returns {Number}
         */
        getIntValue: function (value) {
            return parseInt(value, 10) || 0;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
