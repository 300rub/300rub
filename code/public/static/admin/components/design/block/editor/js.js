!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignBlockEditor";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractEditor",

        /**
         * Margin
         *
         * @var {Object}
         */
        margin: null,

        /**
         * Margin sample
         *
         * @var {Object}
         */
        marginSample: null,

        /**
         * Padding
         *
         * @var {Object}
         */
        padding: null,

        /**
         * Padding sample
         *
         * @var {Object}
         */
        paddingSample: null,

        /**
         * Background
         *
         * @var {Object}
         */
        background: null,

        /**
         * Background sample
         *
         * @var {Object}
         */
        backgroundSample: null,

        /**
         * Border
         *
         * @var {Object}
         */
        border: null,

        /**
         * Border sample
         *
         * @var {Object}
         */
        borderSample: null,

        /**
         * Init
         */
        init: function () {
            this.margin = null;
            this.marginSample = null;

            this.padding = null;
            this.paddingSample = null;

            this.background = null;
            this.backgroundSample = null;

            this.border = null;
            this.borderSample = null;

            this.create();

            this
                .setSamples()
                .setGroupEditors()
                .setUpdateEvents()
                .updateSamples();
        },

        /**
         * Sets samples
         */
        setSamples: function () {
            var selector;

            selector = "margin-sample-" + this.getUniqueId();
            this.getEditorContainer().find(".margin-sample").addClass(selector);
            this.marginSample = this.getEditorContainer()
                .find(".margin-container .styles-sample-container")
                .attr("data-selector", selector);

            selector = "padding-sample-" + this.getUniqueId();
            this.getEditorContainer()
                .find(".padding-sample-container")
                .addClass(selector);
            this.paddingSample = this.getEditorContainer()
                .find(".padding-container .styles-sample-container")
                .attr("data-selector", selector);

            selector = "background-sample-" + this.getUniqueId();
            this.getEditorContainer()
                .find(".background-sample")
                .addClass(selector);
            this.backgroundSample = this.getEditorContainer()
                .find(".background-container .styles-sample-container")
                .attr("data-selector", selector);

            selector = "border-sample-" + this.getUniqueId();
            this.getEditorContainer().find(".border-sample").addClass(selector);
            this.borderSample = this.getEditorContainer()
                .find(".border-container .styles-sample-container")
                .attr("data-selector", selector);

            return this;
        },

        /**
         * Sets group editors
         */
        setGroupEditors: function () {
            this.margin = ss.init(
                "adminComponentsDesignBlockMargin",
                {
                    editorContainer: this.getEditorContainer(),
                    labels: this.getLabels(),
                    values: this.getValues(),
                    namespace: this.getNamespace()
                }
            );

            this.padding = ss.init(
                "adminComponentsDesignBlockPadding",
                {
                    editorContainer: this.getEditorContainer(),
                    labels: this.getLabels(),
                    values: this.getValues(),
                    namespace: this.getNamespace()
                }
            );

            this.background = ss.init(
                "adminComponentsDesignBlockBackground",
                {
                    editorContainer: this.getEditorContainer(),
                    labels: this.getLabels(),
                    values: this.getValues(),
                    namespace: this.getNamespace(),
                    image: this.getOption("image"),
                    blockId: this.getOption("blockId")
                }
            );

            this.border = ss.init(
                "adminComponentsDesignBlockBorder",
                {
                    editorContainer: this.getEditorContainer(),
                    labels: this.getLabels(),
                    values: this.getValues(),
                    namespace: this.getNamespace()
                }
            );

            return this;
        },

        /**
         * Sets update events
         */
        setUpdateEvents: function () {
            this.getEditorContainer()
                .on(
                    "update",
                    $.proxy(this.onUpdate, this)
                )
                .on(
                    "update-margin-sample",
                    $.proxy(this.onUpdateMarginSample, this)
                )
                .on(
                    "update-padding-sample",
                    $.proxy(this.onUpdatePaddingSample, this)
                ).on(
                    "update-background-sample",
                    $.proxy(this.onUpdateBackgroundSample, this)
                ).on(
                    "update-border-sample",
                    $.proxy(this.onUpdateBorderSample, this)
                );

            return this;
        },

        /**
         * Updates samples
         */
        updateSamples: function () {
            this
                .onUpdateMarginSample()
                .onUpdatePaddingSample()
                .onUpdateBackgroundSample()
                .onUpdateBorderSample();
        },

        /**
         * On update event
         */
        onUpdate: function () {
            var html = "<style>";

            html += this.getSelector() + "{" + this.generateCss(false) + "}";

            html += this.getSelector();
            html += ":hover{" + this.generateCss(true) + "}";

            html += "</style>";

            this.getCssContainer().html(html);
        },

        /**
         * On update margin sample
         */
        onUpdateMarginSample: function () {
            var css = this.margin.generateCss(false);
            var cssHover = this.margin.generateCss(true);

            if (this.margin.hasAnimation() === true) {
                var cssAnimation = "";
                cssAnimation += "-webkit-transition:margin .3s;";
                cssAnimation += "-ms-transition:margin .3s;";
                cssAnimation += "-o-transition:margin .3s;";
                cssAnimation += "transition:margin .3s;";

                css += cssAnimation;
                cssHover += cssAnimation;
            }

            var selector = "." + this.marginSample.data("selector");

            var html = "<style>";

            html += selector + "{" + css + "}";

            html += selector + ":hover{" + cssHover + "}";

            html += "</style>";

            this.marginSample.html(html);

            return this;
        },

        /**
         * On update padding sample
         */
        onUpdatePaddingSample: function () {
            var css = this.padding.generateCss(false);
            var cssHover = this.padding.generateCss(true);

            if (this.padding.hasAnimation() === true) {
                var cssAnimation = "";
                cssAnimation += "-webkit-transition:padding .3s;";
                cssAnimation += "-ms-transition:padding .3s;";
                cssAnimation += "-o-transition:padding .3s;";
                cssAnimation += "transition:padding .3s;";

                css += cssAnimation;
                cssHover += cssAnimation;
            }

            var selector = "." + this.paddingSample.data("selector");

            var html = "<style>";

            html += selector + "{" + css + "}";

            html += selector + ":hover{" + cssHover + "}";

            html += "</style>";

            this.paddingSample.html(html);

            return this;
        },

        /**
         * On update background sample
         */
        onUpdateBackgroundSample: function () {
            var css = this.background.generateCss(false);
            var cssHover = this.background.generateCss(true);

            if (this.background.hasAnimation() === true) {
                var cssAnimation = "";
                cssAnimation += "-webkit-transition:background-color .3s;";
                cssAnimation += "-ms-transition:background-color .3s;";
                cssAnimation += "-o-transition:background-color .3s;";
                cssAnimation += "transition:background-color .3s;";

                css += cssAnimation;
                cssHover += cssAnimation;
            }

            var selector = "." + this.backgroundSample.data("selector");

            var html = "<style>";

            html += selector + "{" + css + "}";

            html += selector + ":hover{" + cssHover + "}";

            html += "</style>";

            this.backgroundSample.html(html);

            return this;
        },

        /**
         * On update border sample
         */
        onUpdateBorderSample: function () {
            var css = this.border.generateCss(false);
            var cssHover = this.border.generateCss(true);

            if (this.border.hasAnimation() === true) {
                var cssAnimation = "";
                cssAnimation += "-webkit-transition:border-radius .3s,";
                cssAnimation += "border-width .3s,border-color .3s;";
                cssAnimation += "-ms-transition:border-radius .3s,";
                cssAnimation += "border-width .3s,border-color .3s;";
                cssAnimation += "-o-transition:border-radius .3s,";
                cssAnimation += "border-width .3s,border-color .3s;";
                cssAnimation += "transition:border-radius .3s,";
                cssAnimation += "border-width .3s,border-color .3s;";
                css += cssAnimation;
                cssHover += cssAnimation;
            }

            var selector = "." + this.borderSample.data("selector");

            var html = "<style>";

            html += selector + "{" + css + "}";

            html += selector + ":hover{" + cssHover + "}";

            html += "</style>";

            this.borderSample.html(html);

            return this;
        },

        /**
         * Generates CSS
         *
         * @param {boolean} isHover
         *
         * @returns {String}
         */
        generateCss: function (isHover) {
            var css = "";

            css += this.margin.generateCss(isHover);
            css += this.padding.generateCss(isHover);
            css += this.background.generateCss(isHover);

            css += this.border.generateCss(isHover);

            var animation = [];

            if (this.margin.hasAnimation() === true) {
                animation.push("margin .3s");
            }

            if (this.padding.hasAnimation() === true) {
                animation.push("padding .3s");
            }

            if (this.background.hasAnimation() === true) {
                animation.push("background-color .3s");
            }

            if (this.border.hasAnimation() === true) {
                animation.push("border-radius .3s");
                animation.push("border-width .3s");
                animation.push("border-color .3s");
            }

            if (animation.length > 0) {
                var animationString = animation.join(",");
                css += "-webkit-transition:" + animationString + ";";
                css += "-ms-transition:" + animationString + ";";
                css += "-o-transition:" + animationString + ";";
                css += "transition:" + animationString + ";";
            }

            return css;
        },

        /**
         * Gets data
         *
         * @returns {Object}
         */
        getData: function () {
            var data = {};

            $.extend(data, this.margin.getData());
            $.extend(data, this.padding.getData());
            $.extend(data, this.background.getData());
            $.extend(data, this.border.getData());

            return data;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
