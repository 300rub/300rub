/**
 * Main file to load instances
 *
 * @type {Object}
 */
window.ss = {
    /**
     * Constants
     */
    constants: {
        ABSTRACT: "abstract"
    },

    /**
     * Map
     *
     * @type {Object}
     */
    map: {},

    /**
     * Instances
     *
     * @type {Object}
     */
    instances: {},

    /**
     * Adds object to map
     *
     * @param {String} name
     * @param {Object} parameters
     *
     * @returns {Window.ss}
     */
    add: function(name, parameters) {
        if ($.type(name) !== "string") {
            throw "Name should be a string";
        }

        if (this.map[name] !== undefined) {
            throw "Instance with the name [" + name + "] is already configured";
        }

        if ($.type(parameters) !== "object") {
            throw "Parameters should be an object";
        }

        if ($.type(parameters.init) !== "function") {
            throw "Object parameters.init should be a function";
        }

        this.map[name] = parameters;

        return this;
    },

    /**
     * Sets instance to collection
     *
     * @param {String} name
     *
     * @returns {Window.ss}
     */
    set: function(name) {
        if (this.instances[name] !== undefined) {
            return this;
        }

        var parameters = this.map[name];
        if (parameters === undefined) {
            throw "Unable to get instance info by name [" + name + "]";
        }

        var parent = this.getParent(name);

        this.instances[name] = function() {
            if (parent !== null) {
                parent.call(this);
            }
        };

        this.instances[name].prototype = {};
        if (parent !== null) {
            this.instances[name].prototype = Object.create(parent.prototype);
        }

        this.instances[name].prototype = $.extend(
            {},
            this.instances[name].prototype,
            this.map[name]
        );

        return this;
    },

    /**
     * Gets instance by name
     *
     * @param {String|*} name
     *
     * @returns {Object}
     */
    get: function(name) {
        if (this.instances[name] === undefined) {
            this.set(name);
        }

        return this.instances[name];
    },

    /**
     * Initialises instance
     *
     * @param {String} name
     * @param {Object} options
     *
     * @returns {Object}
     */
    init: function(name, options) {
        var instance = this.get(name);

        var instanceObject = new instance();

        instanceObject
            .setOptions($.extend({}, options))
            .init();

        return instanceObject;
    },

    /**
     * Gets parent
     *
     * @param {String} name
     *
     * @returns {Object}
     */
    getParent: function(name) {
        if (name === this.constants.ABSTRACT) {
            return null;
        }

        if (this.map[name].parent === undefined) {
            return this.get(this.constants.ABSTRACT);
        }

        return this.get(this.map[name].parent);
    }
};
