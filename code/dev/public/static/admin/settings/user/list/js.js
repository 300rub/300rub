ss.add(
    "adminSettingsUserList",
    {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsWindowAbstract",

        /**
         * Init
         */
        init: function() {
            this.create(
                {
                    group: "user",
                    controller: "users",
                    name: "users",
                    hasFooter: false
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function() {
           this
               .setTable()
               .setAddButton();
        },

        /**
         * Sets table
         */
        setTable: function() {
            var table = ss.init("template").get("window-users-table");
            table.find(".name-label").text(this.getLabel("name"));
            table.find(".email-label").text(this.getLabel("email"));
            table.find(".access-label").text(this.getLabel("access"));
            var trTemplate = table.find(".tr-template");

            $.each(
                this.getData("list", {}),
                $.proxy(
                    function (i, user) {
                        var tr = trTemplate.clone();
                        tr.find(".name-value").text(user.name);
                        tr.find(".email-value").text(user.email);
                        tr.find(".access-value").text(user.access);
                        var buttons = tr.find(".buttons");
                        var btnGroup = buttons.find(".btn-group");
                        buttons.addClass("align-right");

                        if (user.canViewSessions === true) {
                            ss.init(
                                "commonComponentsFormButton",
                                {
                                    css: "btn btn-gray btn-small",
                                    icon: "fas fa-user-secret",
                                    label: this.getLabel("sessions"),
                                    appendTo: btnGroup,
                                    onClick: function () {
                                        //new ss.window.users.Sessions(
                                        //    {
                                        //        id: user.id
                                        //    }
                                        //);
                                    }
                                }
                            );
                        }

                        if (user.canUpdate === true) {
                            ss.init(
                                "commonComponentsFormButton",
                                {
                                    css: "btn btn-blue btn-small",
                                    icon: "fas fa-user-edit",
                                    label: this.getLabel("edit"),
                                    appendTo: btnGroup,
                                    onClick: function () {
                                        //new ss.window.users.Form({id: user.id});
                                    }
                                }
                            );
                        }

                        if (user.canDelete === true) {
                            ss.init(
                                "commonComponentsFormButton",
                                {
                                    css: "btn btn-red btn-small",
                                    icon: "fas fa-user-times",
                                    label: this.getLabel("deleteLabel"),
                                    appendTo: btnGroup,
                                    confirm: {
                                        text: this.getLabel("deleteUserConfirmText"),
                                        yes: {
                                            label: this.getLabel("deleteLabel"),
                                            icon: "fas fa-user-times"
                                        },
                                        no: this.getLabel("no")
                                    },
                                    ajax: {
                                        data: {
                                            group: "user",
                                            controller: "user",
                                            data: {
                                                id: user.id
                                            }
                                        },
                                        type: "DELETE",
                                        success: function () {
                                            tr.remove();
                                        }
                                    }
                                }
                            );
                        }

                        table.append(tr);
                    },
                    this
                )
            );
            trTemplate.remove();

            this.getBody().append(table);

            return this;
        },

        /**
         * Sets Add button
         */
        setAddButton: function() {
            if (this.getData("canAdd") === true) {
                ss.init(
                    "commonComponentsFormButton",
                    {
                        css: "btn btn-blue margin-bottom-15",
                        icon: "fas fa-user-plus",
                        label: this.getLabel("add"),
                        appendTo: this.getBody(),
                        onClick: function () {
                            //new ss.window.users.Form({id: 0});
                        }
                    }
                );
            }

            return this;
        }
    }
);
