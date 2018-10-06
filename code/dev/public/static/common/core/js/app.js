ss.add(
    "app",
    {
        /**
         * Singleton flag
         *
         * @var {boolean}
         */
        isSingleton: true,

        /**
         * Wrapper
         *
         * @var {Object}
         */
        ajaxWrapper: null,

        /**
         * Language
         *
         * @var {number}
         */
        language: 0,

        /**
         * Section ID
         *
         * @var {number}
         */
        activeSectionId: 0,

        /**
         * Flag to display blocks in panel from current section
         *
         * @var {boolean}
         */
        isBlockSection: false,

        /**
         * Token
         *
         * @var {String}
         */
        token: "",

        /**
         * DOM elements
         *
         * {Object}
         */
        domElements: {},

        /**
         * Init
         */
        init: function() {
            this.ajaxWrapper = null;
            this.language = 0;
            this.activeSectionId = 0;
            this.isBlockSection = false;
            this.token = "";
            this.domElements = {};
        },

        /**
         * Appends to ajax wrapper
         *
         * @param {Object} object
         */
        append: function (object) {
            this.getWrapper().append(object);
            return this;
        },

        /**
         * Removes element by class name
         *
         * @param {String} className
         */
        remove: function (className) {
            this.getWrapper().find("." + className).remove();
            return this;
        },

        /**
         * Gets wrapper
         *
         * @returns {Object}
         */
        getWrapper: function () {
            if (this.ajaxWrapper === null) {
                this.ajaxWrapper = $("#ajax-wrapper");
            }

            return this.ajaxWrapper;
        },

        /**
         * Sets language
         *
         * @param {number} language
         */
        setLanguage: function (language) {
            this.language = language;
            return this;
        },

        /**
         * Gets language
         *
         * @returns {number}
         */
        getLanguage: function () {
            return this.language;
        },

        /**
         * Sets section ID
         *
         * @param {number} sectionId
         */
        setSectionId: function (sectionId) {
            this.activeSectionId = sectionId;
            return this;
        },

        /**
         * Gets section ID
         *
         * @returns {number}
         */
        getSectionId: function () {
            return this.activeSectionId;
        },

        /**
         * Sets flag to display blocks in panel from current section
         *
         * @param {boolean} isBlockSection
         */
        setIsBlockSection: function (isBlockSection) {
            this.isBlockSection = isBlockSection;
            return this;
        },

        /**
         * Gets flag to display blocks in panel from current section
         *
         * @returns {boolean}
         */
        getIsBlockSection: function () {
            return this.isBlockSection;
        },

        /**
         * Sets token
         *
         * @param {String} token
         */
        setToken: function (token) {
            this.token = token;
            return this;
        },

        /**
         * Gets token
         *
         * @returns {String}
         */
        getToken: function () {
            return this.token;
        },

        /**
         * Adds DOM element to collection
         *
         * @param {String} key
         * @param {Object} value
         */
        addDomElement: function(key, value) {
            this.domElements[key] = value;
            return this;
        },

        /**
         * Gets DOM element
         *
         * @param {String} key
         *
         * @returns {*}
         */
        getDomElement: function(key) {
            return this.domElements[key];
        }
    }
);
