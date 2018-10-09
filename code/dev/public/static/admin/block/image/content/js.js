ss.add(
    "adminBlockImageContent",
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
            var data = {};
            if (this.getOption("groupId") !== null) {
                data = {
                    name: "image-content-group",
                    parent: "image-content",
                    level: 2
                };
            }

            this.create(
                $.extend(
                    {},
                    {
                        group: "image",
                        controller: "content",
                        data: {
                            id: this.getOption("blockId")
                        },
                        name: "image-content"
                    },
                    data
                )
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function() {

        },

        /**
         * On send success
         *
         * @param {Object} data
         */
        onSendSuccess: function (data) {
            console.log(data);
        }
    }
);
