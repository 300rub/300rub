!function ($, ss) {
    "use strict";

    var name = "adminSectionList";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsPanel",

        /**
         * Init
         */
        init: function () {
            this.create(
                {
                    group: "section",
                    controller: "list",
                    hasHeaderButtons: false
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            if (this.getData("canAdd") === true) {
                this.setFooterButton(
                    {
                        label: this.getLabel("add"),
                        icon: "fas fa-plus",
                        onClick: function () {
                            ss.init("adminSectionSettings");
                        }
                    }
                );
            } else {
                this.removeFooter();
            }

            $.each(
                this.getData("list", {}),
                $.proxy(
                    function (i, section) {
                        var icon = null;
                        if (section.isPublished === false) {
                            icon = "far fa-eye-slash";
                        }

                        if (section.isMain === true) {
                            icon = "fas fa-home";
                        }

                        var settings = null;
                        if (section.canUpdateSettings === true) {
                            settings = function () {
                                ss.init(
                                    "adminSectionSettings",
                                    {
                                        sectionId: section.id
                                    }
                                );
                            };
                        }

                        var design = null;
                        if (section.canUpdateDesign === true) {
                            design = function () {
                            };
                        }

                        var open = null;
                        if (section.canUpdateContent === true) {
                            open = function () {
                                ss.init(
                                    "adminSectionStructure",
                                    {
                                        sectionId: section.id
                                    }
                                );
                            };
                        }

                        this.addListItem(
                            {
                                label: section.name,
                                icon: icon,
                                settings: settings,
                                design: design,
                                open: open
                            }
                        );
                    },
                    this
                )
            );
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
