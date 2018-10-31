!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignTextEditor";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractEditor",

        /**
         * Size
         *
         * @var {Object}
         */
        size: null,

        /**
         * Family
         *
         * @var {Object}
         */
        family: null,

        /**
         * Color
         *
         * @var {Object}
         */
        color: null,

        /**
         * Align
         *
         * @var {Object}
         */
        align: null,

        /**
         * Italic
         *
         * @var {Object}
         */
        italic: null,

        /**
         * Bold
         *
         * @var {Object}
         */
        bold: null,

        /**
         * Line height
         *
         * @var {Object}
         */
        lineHeight: null,

        /**
         * Decoration
         *
         * @var {Object}
         */
        decoration: null,

        /**
         * Letter spacing
         *
         * @var {Object}
         */
        letterSpacing: null,

        /**
         * Transform
         *
         * @var {Object}
         */
        transform: null,

        /**
         * Hover
         *
         * @var {Object}
         */
        hover: null,

        /**
         * Sample
         *
         * @var {Object}
         */
        sample: null,

        /**
         * Init
         */
        init: function () {
            this.size = null;
            this.family = null;
            this.color = null;
            this.align = null;
            this.italic = null;
            this.bold = null;
            this.lineHeight = null;
            this.decoration = null;
            this.letterSpacing = null;
            this.transform = null;
            this.hover = null;

            this.sample = null;

            this.create();

            this
                .setSample()
                .setEditors()
                .setUpdateEvents()
                .onUpdateTextSample();
        },

        /**
         * Sets samples
         */
        setSample: function () {
            var selector = "text-sample-" + this.getUniqueId();

            this.getEditorContainer()
                .find(".sample")
                .addClass(selector)
                .text(this.getLabel("textSample"));

            this.sample = this.getEditorContainer()
                .find(".styles-sample-container")
                .attr("data-selector", selector);

            return this;
        },

        /**
         * Sets group editors
         */
        setEditors: function () {
            var commonContainer
                = this.getEditorContainer().find(".common-container");
            var hoverContainer
                = this.getEditorContainer().find(".hover-container");

            var options = {
                editorContainer: this.getEditorContainer(),
                labels: this.getLabels(),
                values: this.getValues(),
                namespace: this.getNamespace(),
                commonContainer: commonContainer,
                hoverContainer: hoverContainer,
                updateSampleEventName: "update-text-sample"
            };

            this.family = ss.init(
                "adminComponentsDesignTextFamily",
                options
            );

            this.size = ss.init(
                "adminComponentsDesignTextSize",
                options
            );

            this.color = ss.init(
                "adminComponentsDesignTextColor",
                options
            );

            this.italic = ss.init(
                "adminComponentsDesignTextItalic",
                options
            );

            this.bold = ss.init(
                "adminComponentsDesignTextBold",
                options
            );

            this.align = ss.init(
                "adminComponentsDesignTextAlign",
                options
            );

            this.lineHeight = ss.init(
                "adminComponentsDesignTextLineHeight",
                options
            );

            this.decoration = ss.init(
                "adminComponentsDesignTextDecoration",
                options
            );

            this.letterSpacing = ss.init(
                "adminComponentsDesignTextLetterSpacing",
                options
            );

            this.transform = ss.init(
                "adminComponentsDesignTextTransform",
                options
            );

            this.hover = ss.init(
                "adminComponentsDesignTextHover",
                options
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
                    "update-text-sample",
                    $.proxy(this.onUpdateTextSample, this)
                );

            return this;
        },

        /**
         * On update event
         */
        onUpdate: function () {
            var html = "<style>";

            html += this.getSelector() + "{" + this.generateCss(false) + "}";

            if (this.hover.getHasHover() === true) {
                html += this.getSelector();
                html += ":hover{" + this.generateCss(true) + "}";
            }

            html += "</style>";

            this.getCssContainer().html(html);
        },

        /**
         * On update margin sample
         */
        onUpdateTextSample: function () {
            var css = "";
            var cssHover = "";

            css += this.size.generateCss(false);
            css += this.family.generateCss();
            css += this.align.generateCss();
            css += this.color.generateCss(false);
            css += this.italic.generateCss(false);
            css += this.bold.generateCss(false);
            css += this.lineHeight.generateCss(false);
            css += this.decoration.generateCss(false);
            css += this.letterSpacing.generateCss(false);
            css += this.transform.generateCss(false);

            if (this.hover.getHasHover() === true) {
                cssHover += this.size.generateCss(true);
                cssHover += this.color.generateCss(true);
                cssHover += this.italic.generateCss(true);
                cssHover += this.bold.generateCss(true);
                cssHover += this.lineHeight.generateCss(true);
                cssHover += this.decoration.generateCss(true);
                cssHover += this.letterSpacing.generateCss(true);
                cssHover += this.transform.generateCss(true);
            }

            var selector = "." + this.sample.data("selector");
            var html = "<style>";
            html += selector + "{" + css + "}";
            html += selector + ":hover{" + cssHover + "}";
            html += "</style>";
            this.sample.html(html);
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

            css += this.size.generateCss(isHover);
            css += this.family.generateCss();
            css += this.color.generateCss(isHover);
            css += this.align.generateCss();
            css += this.italic.generateCss(isHover);
            css += this.bold.generateCss(isHover);
            css += this.lineHeight.generateCss(isHover);
            css += this.decoration.generateCss(isHover);
            css += this.letterSpacing.generateCss(isHover);
            css += this.transform.generateCss(isHover);

            return css;
        },

        /**
         * Gets data
         *
         * @returns {Object}
         */
        getData: function () {
            var data = {};

            $.extend(data, this.size.getData());
            $.extend(data, this.family.getData());
            $.extend(data, this.color.getData());
            $.extend(data, this.align.getData());
            $.extend(data, this.italic.getData());
            $.extend(data, this.bold.getData());
            $.extend(data, this.lineHeight.getData());
            $.extend(data, this.decoration.getData());
            $.extend(data, this.letterSpacing.getData());
            $.extend(data, this.transform.getData());
            $.extend(data, this.hover.getData());

            return data;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
