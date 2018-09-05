!function ($, ss) {
    'use strict';

    /**
     * Text form
     *
     * @param {Object} options
     */
    ss.forms.Text = function (options) {
        ss.forms.Abstract.call(this, "form-container-text", options);
        this.init();
    };

    /**
     * Text form prototype
     *
     * @type {Object}
     */
    ss.forms.Text.prototype = Object.create(ss.forms.Abstract.prototype);

    /**
     * Constructor
     */
    ss.forms.Text.prototype.constructor = ss.forms.Text;

    /**
     * Init
     */
    ss.forms.Text.prototype.init = function () {
        var container = this.getForm().find(".form-instance-container");
        var prefixOption = this.getOption("prefix");
        var prefixMaxLength = this.getOption("prefixMaxLength");
        var prefixElement = container.find(".prefix");
        var postfixOption = this.getOption("postfix");
        var postfixElement = container.find(".postfix");

        if (prefixOption !== null) {
            container.addClass("form-instance-container-prefix");

            if (prefixMaxLength !== null) {
                var prefixLength = prefixOption.length;
                if (prefixLength > prefixMaxLength) {
                    prefixOption = "..." + prefixOption.substr(
                        (prefixLength - prefixMaxLength),
                        prefixMaxLength
                    );
                }
            }

            prefixElement.text(prefixOption);
        } else {
            prefixElement.remove();
        }

        if (postfixOption !== null) {
            container.addClass("form-instance-container-postfix");
            postfixElement.text(postfixOption);
        } else {
            postfixElement.remove();
        }

        this.getInstance().val(this.getOption("value"));
    };
}(window.jQuery, window.ss);
