!function ($, c) {
    "use strict";

    /**
     * Window login handler
     */
    c.Window.prototype.login = function () {
        var $container = c.$templates.find(".j-window-login-container").clone();
        $container.appendTo(this.$container);

        $.form(this.data.forms, $container);

        $container.find(".j-t__login").focus();

        $container.find(".j-t__login").val("login");
        $container.find(".j-t__password").val("password");

        var t = this;
        $container.keypress(function (e) {
            var key = e.which;
            if (key == 13) {
                t._submit();
                return false;
            }
        });
    };
}(window.jQuery, window.Core);