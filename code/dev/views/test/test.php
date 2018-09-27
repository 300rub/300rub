<script>

window.ss = {
    map: {},
    instances: {},
    constants: {
        ABSTRACT: "abstract"
    },

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

        if (parameters.isAbstract === undefined) {
            this.instances[name].prototype.constructor = this.instances[name];
        }

        this.instances[name].prototype = $.extend(
            {},
            this.instances[name].prototype,
            this.map[name]
        );

        return this;
    },

    get: function(name) {
        if (this.instances[name] === undefined) {
            this.set(name);
        }

        return this.instances[name];
    },

    init: function(name, options) {
        var instance = this.get(name);

        var instanceObject = new instance();

        instanceObject
            .setOptions($.extend({}, options))
            .init();

        return instanceObject;
    },

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

ss.add(
    "child",
    {
        parent: "parent",

        init: function() {
            this.exec();
        },

        exec: function() {
            console.log(this.getOption("aaa"));
        }
    }
);

ss.add(
    "parent",
    {
        isAbstract: true,

        init: function() {
        }
    }
);

ss.add(
    ss.constants.ABSTRACT,
    {
        isAbstract: true,

        options: {},

        init: function() {
        },

        setOptions: function(options) {
            this.options = $.extend({}, options);
            return this;
        },

        getOption: function(pointer, defaultValue) {
            if (defaultValue === undefined) {
                defaultValue = null;
            }

            if ($.type(pointer) !== "array") {
                if (this.options[pointer] === undefined) {
                    return defaultValue;
                }

                return this.options[pointer];
            }

            var options = this.options;
            var number;
            var last = pointer.length - 1;
            for (number = 0; number <= last; pointer++) {
                if (options[pointer[number]] === undefined) {
                    return defaultValue;
                }

                if (number === last) {

                }

                options = 
            }
        },

        getOptions: function() {
            return this.options;
        }
    }
);

$(document).ready(function(){
    ss.init("child", {aaa: 444});
});

</script>